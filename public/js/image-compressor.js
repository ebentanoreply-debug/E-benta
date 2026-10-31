/**
 * E-Benta Client-Side Image Compressor & Pre-Upload Optimizer
 * 
 * Automatically compresses camera and smartphone photos in the browser
 * before submission to prevent 413 (Content Too Large) errors, accelerate
 * uploads on mobile data, and protect cloud storage limits.
 */
(function(window) {
    'use strict';

    const ImageCompressor = {
        /**
         * Compress a single File object using HTML5 Canvas.
         * 
         * @param {File} file 
         * @param {Object} options 
         * @returns {Promise<File>}
         */
        compress: function(file, options) {
            options = Object.assign({
                maxWidth: 2048,
                maxHeight: 2048,
                quality: 0.82,
                maxSizeThreshold: 1.2 * 1024 * 1024, // files <= 1.2MB skip compression
                outputType: 'image/jpeg'
            }, options || {});

            return new Promise((resolve) => {
                // If not an image or already under threshold, return original
                if (!file || !file.type || !file.type.startsWith('image/') || file.size <= options.maxSizeThreshold) {
                    resolve(file);
                    return;
                }

                // Skip SVGs and GIFs (animation preservation)
                if (file.type === 'image/svg+xml' || file.type === 'image/gif') {
                    resolve(file);
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        let { width, height } = img;

                        // Calculate aspect ratio scaled dimensions
                        if (width > options.maxWidth || height > options.maxHeight) {
                            if (width / height > options.maxWidth / options.maxHeight) {
                                height = Math.round((height * options.maxWidth) / width);
                                width = options.maxWidth;
                            } else {
                                width = Math.round((width * options.maxHeight) / height);
                                height = options.maxHeight;
                            }
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');

                        // Fill white background for transparent PNGs converted to JPEG
                        if (options.outputType === 'image/jpeg') {
                            ctx.fillStyle = '#ffffff';
                            ctx.fillRect(0, 0, width, height);
                        }

                        ctx.drawImage(img, 0, 0, width, height);

                        canvas.toBlob(function(blob) {
                            if (!blob || blob.size >= file.size) {
                                // If compression didn't reduce size, keep original
                                resolve(file);
                                return;
                            }

                            const cleanName = file.name.replace(/\.[^/.]+$/, "") + (options.outputType === 'image/webp' ? '.webp' : '.jpg');
                            const compressedFile = new File([blob], cleanName, {
                                type: options.outputType,
                                lastModified: Date.now()
                            });

                            console.info(`[E-Benta Compressor] Optimized "${file.name}": ${(file.size / 1024 / 1024).toFixed(2)} MB -> ${(compressedFile.size / 1024 / 1024).toFixed(2)} MB`);
                            resolve(compressedFile);
                        }, options.outputType, options.quality);
                    };

                    img.onerror = function() {
                        resolve(file);
                    };

                    img.src = e.target.result;
                };

                reader.onerror = function() {
                    resolve(file);
                };

                reader.readAsDataURL(file);
            });
        },

        /**
         * Attach auto-compression to an HTML file input element.
         * Automatically compresses files upon selection and replaces input.files via DataTransfer.
         * 
         * @param {HTMLInputElement} inputEl
         * @param {Object} options
         */
        attachToInput: function(inputEl, options) {
            if (!inputEl) return;

            options = Object.assign({
                onStart: null,
                onComplete: null,
                maxWidth: 2048,
                maxHeight: 2048,
                quality: 0.82
            }, options || {});

            inputEl.addEventListener('change', async function(e) {
                const files = Array.from(inputEl.files || []);
                if (files.length === 0) return;

                const hasLargeImage = files.some(f => f.type && f.type.startsWith('image/') && f.size > 1.2 * 1024 * 1024);
                if (!hasLargeImage) {
                    if (typeof options.onComplete === 'function') {
                        options.onComplete(files, files);
                    }
                    return;
                }

                if (typeof options.onStart === 'function') {
                    options.onStart();
                }

                const compressedFiles = [];
                for (const file of files) {
                    if (file.type && file.type.startsWith('image/') && file.size > 1.2 * 1024 * 1024) {
                        const comp = await ImageCompressor.compress(file, options);
                        compressedFiles.push(comp);
                    } else {
                        compressedFiles.push(file);
                    }
                }

                // Update input element with compressed files using DataTransfer
                try {
                    const dt = new DataTransfer();
                    compressedFiles.forEach(f => dt.items.add(f));
                    inputEl.files = dt.files;
                } catch (err) {
                    console.warn('[E-Benta Compressor] DataTransfer update fallback: ', err);
                }

                if (typeof options.onComplete === 'function') {
                    options.onComplete(compressedFiles, files);
                }
            });
        },

        /**
         * Compress all image files in a form right before submission.
         * 
         * @param {HTMLFormElement} formEl
         * @returns {Promise<boolean>}
         */
        prepareFormForSubmit: async function(formEl) {
            if (!formEl) return true;

            const fileInputs = formEl.querySelectorAll('input[type="file"]');
            let totalSizeBytes = 0;

            for (const input of fileInputs) {
                if (!input.files || input.files.length === 0) continue;

                const files = Array.from(input.files);
                const dt = new DataTransfer();
                let modified = false;

                for (const file of files) {
                    if (file.type && file.type.startsWith('image/') && file.size > 1.2 * 1024 * 1024) {
                        const compressed = await ImageCompressor.compress(file);
                        dt.items.add(compressed);
                        totalSizeBytes += compressed.size;
                        modified = true;
                    } else {
                        dt.items.add(file);
                        totalSizeBytes += file.size;
                    }
                }

                if (modified) {
                    try {
                        input.files = dt.files;
                    } catch (e) {
                        console.warn(e);
                    }
                }
            }

            // Client-side guard against > 50MB payload
            if (totalSizeBytes > 50 * 1024 * 1024) {
                alert(`The total size of your uploaded files (${(totalSizeBytes / 1024 / 1024).toFixed(1)} MB) exceeds the 50MB single submission limit. Please upload fewer or smaller files.`);
                return false;
            }

            return true;
        }
    };

    window.ImageCompressor = ImageCompressor;
})(window);
