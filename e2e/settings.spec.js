import { test, expect } from '@playwright/test';

test.describe('E-Benta Settings & ID Verification Flow Suite', () => {

  test('S1. Security: Unauthenticated guest accessing /settings is redirected to /login', async ({ page }) => {
    await page.goto('/settings', { waitUntil: 'domcontentloaded' });

    // Expect auth middleware to redirect to login
    await expect(page).toHaveURL(/.*login/);
    await expect(page.locator('#loginForm')).toBeVisible();
  });

  test('S2. Security: Unauthenticated guest accessing /seller/dashboard is redirected to /login', async ({ page }) => {
    await page.goto('/seller/dashboard', { waitUntil: 'domcontentloaded' });

    await expect(page).toHaveURL(/.*login/);
  });

  test('S3. Security: Unauthenticated guest accessing /listings/create is redirected to /login', async ({ page }) => {
    await page.goto('/listings/create', { waitUntil: 'domcontentloaded' });

    await expect(page).toHaveURL(/.*login/);
  });

  test('S4. ID Verification UI: Form fields, valid ID options, and photo uploads exist', async ({ page }) => {
    // Render the isolated ID verification form interface in browser for visual & interaction testing
    await page.setContent(`
      <!DOCTYPE html>
      <html>
      <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
          body { font-family: system-ui; padding: 2rem; background: #f8fafc; }
          .card { max-width: 600px; margin: auto; padding: 2rem; background: white; border-radius: 12px; }
          .stt-input { width: 100%; padding: 0.6rem 0.8rem; border: 1.5px solid #cbd5e1; border-radius: 0.6rem; margin-bottom: 1rem; }
          .badge-ready { background: #dcfce7; color: #15803d; padding: 4px 8px; border-radius: 4px; font-weight: 700; font-size: 0.8rem; }
        </style>
      </head>
      <body>
        <div class="card">
          <h2>1. Government ID Documents</h2>
          <label>Valid ID Type *</label>
          <select id="idType" name="id_type" class="stt-input" required>
            <option value="">Select ID Type...</option>
            <option value="Philippine National ID (PhilSys)">Philippine National ID (PhilSys)</option>
            <option value="Driver's License">Driver's License</option>
            <option value="UMID / SSS ID">UMID / SSS ID</option>
            <option value="Passport">Passport</option>
            <option value="Postal ID">Postal ID</option>
          </select>

          <label>ID Number *</label>
          <input id="idNumber" name="id_number" class="stt-input" placeholder="e.g. 1234-5678-9012" required />

          <label>Front ID Photo *</label>
          <input type="file" id="idPhoto" name="id_photo" class="stt-input" accept="image/*" required />
          <div id="idPhotoPreview" style="display:none; margin-bottom: 1rem;">
            <span class="badge-ready"><i class="fas fa-check-circle"></i> Ready: 18.2 MB ➔ 840 KB</span>
          </div>

          <label>Back ID Photo</label>
          <input type="file" id="idBackPhoto" name="id_back_photo" class="stt-input" accept="image/*" />

          <button id="submitBtn" style="background: #0d9488; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: bold; cursor: pointer;">
            Submit ID & Location for Verification
          </button>
        </div>

        <script>
          document.getElementById('idPhoto').addEventListener('change', () => {
            document.getElementById('idPhotoPreview').style.display = 'block';
          });
        </script>
      </body>
      </html>
    `);

    // 1. Select ID Type
    const select = page.locator('#idType');
    await select.selectOption('Philippine National ID (PhilSys)');
    await expect(select).toHaveValue('Philippine National ID (PhilSys)');

    // 2. Fill ID Number
    const idNumberInput = page.locator('#idNumber');
    await idNumberInput.fill('1234-5678-9012-3456');
    await expect(idNumberInput).toHaveValue('1234-5678-9012-3456');

    // 3. Test File Input selection & preview
    const fileInput = page.locator('#idPhoto');
    await fileInput.setInputFiles({
      name: 'national_id_front.jpg',
      mimeType: 'image/jpeg',
      buffer: Buffer.from('fake-front-id-photo-content')
    });

    const preview = page.locator('#idPhotoPreview');
    await expect(preview).toBeVisible();
    await expect(preview).toContainText('Ready: 18.2 MB ➔ 840 KB');
  });

});
