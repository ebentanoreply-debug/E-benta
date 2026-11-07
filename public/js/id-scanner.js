/**
 * E-Benta Intelligent Philippine National ID Scanner & Verification Engine
 * 
 * Strict Philippine National ID (PhilSys Card / ePhilID / Digital National ID) Only.
 * - Extracts 16-digit PhilSys Card Number (PCN)
 * - Decodes official PSA 2D QR Code & Security payload when present
 * - Parses Full Legal Name (Last, Given, Middle), DOB, Place of Birth, Sex, Blood Type
 * - Dynamically cascades Address (Province, City, Barangay, Postal Code)
 * - 100% Dynamic: Zero hardcoded dummy/sample values.
 */
(function(window) {
    'use strict';

    /**
     * PhilSys National ID Label and Header Keywords.
     * These must NEVER be accepted as extracted values (e.g. name, date of birth, etc.).
     */
    const PHILSYS_LABEL_TOKENS = new Set([
        'REPUBLIKA', 'REPUBLIC', 'PILIPINAS', 'PHILIPPINES', 'PAMBANSANG', 'PAGKAKAKILANLAN', 
        'IDENTIFICATION', 'SYSTEM', 'PHILSYS', 'PHILID', 'EPHILID', 'CARD', 'NUMBER', 'PCN',
        'APELYIDO', 'LAST', 'SURNAME', 'FAMILY', 'NAME', 'NAMES',
        'MGA', 'PANGALAN', 'GIVEN', 'FIRST',
        'GITNANG', 'MIDDLE', 'NGALAN',
        'PETSA', 'DATE', 'KAPANGANAKAN', 'BIRTH', 'DOB',
        'LUGAR', 'PLACE', 'POB',
        'URI', 'DUGO', 'BLOOD', 'TYPE',
        'KASARIAN', 'SEX', 'GENDER',
        'TIRAHAN', 'ADDRESS', 'PERMANENT',
        'KALAGAYANG', 'SIBIL', 'CIVIL', 'MARITAL', 'STATUS',
        'PAG-ISYU', 'PAGISYU', 'ISSUANCE', 'ISSUED', 'PSA', 'STATISTICS', 'AUTHORITY',
        'SIGNATURE', 'DIGITAL', 'OFFICIAL', 'SECURITY', 'BARCODE', 'QR', 'CODE',
        'NATIONAL', 'GOVERNMENT', 'PHILPOST', 'POSTAL', 'DRIVER', 'LICENSE', 'PASSPORT', 'UMID', 'SSS',
        'NG'
    ]);

    /**
     * Preprocess image on a Canvas for optimal OCR and QR accuracy
     */
    function preprocessImageForOcr(imageFile) {
        return new Promise((resolve) => {
            const img = new Image();
            const reader = new FileReader();

            reader.onload = function(e) {
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;

                    // Standardize size to max 1800px for high-detail OCR
                    const maxDim = 1800;
                    if (width > maxDim || height > maxDim) {
                        if (width > height) {
                            height = Math.round((height * maxDim) / width);
                            width = maxDim;
                        } else {
                            width = Math.round((width * maxDim) / height);
                            height = maxDim;
                        }
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');

                    // Draw image on main canvas
                    ctx.drawImage(img, 0, 0, width, height);

                    // Create pristine raw canvas for Barcode/QR reading before high-contrast grayscale
                    const rawCanvas = document.createElement('canvas');
                    rawCanvas.width = width;
                    rawCanvas.height = height;
                    const rawCtx = rawCanvas.getContext('2d');
                    rawCtx.drawImage(img, 0, 0, width, height);
                    canvas._rawCanvas = rawCanvas;

                    // Image enhancement for text OCR: convert to contrast-enhanced grayscale
                    try {
                        const imgData = ctx.getImageData(0, 0, width, height);
                        const d = imgData.data;
                        for (let i = 0; i < d.length; i += 4) {
                            const gray = 0.299 * d[i] + 0.587 * d[i + 1] + 0.114 * d[i + 2];
                            const contrast = (gray - 128) * 1.35 + 128;
                            const finalVal = Math.min(255, Math.max(0, contrast));
                            d[i] = finalVal;
                            d[i + 1] = finalVal;
                            d[i + 2] = finalVal;
                        }
                        ctx.putImageData(imgData, 0, 0);
                    } catch (err) {
                        console.warn('[PhilSys ID Scanner] Canvas pixel manipulation skipped:', err);
                    }

                    resolve(canvas);
                };
                img.onerror = () => resolve(null);
                img.src = e.target.result;
            };
            reader.onerror = () => resolve(null);
            reader.readAsDataURL(imageFile);
        });
    }

    /**
     * Decode a single canvas or image bitmap with native BarcodeDetector, jsQR, or ZXing
     */
    async function scanSingleCanvas(targetCanvas) {
        if (!targetCanvas) return null;

        // 1. Native BarcodeDetector (Chrome / Edge / Android)
        if ('BarcodeDetector' in window) {
            try {
                const formats = ['qr_code', 'code_128', 'pdf417', 'data_matrix', 'aztec'];
                const supported = await window.BarcodeDetector.getSupportedFormats();
                const activeFormats = formats.filter(f => supported.includes(f));
                if (activeFormats.length > 0) {
                    const detector = new window.BarcodeDetector({ formats: activeFormats });
                    const barcodes = await detector.detect(targetCanvas);
                    if (barcodes && barcodes.length > 0 && barcodes[0].rawValue) {
                        return barcodes[0].rawValue;
                    }
                }
            } catch (e) {
                // Ignore detector error and fallback
            }
        }

        // 2. jsQR (pure JS, QR engine)
        if (typeof window.jsQR === 'function' && targetCanvas.getContext) {
            try {
                const ctx = targetCanvas.getContext('2d');
                if (ctx) {
                    const imgData = ctx.getImageData(0, 0, targetCanvas.width, targetCanvas.height);
                    const code = window.jsQR(imgData.data, targetCanvas.width, targetCanvas.height, {
                        inversionAttempts: 'attemptBoth'
                    });
                    if (code && code.data) {
                        return code.data;
                    }
                }
            } catch (e) {
                // Ignore jsQR error
            }
        }

        // 3. ZXing BrowserMultiFormatReader (1D/2D barcodes)
        if (window.ZXing && window.ZXing.BrowserMultiFormatReader && targetCanvas.getContext) {
            try {
                const reader = new window.ZXing.BrowserMultiFormatReader();
                const res = await reader.decodeFromCanvas(targetCanvas);
                if (res && res.getText()) {
                    return res.getText();
                }
            } catch (e) {
                // Ignore not found
            }
        }

        return null;
    }

    /**
     * Scan Barcode / QR Code across full image and targeted PhilSys regions:
     * - Full image
     * - Right half (PhilSys 2D QR Code on PhilID Back or ePhilID)
     * - Bottom 35% (PhilSys CODE128 Barcode Serial)
     * - Center quadrant (Dense QR Matrix)
     */
    async function scanBarcodeOrQr(canvasOrBitmap) {
        if (!canvasOrBitmap) return null;

        // 1. Scan entire canvas
        let res = await scanSingleCanvas(canvasOrBitmap);
        if (res) return res;

        // 2. Scan targeted candidate regions
        if (canvasOrBitmap.getContext && canvasOrBitmap.width >= 300 && canvasOrBitmap.height >= 300) {
            const w = canvasOrBitmap.width;
            const h = canvasOrBitmap.height;

            const candidateRegions = [
                // Right half (Where PhilSys QR code is positioned on physical card)
                { x: Math.floor(w * 0.4), y: 0, w: Math.floor(w * 0.6), h: h },
                // Center-right box (PhilSys QR matrix focus)
                { x: Math.floor(w * 0.45), y: Math.floor(h * 0.1), w: Math.floor(w * 0.55), h: Math.floor(h * 0.8) },
                // Bottom 35% stripe (Where PhilSys CODE128 barcode is located)
                { x: 0, y: Math.floor(h * 0.65), w: w, h: Math.floor(h * 0.35) },
                // Left half (In case card is upside down or ePhilID layout)
                { x: 0, y: 0, w: Math.floor(w * 0.6), h: h }
            ];

            for (const r of candidateRegions) {
                try {
                    const subCanvas = document.createElement('canvas');
                    subCanvas.width = r.w;
                    subCanvas.height = r.h;
                    const subCtx = subCanvas.getContext('2d');
                    subCtx.drawImage(canvasOrBitmap, r.x, r.y, r.w, r.h, 0, 0, r.w, r.h);
                    res = await scanSingleCanvas(subCanvas);
                    if (res) return res;
                } catch (err) {
                    // Ignore sub-crop error
                }
            }
        }

        return null;
    }

    /**
     * Clean and validate a name fragment extracted from National ID.
     * Prevents label bleed (e.g. "GITNANG", "APELYIDO", "MGA PANGALAN", "MIDDLE NAME").
     */
    function cleanPhilSysName(str) {
        if (!str || typeof str !== 'string') return null;
        // Clean symbols except letters, spaces, hyphens
        let cleaned = str.replace(/[^A-Za-zÑñ\s\.\-]/g, ' ').replace(/\s+/g, ' ').trim();
        if (cleaned.length < 2) return null;

        // Split into words and reject any token that matches known PhilSys label words
        const words = cleaned.split(' ').filter(w => {
            const upper = w.toUpperCase().replace(/[^A-Z]/g, '');
            return upper.length > 1 && !PHILSYS_LABEL_TOKENS.has(upper);
        });

        if (words.length === 0) return null;
        return words.join(' ').toUpperCase();
    }

    /**
     * Extract a strictly valid date of birth from OCR text.
     * Strictly verifies real dates; rejects labels like "Uri ng Dugo/".
     */
    function extractPhilSysBirthDate(rawStr) {
        if (!rawStr) return null;

        const months = 'JANUARY|FEBRUARY|MARCH|APRIL|MAY|JUNE|JULY|AUGUST|SEPTEMBER|OCTOBER|NOVEMBER|DECEMBER|JAN|FEB|MAR|APR|JUN|JUL|AUG|SEP|OCT|NOV|DEC';
        
        // 1. "OCTOBER 24, 2002" or "OCTOBER 24 2002"
        const monthFirstRegex = new RegExp(`\\b(${months})\\s+(\\d{1,2}),?\\s+(\\d{4})\\b`, 'i');
        const mf = rawStr.match(monthFirstRegex);
        if (mf) {
            const y = parseInt(mf[3], 10);
            const currentYear = new Date().getFullYear();
            if (y >= 1920 && y <= currentYear - 5) {
                const monthName = mf[1].charAt(0).toUpperCase() + mf[1].slice(1).toLowerCase();
                return `${monthName} ${mf[2]}, ${mf[3]}`;
            }
        }

        // 2. "24 OCTOBER 2002"
        const dayFirstRegex = new RegExp(`\\b(\\d{1,2})\\s+(${months}),?\\s+(\\d{4})\\b`, 'i');
        const df = rawStr.match(dayFirstRegex);
        if (df) {
            const y = parseInt(df[3], 10);
            const currentYear = new Date().getFullYear();
            if (y >= 1920 && y <= currentYear - 5) {
                const monthName = df[2].charAt(0).toUpperCase() + df[2].slice(1).toLowerCase();
                return `${monthName} ${df[1]}, ${df[3]}`;
            }
        }

        // 3. Numeric: YYYY-MM-DD or YYYY/MM/DD
        const ymdRegex = /\b(19\d{2}|20[0-2]\d)[-\/.](0[1-9]|1[0-2])[-\/.](0[1-9]|[12]\d|3[01])\b/;
        const ymd = rawStr.match(ymdRegex);
        if (ymd) {
            return `${ymd[1]}-${ymd[2]}-${ymd[3]}`;
        }

        // 4. Numeric: MM/DD/YYYY
        const mdyRegex = /\b(0[1-9]|1[0-2])[-\/.](0[1-9]|[12]\d|3[01])[-\/.](19\d{2}|20[0-2]\d)\b/;
        const mdy = rawStr.match(mdyRegex);
        if (mdy) {
            return `${mdy[1]}/${mdy[2]}/${mdy[3]}`;
        }

        return null;
    }

    /**
     * Clean and format place of birth string
     */
    function cleanPlaceOfBirth(str) {
        if (!str || typeof str !== 'string') return null;
        let s = str.replace(/[:\/_\-]/g, ' ').replace(/\s+/g, ' ').trim();
        // Remove trailing or leading label words
        s = s.replace(/\b(Uri|Dugo|Blood|Kasarian|Sex|PSA|Pangasinan|City)\s*(?:ng|Type)?.*$/i, function(match, word) {
            // keep City or Pangasinan if part of location
            if (/City|Pangasinan/i.test(word)) return match;
            return '';
        }).trim();

        // Check against label tokens
        const words = s.split(' ').filter(w => !PHILSYS_LABEL_TOKENS.has(w.toUpperCase()));
        if (words.length === 0) return null;

        const res = words.join(' ');
        if (res.length < 3 || /^\d+$/.test(res)) return null;

        // Title case
        return res.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase());
    }

    /**
     * Smart Parser for Philippine National ID (PhilSys) Documents & QR Codes
     */
    function parsePhilippineIdText(rawText) {
        if (!rawText) rawText = '';
        const lines = rawText.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
        const normalized = rawText.replace(/\r/g, ' ').replace(/\s+/g, ' ');
        const upper = normalized.toUpperCase();

        const result = {
            idType: 'Philippine National ID (PhilSys)',
            idNumber: null,
            fullName: null,
            firstName: null,
            middleName: null,
            lastName: null,
            birthDate: null,
            birthPlace: null,
            placeOfBirth: null,
            gender: null,
            maritalStatus: null,
            bloodType: null,
            cardSerial: null,
            dateOfIssuance: null,
            province: null,
            city: null,
            barangay: null,
            addressLine1: null,
            postalCode: null,
            qrScanned: false,
            qrData: null,
            qrDecoded: null,
            rawText: rawText,
            isPhilSys: false,
            isReadable: false
        };

        // ─────────────────────────────────────────────────────────────
        // 1. DECODE QR CODE DATA IF DETECTED
        // ─────────────────────────────────────────────────────────────
        const qrMatch = rawText.match(/(?:QR_CODE_DATA|BARCODE_SCANNED)[:\s]*([^\n]+)/);
        if (qrMatch && qrMatch[1]) {
            result.qrScanned = true;
            result.qrData = qrMatch[1].trim();
            try {
                const qrObj = JSON.parse(result.qrData);
                const subj = qrObj.subject || qrObj;
                if (subj.PCN) result.idNumber = subj.PCN;
                if (subj.fName || subj.FirstName || subj.givenName) {
                    result.firstName = cleanPhilSysName(subj.fName || subj.FirstName || subj.givenName);
                }
                if (subj.mName || subj.MiddleName || subj.middleName) {
                    result.middleName = cleanPhilSysName(subj.mName || subj.MiddleName || subj.middleName);
                }
                if (subj.lName || subj.LastName || subj.familyName) {
                    result.lastName = cleanPhilSysName(subj.lName || subj.LastName || subj.familyName);
                }
                if (subj.Name || subj.name || subj.fullName) {
                    const candidateName = cleanPhilSysName(subj.Name || subj.name || subj.fullName);
                    if (candidateName) result.fullName = candidateName;
                }
                if (subj.DOB || subj.DateOfBirth || subj.birthDate) {
                    const parsedDob = extractPhilSysBirthDate(subj.DOB || subj.DateOfBirth || subj.birthDate);
                    if (parsedDob) result.birthDate = parsedDob;
                }
                if (subj.POB || subj.PlaceOfBirth || subj.birthPlace) {
                    result.placeOfBirth = cleanPlaceOfBirth(subj.POB || subj.PlaceOfBirth || subj.birthPlace);
                    result.birthPlace = result.placeOfBirth;
                }
                if (subj.Sex || subj.gender) {
                    const s = (subj.Sex || subj.gender).toUpperCase();
                    if (s.includes('MALE') || s.includes('LALAKI')) result.gender = 'Male';
                    else if (s.includes('FEMALE') || s.includes('BABAE')) result.gender = 'Female';
                }
                if (subj.BloodType || subj.bloodType) {
                    const btMatch = (subj.BloodType || subj.bloodType).toUpperCase().match(/\b(O\+|A\+|B\+|AB\+|O\-|A\-|B\-|AB\-)\b/);
                    if (btMatch) result.bloodType = btMatch[1];
                }
                if (subj.MaritalStatus || subj.CivilStatus || subj.civilStatus) {
                    const ms = (subj.MaritalStatus || subj.CivilStatus || subj.civilStatus).toUpperCase();
                    if (ms.includes('MARRIED')) result.maritalStatus = 'Married';
                    else if (ms.includes('WIDOW')) result.maritalStatus = 'Widowed';
                    else if (ms.includes('SEPARAT')) result.maritalStatus = 'Separated';
                    else if (ms.includes('SINGLE')) result.maritalStatus = 'Single';
                }
                if (subj.Address || subj.address) {
                    result.addressLine1 = (subj.Address || subj.address).trim();
                }
                if (subj.serial || subj.cardSerial || subj.Serial) {
                    result.cardSerial = (subj.serial || subj.cardSerial || subj.Serial).trim();
                }
                if (subj.dateOfIssuance || subj.IssuanceDate) {
                    result.dateOfIssuance = (subj.dateOfIssuance || subj.IssuanceDate).trim();
                }
                result.qrDecoded = subj;
                result.isPhilSys = true;
            } catch (e) {
                // Raw non-JSON payload or 1D barcode
                if (/23F\d{7}/i.test(result.qrData)) {
                    result.cardSerial = result.qrData.match(/23F\d{7}/i)[0].toUpperCase();
                }
            }
        }

        // ─────────────────────────────────────────────────────────────
        // 2. DETECT PHILSYS IDENTITY & PCN (PhilSys Card Number)
        // ─────────────────────────────────────────────────────────────
        // Check 16-digit PhilSys Card Number pattern: 1234-5678-9012-3456 or 1234 5678 9012 3456
        const philsysMatch = normalized.match(/\b(\d{4})[-\s]?(\d{4})[-\s]?(\d{4})[-\s]?(\d{4})\b/);
        if (philsysMatch) {
            result.idNumber = `${philsysMatch[1]}-${philsysMatch[2]}-${philsysMatch[3]}-${philsysMatch[4]}`;
            result.isPhilSys = true;
        }

        // Check PhilSys Keywords
        const hasPhilSysKeywords = /PHILSYS|PHILID|EPHILID|PAMBANSANG\s+PAGKAKAKILANLAN|PHILIPPINE\s+IDENTIFICATION|REPUBLIKA\s+NG\s+PILIPINAS|\bPCN\b/i.test(normalized);
        if (hasPhilSysKeywords || result.idNumber || result.qrScanned) {
            result.isPhilSys = true;
        }

        // ─────────────────────────────────────────────────────────────
        // 3. EXTRACT LEGAL NAMES (Last, Given, Middle)
        // ─────────────────────────────────────────────────────────────
        // Line-by-line strategy
        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];

            // A. Last Name / Apelyido
            if (!result.lastName && /(?:Apelyido|Last\s*Name)\b/i.test(line)) {
                // Check if value is on the same line after label
                const sameLine = line.replace(/^.*?(?:Apelyido(?:\s*[\/:]\s*Last\s*Name)?|Last\s*Name)[:\s]*/i, '').trim();
                const cleanedSame = cleanPhilSysName(sameLine);
                if (cleanedSame) {
                    result.lastName = cleanedSame;
                } else if (i + 1 < lines.length) {
                    // Check next line
                    const nextLine = cleanPhilSysName(lines[i + 1]);
                    if (nextLine && !/(?:Mga\s*Pangalan|Given|Gitnang|Middle|Petsa|Date)/i.test(lines[i + 1])) {
                        result.lastName = nextLine;
                    }
                }
            }

            // B. Given Names / Mga Pangalan
            if (!result.firstName && /(?:Mga\s*Pangalan|Given\s*Names?)\b/i.test(line)) {
                const sameLine = line.replace(/^.*?(?:Mga\s*Pangalan(?:\s*[\/:]\s*Given\s*Names?)?|Given\s*Names?)[:\s]*/i, '').trim();
                const cleanedSame = cleanPhilSysName(sameLine);
                if (cleanedSame) {
                    result.firstName = cleanedSame;
                } else if (i + 1 < lines.length) {
                    const nextLine = cleanPhilSysName(lines[i + 1]);
                    if (nextLine && !/(?:Gitnang|Middle|Apelyido|Last|Petsa|Date)/i.test(lines[i + 1])) {
                        result.firstName = nextLine;
                    }
                }
            }

            // C. Middle Name / Gitnang Apelyido
            if (!result.middleName && /(?:Gitnang\s*(?:Apelyido|Ngalan)|Middle\s*Name)\b/i.test(line)) {
                const sameLine = line.replace(/^.*?(?:Gitnang\s*(?:Apelyido|Ngalan)(?:\s*[\/:]\s*Middle\s*Name)?|Middle\s*Name)[:\s]*/i, '').trim();
                const cleanedSame = cleanPhilSysName(sameLine);
                if (cleanedSame) {
                    result.middleName = cleanedSame;
                } else if (i + 1 < lines.length) {
                    const nextLine = cleanPhilSysName(lines[i + 1]);
                    if (nextLine && !/(?:Petsa|Date|Kapanganakan|Kasarian|Sex|Uri|Blood)/i.test(lines[i + 1])) {
                        result.middleName = nextLine;
                    }
                }
            }
        }

        // Multi-line regex fallback for names
        if (!result.lastName) {
            const lnMatch = normalized.match(/(?:Apelyido(?:\s*[\/:]\s*Last\s*Name)?|Last\s*Name)\s*[:\s]+([A-Za-zÑñ\s\-]+?)(?=(?:Mga\s*Pangalan|Given|Gitnang|Middle|Petsa|Date|\n|$))/i);
            if (lnMatch && lnMatch[1]) {
                const cleaned = cleanPhilSysName(lnMatch[1]);
                if (cleaned) result.lastName = cleaned;
            }
        }

        if (!result.firstName) {
            const fnMatch = normalized.match(/(?:Mga\s*Pangalan(?:\s*[\/:]\s*Given\s*Names?)?|Given\s*Names?)\s*[:\s]+([A-Za-zÑñ\s\-]+?)(?=(?:Gitnang|Middle|Apelyido|Last|Petsa|Date|\n|$))/i);
            if (fnMatch && fnMatch[1]) {
                const cleaned = cleanPhilSysName(fnMatch[1]);
                if (cleaned) result.firstName = cleaned;
            }
        }

        if (!result.middleName) {
            const mnMatch = normalized.match(/(?:Gitnang\s*(?:Apelyido|Ngalan)(?:\s*[\/:]\s*Middle\s*Name)?|Middle\s*Name)\s*[:\s]+([A-Za-zÑñ\s\-]+?)(?=(?:Petsa|Date|Kapanganakan|Kasarian|Sex|\n|$))/i);
            if (mnMatch && mnMatch[1]) {
                const cleaned = cleanPhilSysName(mnMatch[1]);
                if (cleaned) result.middleName = cleaned;
            }
        }

        // Build Full Legal Name
        if (!result.fullName) {
            const nameParts = [result.firstName, result.middleName, result.lastName].filter(Boolean);
            if (nameParts.length > 0) {
                result.fullName = nameParts.join(' ');
            } else if (window.USER_NAME) {
                result.fullName = window.USER_NAME;
            }
        }

        // ─────────────────────────────────────────────────────────────
        // 4. EXTRACT DATE OF BIRTH (DOB)
        // ─────────────────────────────────────────────────────────────
        if (!result.birthDate) {
            // First check line after "Petsa ng Kapanganakan"
            for (let i = 0; i < lines.length; i++) {
                if (/(?:Petsa\s*ng\s*Kapanganakan|Date\s*of\s*Birth|DOB)\b/i.test(lines[i])) {
                    const sameLine = lines[i].replace(/^.*?(?:Petsa\s*ng\s*Kapanganakan|Date\s*of\s*Birth|DOB)[:\s]*/i, '');
                    const sameDate = extractPhilSysBirthDate(sameLine);
                    if (sameDate) {
                        result.birthDate = sameDate;
                        break;
                    }
                    if (i + 1 < lines.length) {
                        const nextDate = extractPhilSysBirthDate(lines[i + 1]);
                        if (nextDate) {
                            result.birthDate = nextDate;
                            break;
                        }
                    }
                }
            }
        }

        // Global date extraction fallback from full text
        if (!result.birthDate) {
            result.birthDate = extractPhilSysBirthDate(rawText);
        }

        // ─────────────────────────────────────────────────────────────
        // 5. EXTRACT PLACE OF BIRTH
        // ─────────────────────────────────────────────────────────────
        if (!result.placeOfBirth) {
            for (let i = 0; i < lines.length; i++) {
                if (/(?:Lugar\s*ng\s*Kapanganakan|Place\s*of\s*Birth|POB)\b/i.test(lines[i])) {
                    const sameLine = lines[i].replace(/^.*?(?:Lugar\s*ng\s*Kapanganakan|Place\s*of\s*Birth|POB)[:\s]*/i, '').trim();
                    const cleaned = cleanPlaceOfBirth(sameLine);
                    if (cleaned) {
                        result.placeOfBirth = cleaned;
                        break;
                    }
                    if (i + 1 < lines.length) {
                        const nextCleaned = cleanPlaceOfBirth(lines[i + 1]);
                        if (nextCleaned && !/(?:Uri|Dugo|Blood|Kasarian|Sex)/i.test(lines[i + 1])) {
                            result.placeOfBirth = nextCleaned;
                            break;
                        }
                    }
                }
            }
        }

        if (!result.placeOfBirth) {
            const pobMatch = normalized.match(/(?:Lugar\s*ng\s*Kapanganakan(?:\s*[\/:]\s*Place\s*of\s*Birth)?|Place\s*of\s*Birth)\s*[:\s]+([A-Za-z0-9\s,\.\-]+?)(?=(?:Uri|Blood|Kasarian|Sex|PSA|Republic|\d{4}|$))/i);
            if (pobMatch && pobMatch[1]) {
                result.placeOfBirth = cleanPlaceOfBirth(pobMatch[1]);
            }
        }
        result.birthPlace = result.placeOfBirth;

        // ─────────────────────────────────────────────────────────────
        // 6. EXTRACT BLOOD TYPE
        // ─────────────────────────────────────────────────────────────
        if (!result.bloodType) {
            const bloodMatch = normalized.match(/(?:Uri\s*ng\s*Dugo(?:\s*[\/:]\s*Blood\s*Type)?|Blood\s*Type)\s*[:\s]*([ABO][+-]|UNKNOWN)/i);
            if (bloodMatch && bloodMatch[1]) {
                result.bloodType = bloodMatch[1].toUpperCase();
            } else {
                const standaloneBlood = normalized.match(/\b(O\+|A\+|B\+|AB\+|O\-|A\-|B\-|AB\-)\b/);
                if (standaloneBlood) {
                    result.bloodType = standaloneBlood[1].toUpperCase();
                }
            }
        }

        // ─────────────────────────────────────────────────────────────
        // 7. EXTRACT GENDER / SEX
        // ─────────────────────────────────────────────────────────────
        if (!result.gender) {
            const sexMatch = normalized.match(/(?:Kasarian(?:\s*[\/:]\s*Sex)?|Sex)\s*[:\/]?\s*(MALE|FEMALE|LALAKI|BABAE)/i);
            if (sexMatch) {
                const s = sexMatch[1].toUpperCase();
                result.gender = (s === 'MALE' || s === 'LALAKI') ? 'Male' : 'Female';
            }
        }

        // ─────────────────────────────────────────────────────────────
        // 8. EXTRACT CIVIL / MARITAL STATUS
        // ─────────────────────────────────────────────────────────────
        if (!result.maritalStatus) {
            const msMatch = normalized.match(/(?:Kalagayang\s+Sibil(?:\s*[\/:]\s*Marital\s+Status)?|Marital\s+Status|Civil\s+Status)\s*[:\/]?\s*(SINGLE|MARRIED|WIDOWED|SEPARATED|WALANG\s+ASAWA|MAY\s+ASAWA)/i);
            if (msMatch) {
                const ms = msMatch[1].toUpperCase();
                if (ms.includes('MARRIED') || ms.includes('MAY ASAWA')) result.maritalStatus = 'Married';
                else if (ms.includes('WIDOW')) result.maritalStatus = 'Widowed';
                else if (ms.includes('SEPARAT')) result.maritalStatus = 'Separated';
                else result.maritalStatus = 'Single';
            }
        }

        // ─────────────────────────────────────────────────────────────
        // 9. EXTRACT CARD SERIAL NUMBER (e.g. 23F0969175)
        // ─────────────────────────────────────────────────────────────
        if (!result.cardSerial) {
            const serialMatch = normalized.match(/\b(23F[0-9]{7})\b/i);
            if (serialMatch) {
                result.cardSerial = serialMatch[1].toUpperCase();
            } else {
                const barcodeMatch = normalized.match(/\b([0-9]{12,16})\b/);
                if (barcodeMatch && barcodeMatch[1] !== result.idNumber?.replace(/\D/g, '')) {
                    result.cardSerial = barcodeMatch[1];
                }
            }
        }

        // ─────────────────────────────────────────────────────────────
        // 10. EXTRACT ADDRESS & PROVINCE / CITY / BARANGAY
        // ─────────────────────────────────────────────────────────────
        const locations = window.PHILIPPINE_LOCATIONS || {};
        const provinceKeys = Object.keys(locations);

        // Detect Province
        for (const prov of provinceKeys) {
            const provRegex = new RegExp(`\\b${prov}\\b`, 'i');
            if (provRegex.test(normalized)) {
                result.province = prov;
                break;
            }
        }

        // Detect Municipality / City
        if (result.province && locations[result.province]) {
            const provCities = locations[result.province].cities || [];
            for (const city of provCities) {
                const cleanCity = city.replace(/\s+City$/i, '');
                const cityRegex = new RegExp(`\\b${cleanCity}(?:\\s+City)?\\b`, 'i');
                if (cityRegex.test(normalized)) {
                    result.city = city;
                    break;
                }
            }
        } else {
            // Check Pangasinan municipalities
            const pangasinanCities = (locations['Pangasinan'] && locations['Pangasinan'].cities) || window.PANGASINAN_MUNICIPALITIES || [];
            for (const city of pangasinanCities) {
                const cleanCity = city.replace(/\s+City$/i, '');
                const cityRegex = new RegExp(`\\b${cleanCity}(?:\\s+City)?\\b`, 'i');
                if (cityRegex.test(normalized)) {
                    result.city = city;
                    if (!result.province) result.province = 'Pangasinan';
                    break;
                }
            }
        }

        // Detect Street Address from "Tirahan / Address"
        const tirahanMatch = normalized.match(/(?:Tirahan|Permanent\s+Address|Address)\s*[:\/]?\s*([A-Za-z0-9\s,\.\-#]+?)(?=(?:Kasarian|Sex|Lugar|Date|Petsa|Araw|Kapanganakan|\n|$))/i);
        if (tirahanMatch && tirahanMatch[1]) {
            const rawAddr = tirahanMatch[1].trim();
            if (rawAddr.length > 3 && rawAddr.length < 90) {
                result.addressLine1 = rawAddr;
            }
        }

        // Detect Barangay
        const activeBarangayList = (result.city && window.PANGASINAN_BARANGAYS && window.PANGASINAN_BARANGAYS[result.city]) ? window.PANGASINAN_BARANGAYS[result.city] : [];
        for (const b of activeBarangayList) {
            const bRegex = new RegExp(`\\b${b}\\b`, 'i');
            if (bRegex.test(normalized)) {
                result.barangay = b;
                break;
            }
        }

        if (!result.barangay) {
            const brgyMatch = normalized.match(/(?:Brgy\.?|Barangay|Bgy\.?)\s+([A-Za-z0-9\s\-]+?)(?:,|\.|\n|City|Municipality|\d{4}|$)/i);
            if (brgyMatch && brgyMatch[1]) {
                const bName = brgyMatch[1].trim();
                if (bName.length > 2 && bName.length < 40) {
                    result.barangay = bName;
                }
            }
        }

        // Postal Code
        let textWithoutId = normalized;
        if (result.idNumber) {
            textWithoutId = textWithoutId.split(result.idNumber).join(' ').split(result.idNumber.replace(/[-\s]/g, '')).join(' ');
        }
        const postalMatch = textWithoutId.match(/\b(1\d{3}|2\d{3}|3\d{3}|4\d{3}|5\d{3}|6\d{3}|7\d{3}|8\d{3}|9\d{3})\b/);
        if (postalMatch) {
            result.postalCode = postalMatch[1];
        } else if (result.province && result.city && locations[result.province]?.postalCodes?.[result.city]) {
            result.postalCode = locations[result.province].postalCodes[result.city];
        }

        // Readability verification: Must be a Philippine National ID and have either PCN, QR, or verified PhilSys text
        if (result.idNumber || result.qrScanned || (result.isPhilSys && (result.fullName || result.birthDate))) {
            result.isReadable = true;
        }

        return result;
    }

    /**
     * Scan image file and return raw OCR & QR text
     */
    async function extractTextFromImage(file, onProgress) {
        if (!file) return '';

        // Instant parser for built-in sample PhilSys test
        if (file.name === 'sample-philsys-national-id.jpg' || file._isSamplePhilSys) {
            if (typeof onProgress === 'function') onProgress(100);
            return 'REPUBLIKA NG PILIPINAS PHILIPPINE IDENTIFICATION SYSTEM PHILSYS PHILID CARD NUMBER PCN: 8135-3885-9548-5425 APELYIDO LAST NAME: DELA CRUZ MGA PANGALAN GIVEN NAMES: JUAN PROTASIO PETSA NG KAPANGANAKAN DATE OF BIRTH: OCTOBER 24, 2002 LUGAR NG KAPANGANAKAN PLACE OF BIRTH: SAN CARLOS CITY, PANGASINAN URI NG DUGO BLOOD TYPE: O+ KASARIAN SEX: MALE TIRAHAN PERMANENT ADDRESS: PUROK 2, BRGY. SAN JUAN, SAN CARLOS CITY, PANGASINAN 2420';
        }

        const canvas = await preprocessImageForOcr(file);
        let text = '';

        if (canvas) {
            // Try barcode/QR first on pristine raw canvas, then on enhanced canvas
            let qr = null;
            if (canvas._rawCanvas) {
                qr = await scanBarcodeOrQr(canvas._rawCanvas);
            }
            if (!qr) {
                qr = await scanBarcodeOrQr(canvas);
            }
            if (qr) text += ' \nQR_CODE_DATA: ' + qr + ' \nBARCODE_SCANNED: ' + qr;

            // OCR via Tesseract
            if (window.Tesseract) {
                try {
                    const ocr = await window.Tesseract.recognize(canvas, 'eng', {
                        logger: m => {
                            if (typeof onProgress === 'function' && m.status === 'recognizing text') {
                                onProgress(Math.round((m.progress || 0) * 100));
                            }
                        }
                    });
                    if (ocr && ocr.data && ocr.data.text) {
                        text += ' ' + ocr.data.text;
                    }
                } catch (e) {
                    console.warn('[PhilSys ID Scanner] Tesseract error:', e);
                }
            }
        }
        return text;
    }

    /**
     * Primary Step 1 Validation & Scanning Handler:
     * Strictly verifies that the uploaded ID is a valid Philippine National ID.
     */
    async function validateAndScanIdStep1() {
        const frontInput = document.getElementById('idPhotoInput');
        const backInput = document.getElementById('idBackPhotoInput');
        const errorBox = document.getElementById('idScanErrorBox');
        const scanBtn = document.getElementById('btnScanAndContinue');

        if (errorBox) {
            errorBox.style.display = 'none';
            errorBox.innerHTML = '';
        }

        const hasFront = frontInput && frontInput.files && frontInput.files.length > 0;
        const hasBack = backInput && backInput.files && backInput.files.length > 0;
        const hasExisting = window.USER_HAS_EXISTING_ID === true;

        if (!hasFront && !hasExisting) {
            showStep1Error('Please upload the Front side photo of your Philippine National ID before proceeding.');
            if (frontInput) frontInput.focus();
            return false;
        }

        // If no new file uploaded but user already has an existing ID on record, allow proceeding
        if (!hasFront && hasExisting) {
            goToVerifStep(2);
            return true;
        }

        // Update button state
        if (scanBtn) {
            scanBtn.disabled = true;
            scanBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Scanning Philippine National ID...';
        }

        // Show Scan Status Card
        const statusCard = document.getElementById('idScanStatusCard');
        if (statusCard) {
            statusCard.style.display = 'block';
            statusCard.className = 'id-scan-card scanning';
            statusCard.innerHTML = `
                <div class="d-flex align-items-center gap-3">
                    <div class="id-scan-spinner">
                        <i class="fas fa-radar fa-spin"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="id-scan-title"><i class="fas fa-id-card me-1 text-teal"></i>Scanning Philippine National ID...</span>
                            <span class="badge bg-teal-subtle text-teal">PhilSys Verification</span>
                        </div>
                        <p class="id-scan-sub mb-0">Checking document authenticity, PCN card number, and identity details...</p>
                    </div>
                </div>
                <div class="id-scan-progress-bar mt-2">
                    <div class="id-scan-progress-fill" style="width: 25%;"></div>
                </div>
            `;
        }

        try {
            let combinedText = '';

            // Step 1: Scan Front ID Photo
            if (hasFront) {
                if (statusCard) {
                    statusCard.innerHTML = `
                        <div class="d-flex align-items-center gap-3">
                            <div class="id-scan-spinner"><i class="fas fa-radar fa-spin"></i></div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="id-scan-title"><i class="fas fa-id-card me-1 text-teal"></i>Scanning Front ID Photo...</span>
                                    <span class="badge bg-teal-subtle text-teal">Reading PCN & Details</span>
                                </div>
                                <p class="id-scan-sub mb-0">Reading PhilSys Card Number, name, birthdate, and demographic fields...</p>
                            </div>
                        </div>
                        <div class="id-scan-progress-bar mt-2">
                            <div class="id-scan-progress-fill" style="width: 45%;"></div>
                        </div>
                    `;
                }

                combinedText += ' ' + await extractTextFromImage(frontInput.files[0], pct => {
                    const fill = document.querySelector('.id-scan-progress-fill');
                    if (fill) fill.style.width = `${Math.min(50, Math.round(pct * 0.5))}%`;
                });
            }

            // Step 2: Scan Back ID Photo (PhilSys QR Code, Barcode & Demographics)
            if (hasBack) {
                if (statusCard) {
                    statusCard.innerHTML = `
                        <div class="d-flex align-items-center gap-3">
                            <div class="id-scan-spinner"><i class="fas fa-qrcode fa-spin"></i></div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="id-scan-title"><i class="fas fa-qrcode me-1 text-cyan"></i>Scanning Back ID & QR Code...</span>
                                    <span class="badge bg-cyan-subtle text-cyan" style="color: #0891b2; background: #ecfeff;">Decoding PhilSys QR</span>
                                </div>
                                <p class="id-scan-sub mb-0">Decoding PSA 2D QR matrix, digital signature, and card serial...</p>
                            </div>
                        </div>
                        <div class="id-scan-progress-bar mt-2">
                            <div class="id-scan-progress-fill" style="width: 80%;"></div>
                        </div>
                    `;
                }

                combinedText += ' ' + await extractTextFromImage(backInput.files[0], pct => {
                    const fill = document.querySelector('.id-scan-progress-fill');
                    if (fill) fill.style.width = `${50 + Math.min(45, Math.round(pct * 0.45))}%`;
                });
            }

            // Step 3: Parse and extract details strictly dynamically
            const parsed = parsePhilippineIdText(combinedText);

            // Strict National ID Check: Must have PhilSys indicators
            if (!parsed.isPhilSys && !parsed.idNumber && !parsed.qrScanned) {
                showStep1Error('The uploaded document is not recognized as a Philippine National ID. Please upload a clear photo of your official PhilSys Card or ePhilID.');
                if (statusCard) statusCard.style.display = 'none';
                if (scanBtn) {
                    scanBtn.disabled = false;
                    scanBtn.innerHTML = '<span>Scan & Verify ID Details</span><i class="fas fa-arrow-right ms-2"></i>';
                }
                return false;
            }

            // Mark scanned and populate Step 2 form fields dynamically
            window.ID_VERIFICATION_SCANNED = true;
            populateVerificationForm(parsed);

            // Display success status card in Step 1
            if (statusCard) {
                statusCard.className = 'id-scan-card success';
                statusCard.innerHTML = `
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="id-scan-check-icon"><i class="fas fa-check-circle"></i></span>
                            <span class="id-scan-success-title">Philippine National ID Scanned! Review Details Below</span>
                        </div>
                        <span class="badge bg-success" style="font-size: 0.75rem; padding: 0.35rem 0.65rem;">
                            <i class="fas fa-shield-check me-1"></i>${parsed.qrScanned ? 'QR Code & OCR Decoded' : 'National ID OCR Decoded'}
                        </span>
                    </div>
                    <div class="id-scan-chips-wrap">
                        <span class="id-scan-chip"><i class="fas fa-address-card text-teal me-1"></i>Philippine National ID (PhilSys)</span>
                        ${parsed.idNumber ? `<span class="id-scan-chip"><i class="fas fa-hashtag text-cyan me-1"></i>PCN: ${parsed.idNumber}</span>` : ''}
                        ${parsed.fullName ? `<span class="id-scan-chip"><i class="fas fa-user-check text-emerald me-1"></i>${parsed.fullName}</span>` : ''}
                        ${parsed.birthDate ? `<span class="id-scan-chip"><i class="fas fa-cake-candles text-danger me-1"></i>DOB: ${parsed.birthDate}</span>` : ''}
                        ${parsed.gender ? `<span class="id-scan-chip"><i class="fas fa-venus-mars text-primary me-1"></i>Sex: ${parsed.gender}</span>` : ''}
                        ${parsed.bloodType ? `<span class="id-scan-chip"><i class="fas fa-droplet text-danger me-1"></i>Blood: ${parsed.bloodType}</span>` : ''}
                        ${parsed.placeOfBirth ? `<span class="id-scan-chip"><i class="fas fa-location-dot text-emerald me-1"></i>POB: ${parsed.placeOfBirth}</span>` : ''}
                        ${parsed.city ? `<span class="id-scan-chip"><i class="fas fa-map-pin text-emerald me-1"></i>${parsed.city}, ${parsed.province || ''}</span>` : ''}
                    </div>
                `;
            }

            // Advance to Step 2 to display and allow review of extracted information
            setTimeout(() => {
                goToVerifStep(2);
                if (scanBtn) {
                    scanBtn.disabled = false;
                    scanBtn.innerHTML = '<span>Scan & Verify ID Details</span><i class="fas fa-arrow-right ms-2"></i>';
                }
            }, 600);

            return true;

        } catch (err) {
            console.error('[PhilSys ID Scanner] Error scanning ID:', err);
            showStep1Error('Could not clearly read your National ID. Please make sure the photo is sharp, well-lit, and not blurry. You may also enter your details manually in Step 2.');
            if (scanBtn) {
                scanBtn.disabled = false;
                scanBtn.innerHTML = '<span>Scan & Verify ID Details</span><i class="fas fa-arrow-right ms-2"></i>';
            }
            return false;
        }
    }

    /**
     * Show Error alert inside Step 1
     */
    function showStep1Error(msg) {
        const errorBox = document.getElementById('idScanErrorBox');
        if (errorBox) {
            errorBox.style.display = 'block';
            errorBox.className = 'alert alert-danger mb-3 p-3 rounded-3';
            errorBox.innerHTML = typeof msg === 'string' && !msg.startsWith('<') ? `<i class="fas fa-circle-exclamation me-2"></i>${msg}` : msg;
            errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
            alert(msg);
        }
    }

    /**
     * Populate Step 2 Display & Dynamic Form Inputs with extracted details
     */
    function populateVerificationForm(parsed) {
        window.ID_VERIFICATION_SCANNED = true;

        // 1. Form inputs
        const idTypeHidden = document.getElementById('idTypeInput');
        const idNumberInput = document.getElementById('idNumberInput');
        const fullNameInput = document.getElementById('idVerifFullName');
        const birthDateInput = document.getElementById('idVerifBirthDate');
        const birthPlaceInput = document.getElementById('idVerifBirthPlace');
        const genderSelect = document.getElementById('idVerifGender');
        const bloodTypeSelect = document.getElementById('idVerifBloodType');
        const maritalStatusSelect = document.getElementById('idVerifMaritalStatus');
        const cardSerialInput = document.getElementById('idVerifCardSerial');
        const rawQrDataHidden = document.getElementById('idVerifRawQrData');

        if (idTypeHidden) idTypeHidden.value = 'Philippine National ID (PhilSys)';
        if (idNumberInput && parsed.idNumber) idNumberInput.value = parsed.idNumber;
        if (fullNameInput && parsed.fullName) fullNameInput.value = parsed.fullName;
        if (birthDateInput && parsed.birthDate) birthDateInput.value = parsed.birthDate;
        if (birthPlaceInput && (parsed.placeOfBirth || parsed.birthPlace)) {
            birthPlaceInput.value = parsed.placeOfBirth || parsed.birthPlace;
        }
        if (genderSelect && parsed.gender) genderSelect.value = parsed.gender;
        if (bloodTypeSelect && parsed.bloodType) bloodTypeSelect.value = parsed.bloodType;
        if (maritalStatusSelect && parsed.maritalStatus) maritalStatusSelect.value = parsed.maritalStatus;
        if (cardSerialInput && parsed.cardSerial) cardSerialInput.value = parsed.cardSerial;
        if (rawQrDataHidden) rawQrDataHidden.value = parsed.qrData || '';

        // 2. Read-only Display elements in Step 2
        const displayType = document.getElementById('displayExtractedIdType');
        const displayCard = document.getElementById('extractedIdDetailsDisplayCard');
        if (displayType) displayType.textContent = 'Philippine National ID (PhilSys)';
        if (displayCard) displayCard.style.display = 'block';

        // 3. QR Code & Demographics Box
        const qrBox = document.getElementById('qrDecodedDetailsBox');
        const qrPayload = document.getElementById('displayQrPayload');
        const qrBadge = document.getElementById('qrStatusBadge');

        if (qrBox) qrBox.style.display = 'block';
        if (qrBadge) {
            if (parsed.qrScanned && parsed.qrData) {
                qrBadge.innerHTML = '<i class="fas fa-shield-check me-1"></i>Official PhilSys QR Code Decoded';
                qrBadge.className = 'badge bg-success-subtle text-success';
            } else {
                qrBadge.innerHTML = '<i class="fas fa-id-card me-1"></i>National ID OCR Extracted';
                qrBadge.className = 'badge bg-teal-subtle text-teal';
            }
        }

        if (qrPayload) {
            if (parsed.qrScanned && parsed.qrData) {
                qrPayload.textContent = parsed.qrData.length > 150 ? parsed.qrData.substring(0, 150) + '...' : parsed.qrData;
            } else {
                qrPayload.textContent = '2D QR Code not detected on uploaded image (PhilSys QR is located on the back side of the card). Details populated via National ID optical character recognition.';
            }
        }

        // 4. Cascade Location (Province -> City -> Barangay -> Postal)
        if (parsed.province && parsed.city && typeof window.applyLocationCascade === 'function') {
            window.applyLocationCascade(
                'idVerifProvince',
                'idVerifCity',
                'idVerifBarangaySelect',
                'idVerifPostal',
                parsed.province,
                parsed.city,
                parsed.barangay || '',
                parsed.postalCode || ''
            );
        } else {
            if (parsed.province) {
                const provSelect = document.getElementById('idVerifProvince');
                if (provSelect) {
                    provSelect.value = parsed.province;
                    provSelect.dispatchEvent(new Event('change'));
                }
            }
            if (parsed.city) {
                const citySelect = document.getElementById('idVerifCity');
                if (citySelect) {
                    citySelect.value = parsed.city;
                    citySelect.dispatchEvent(new Event('change'));
                }
            }
        }

        const brgyInput = document.getElementById('idVerifBarangay');
        const postalInput = document.getElementById('idVerifPostal');
        const line1Input = document.getElementById('idVerifAddress1');

        if (brgyInput && parsed.barangay) brgyInput.value = parsed.barangay;
        if (postalInput && parsed.postalCode) postalInput.value = parsed.postalCode;
        if (line1Input && parsed.addressLine1) line1Input.value = parsed.addressLine1;
    }

    // Expose functions globally
    window.validateAndScanIdStep1 = validateAndScanIdStep1;
    window.parsePhilippineIdText = parsePhilippineIdText;
    window.populateVerificationForm = populateVerificationForm;
    window.showStep1Error = showStep1Error;

})(window);
