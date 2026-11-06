/**
 * E-Benta Mobile Web ID Camera Capture Controller
 * WebRTC camera viewfinder with card-guide framing, lens flipping, and seamless form integration.
 */
(function(window) {
    'use strict';

    const IdCamera = {
        activeStream: null,
        currentTargetInput: null,
        currentMode: 'id-card', // 'id-card' or 'selfie'
        currentFacingMode: 'environment', // 'environment' or 'user'
        capturedBlob: null,
        capturedFileName: 'id_capture.jpg',

        // Elements cache
        elements: {},

        init() {
            this.elements = {
                modal: document.getElementById('idCameraModal'),
                video: document.getElementById('idCameraVideo'),
                canvas: document.getElementById('idCameraCanvas'),
                previewImg: document.getElementById('idCameraPreviewImg'),
                guideBox: document.getElementById('idCameraGuideBox'),
                titleEl: document.getElementById('idCameraTitle'),
                tipEl: document.getElementById('idCameraTip'),
                shutterBtn: document.getElementById('idCameraShutterBtn'),
                retakeBtn: document.getElementById('idCameraRetakeBtn'),
                confirmBtn: document.getElementById('idCameraConfirmBtn'),
                flipBtn: document.getElementById('idCameraFlipBtn'),
                closeBtn: document.getElementById('idCameraCloseBtn'),
                reviewControls: document.getElementById('idCameraReviewControls'),
                shutterControls: document.getElementById('idCameraShutterControls'),
                errorBox: document.getElementById('idCameraErrorBox')
            };

            if (!this.elements.modal) return;

            // Bind actions
            if (this.elements.closeBtn) {
                this.elements.closeBtn.onclick = () => this.close();
            }
            if (this.elements.shutterBtn) {
                this.elements.shutterBtn.onclick = () => this.takeSnapshot();
            }
            if (this.elements.retakeBtn) {
                this.elements.retakeBtn.onclick = () => this.retake();
            }
            if (this.elements.confirmBtn) {
                this.elements.confirmBtn.onclick = () => this.confirmPhoto();
            }
            if (this.elements.flipBtn) {
                this.elements.flipBtn.onclick = () => this.switchCamera();
            }

            // Close on escape key
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.elements.modal && this.elements.modal.classList.contains('active')) {
                    this.close();
                }
            });
        },

        /**
         * Open Camera Viewfinder
         * @param {string} inputId - ID of target <input type="file">
         * @param {Object} options - Configuration options
         */
        async open(inputId, options = {}) {
            this.init();
            this.currentTargetInput = document.getElementById(inputId);
            if (!this.currentTargetInput) {
                console.error('Target input element not found:', inputId);
                return;
            }

            this.currentMode = options.mode || 'id-card';
            this.currentFacingMode = options.facingMode || (this.currentMode === 'selfie' ? 'user' : 'environment');
            this.capturedFileName = options.fileName || (inputId + '_capture.jpg');

            // Update UI titles and hints
            if (this.elements.titleEl) {
                this.elements.titleEl.textContent = options.title || (this.currentMode === 'selfie' ? 'Take Selfie Holding ID' : 'Capture Government ID');
            }
            if (this.elements.tipEl) {
                this.elements.tipEl.textContent = options.tip || (this.currentMode === 'selfie' ? 'Hold your government ID clearly beside your face' : 'Align your Philippine ID inside the frame');
            }

            // Adjust guide box styling for selfie vs card
            if (this.elements.guideBox) {
                if (this.currentMode === 'selfie') {
                    this.elements.guideBox.classList.add('selfie-mode');
                } else {
                    this.elements.guideBox.classList.remove('selfie-mode');
                }
            }

            // Reset review controls
            this.showShutterView();

            if (this.elements.errorBox) {
                this.elements.errorBox.style.display = 'none';
                this.elements.errorBox.innerHTML = '';
            }

            // Show modal
            if (this.elements.modal) {
                this.elements.modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Start Camera Stream
            await this.startStream();
        },

        /**
         * Request and stream camera feed
         */
        async startStream() {
            // Check WebRTC support
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                this.handleStreamFallback('WebRTC camera streaming is not supported on this browser or connection. Launching native camera intent instead...');
                return;
            }

            this.stopStream();

            const constraints = {
                audio: false,
                video: {
                    facingMode: { ideal: this.currentFacingMode },
                    width: { ideal: 1920, min: 1280 },
                    height: { ideal: 1080, min: 720 }
                }
            };

            try {
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                this.activeStream = stream;

                if (this.elements.video) {
                    this.elements.video.srcObject = stream;
                    await this.elements.video.play();
                }
            } catch (err) {
                console.warn('Primary camera stream error:', err);
                // Try looser constraints before failing
                try {
                    const fallbackStream = await navigator.mediaDevices.getUserMedia({
                        audio: false,
                        video: { facingMode: this.currentFacingMode }
                    });
                    this.activeStream = fallbackStream;
                    if (this.elements.video) {
                        this.elements.video.srcObject = fallbackStream;
                        await this.elements.video.play();
                    }
                } catch (fallbackErr) {
                    this.handleStreamFallback('Camera access denied or unavailable. You can allow camera permission in site settings, or use the native camera option.');
                }
            }
        },

        /**
         * Fallback to native OS camera shutter via HTML5 capture attribute
         */
        handleStreamFallback(message) {
            if (this.elements.errorBox) {
                this.elements.errorBox.style.display = 'block';
                this.elements.errorBox.innerHTML = `
                    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 0.75rem; padding: 1rem; color: #ffffff; font-size: 0.85rem; text-align: center; margin: 1rem;">
                        <i class="fas fa-triangle-exclamation text-danger mb-2" style="font-size: 1.5rem; display: block;"></i>
                        <p style="margin-bottom: 0.75rem;">${message}</p>
                        <button type="button" class="btn btn-sm btn-light font-weight-bold" onclick="IdCamera.triggerNativeCameraFallback()">
                            <i class="fas fa-camera me-1 text-teal"></i> Open Native Mobile Camera
                        </button>
                    </div>
                `;
            }
        },

        /**
         * Trigger native mobile camera directly
         */
        triggerNativeCameraFallback() {
            this.close();
            if (!this.currentTargetInput) return;

            // Set capture attribute temporarily if supported on mobile
            this.currentTargetInput.setAttribute('capture', this.currentFacingMode === 'user' ? 'user' : 'environment');
            this.currentTargetInput.click();
            // Clean up capture attribute after a brief delay so standard desktop uploads aren't hindered
            setTimeout(() => {
                this.currentTargetInput.removeAttribute('capture');
            }, 3000);
        },

        /**
         * Toggle between front and rear cameras
         */
        async switchCamera() {
            this.currentFacingMode = (this.currentFacingMode === 'environment') ? 'user' : 'environment';
            await this.startStream();
        },

        /**
         * Take snapshot from active video stream
         */
        takeSnapshot() {
            if (!this.elements.video || !this.elements.canvas) return;

            const video = this.elements.video;
            const canvas = this.elements.canvas;
            const width = video.videoWidth || 1280;
            const height = video.videoHeight || 720;

            canvas.width = width;
            canvas.height = height;

            const ctx = canvas.getContext('2d');
            // If user camera, un-mirror horizontal for proper document reading
            if (this.currentFacingMode === 'user') {
                ctx.translate(width, 0);
                ctx.scale(-1, 1);
            }
            ctx.drawImage(video, 0, 0, width, height);

            // Export to preview
            canvas.toBlob((blob) => {
                if (!blob) return;
                this.capturedBlob = blob;
                const previewUrl = URL.createObjectURL(blob);
                if (this.elements.previewImg) {
                    this.elements.previewImg.src = previewUrl;
                    this.elements.previewImg.style.display = 'block';
                }
                this.showReviewView();

                // Haptic feedback if supported on mobile
                if (navigator.vibrate) {
                    navigator.vibrate(40);
                }
            }, 'image/jpeg', 0.95);
        },

        /**
         * Retake snapshot
         */
        retake() {
            this.capturedBlob = null;
            if (this.elements.previewImg) {
                this.elements.previewImg.style.display = 'none';
                this.elements.previewImg.src = '';
            }
            this.showShutterView();
            if (this.elements.video) {
                this.elements.video.play().catch(() => {});
            }
        },

        /**
         * Confirm photo and pass into target file input
         */
        confirmPhoto() {
            if (!this.capturedBlob || !this.currentTargetInput) {
                this.close();
                return;
            }

            try {
                const file = new File([this.capturedBlob], this.capturedFileName, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                // Assign to input using standard DataTransfer API
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                this.currentTargetInput.files = dataTransfer.files;

                // Dispatch change event to trigger previewAndCompressDoc & OCR/QR pipeline
                this.currentTargetInput.dispatchEvent(new Event('change', { bubbles: true }));

                this.close();
            } catch (err) {
                console.error('Failed to create file from snapshot:', err);
                this.close();
            }
        },

        showShutterView() {
            if (this.elements.video) this.elements.video.style.display = 'block';
            if (this.elements.previewImg) this.elements.previewImg.style.display = 'none';
            if (this.elements.guideBox) this.elements.guideBox.style.display = 'block';
            if (this.elements.shutterControls) this.elements.shutterControls.style.display = 'flex';
            if (this.elements.reviewControls) this.elements.reviewControls.style.display = 'none';
        },

        showReviewView() {
            if (this.elements.video) this.elements.video.style.display = 'none';
            if (this.elements.previewImg) this.elements.previewImg.style.display = 'block';
            if (this.elements.guideBox) this.elements.guideBox.style.display = 'none';
            if (this.elements.shutterControls) this.elements.shutterControls.style.display = 'none';
            if (this.elements.reviewControls) this.elements.reviewControls.style.display = 'flex';
        },

        stopStream() {
            if (this.activeStream) {
                this.activeStream.getTracks().forEach(track => {
                    track.stop();
                });
                this.activeStream = null;
            }
            if (this.elements.video) {
                this.elements.video.srcObject = null;
            }
        },

        close() {
            this.stopStream();
            this.capturedBlob = null;
            if (this.elements.modal) {
                this.elements.modal.classList.remove('active');
            }
            document.body.style.overflow = '';
        }
    };

    // Export globally
    window.IdCamera = IdCamera;

    // Auto-init on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        IdCamera.init();
    });

})(window);
