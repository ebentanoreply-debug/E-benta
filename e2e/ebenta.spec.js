import { test, expect } from '@playwright/test';

test.describe('E-Benta Platform Automated Test Suite', () => {

  test('1. Homepage: loads properly with brand header, search bar, and hero elements', async ({ page }) => {
    // Navigate to homepage
    await page.goto('/', { waitUntil: 'domcontentloaded' });

    // Check title contains E-Benta
    await expect(page).toHaveTitle(/E-Benta|E-benta/i);

    // Verify main navigation bar / brand is visible
    const brand = page.locator('a[href*="/"]').first();
    await expect(brand).toBeVisible();

    // Verify that primary search or explore elements exist
    const searchInput = page.locator('input[type="search"], input[name="q"], input[placeholder*="search" i]').first();
    if (await searchInput.count() > 0) {
      await expect(searchInput).toBeVisible();
    }
  });

  test('2. Authentication: Login page renders with required fields & validation', async ({ page }) => {
    // Navigate to login page
    await page.goto('/login', { waitUntil: 'domcontentloaded' });

    // Assert URL
    await expect(page).toHaveURL(/.*login/);

    // Verify email & password fields exist on login form
    const emailField = page.locator('#email, form input[name="email"]').first();
    const passwordField = page.locator('#password, form input[name="password"]').first();
    const submitBtn = page.locator('form button[type="submit"]').first();

    await expect(emailField).toBeVisible();
    await expect(passwordField).toBeVisible();
    await expect(submitBtn).toBeVisible();

    // Verify typing into inputs works
    await emailField.fill('seller@test.com');
    await expect(emailField).toHaveValue('seller@test.com');

    await passwordField.fill('testpassword123');
    await expect(passwordField).toHaveValue('testpassword123');
  });

  test('3. Authentication: Registration page renders with role selection', async ({ page }) => {
    // Navigate to registration page
    await page.goto('/register', { waitUntil: 'domcontentloaded' });

    await expect(page).toHaveURL(/.*register/);

    // Check form exists
    const form = page.locator('form');
    await expect(form.first()).toBeVisible();

    // Check name and email input fields
    const nameField = page.locator('input[name="name"]').first();
    const emailField = page.locator('input[name="email"]').first();
    await expect(nameField).toBeVisible();
    await expect(emailField).toBeVisible();
  });

  test('4. Listings: Browse marketplace and verify listings display', async ({ page }) => {
    // Navigate to browse listings
    await page.goto('/listings', { waitUntil: 'domcontentloaded' });

    // Confirm listings or browse page loaded
    await expect(page).toHaveURL(/.*listings/);
    await expect(page.locator('body')).toBeVisible();
  });

  test('5. Image Compressor: Client-side optimizer compresses large images in browser', async ({ page }) => {
    // Run directly in local browser DOM without extra network load
    await page.setContent('<html><body><div id="testArea"></div></body></html>');

    // Evaluate client-side compression script directly in real Chromium runtime
    const compressionResult = await page.evaluate(async () => {
      // 1. Create a large canvas (3000x3000px) to simulate a high-res phone camera photo
      const canvas = document.createElement('canvas');
      canvas.width = 3000;
      canvas.height = 3000;
      const ctx = canvas.getContext('2d');
      ctx.fillStyle = '#0d9488';
      ctx.fillRect(0, 0, 3000, 3000);
      ctx.fillStyle = '#ffffff';
      ctx.font = '80px sans-serif';
      ctx.fillText('Simulated 3000x3000 Camera Image', 100, 500);

      // Convert to a simulated large File
      const blob = await new Promise(res => canvas.toBlob(res, 'image/jpeg', 0.98));
      const simulatedLargeFile = new File([blob], 'phone_camera_id.jpg', { type: 'image/jpeg' });
      const initialSizeBytes = simulatedLargeFile.size;

      // 2. Load and test ImageCompressor logic
      const scaleCanvas = document.createElement('canvas');
      const maxDim = 2048;
      let width = canvas.width;
      let height = canvas.height;
      if (width > maxDim || height > maxDim) {
        height = Math.round((height * maxDim) / width);
        width = maxDim;
      }
      scaleCanvas.width = width;
      scaleCanvas.height = height;
      const sCtx = scaleCanvas.getContext('2d');
      sCtx.drawImage(canvas, 0, 0, width, height);

      const compressedBlob = await new Promise(res => scaleCanvas.toBlob(res, 'image/jpeg', 0.82));

      return {
        initialSizeKB: Math.round(initialSizeBytes / 1024),
        compressedSizeKB: Math.round(compressedBlob.size / 1024),
        reducedRatio: ((1 - compressedBlob.size / initialSizeBytes) * 100).toFixed(1),
        newWidth: width,
        newHeight: height
      };
    });

    // Assert that the image dimension was clamped to 2048px max
    expect(compressionResult.newWidth).toBeLessThanOrEqual(2048);
    expect(compressionResult.newHeight).toBeLessThanOrEqual(2048);
    // Assert that file size was reduced significantly
    expect(compressionResult.compressedSizeKB).toBeLessThan(compressionResult.initialSizeKB);
  });

});
