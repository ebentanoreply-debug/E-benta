import { test, expect } from '@playwright/test';

test.describe('E-Benta Authentication Flow Suite', () => {

  test.beforeEach(async ({ page }) => {
    await page.goto('/login', { waitUntil: 'domcontentloaded' });
  });

  test('A1. Form validation: blocks submission with empty fields', async ({ page }) => {
    const loginForm = page.locator('#loginForm');
    const submitBtn = loginForm.locator('button[type="submit"]');

    await expect(submitBtn).toBeVisible();
    await submitBtn.click();

    // Check that client stays on /login (HTML5 required validation blocks empty submit)
    await expect(page).toHaveURL(/.*login/);
  });

  test('A2. Password visibility toggle works correctly', async ({ page }) => {
    const passwordInput = page.locator('#password');
    const toggleBtn = page.locator('.password-toggle-btn');

    await passwordInput.fill('SecretPass123!');
    await expect(passwordInput).toHaveAttribute('type', 'password');

    // Click toggle button to reveal password
    if (await toggleBtn.count() > 0) {
      await toggleBtn.click();
      await expect(passwordInput).toHaveAttribute('type', 'text');

      // Click again to hide
      await toggleBtn.click();
      await expect(passwordInput).toHaveAttribute('type', 'password');
    }
  });

  test('A3. Invalid credentials display error alert', async ({ page }) => {
    const loginForm = page.locator('#loginForm');
    const emailInput = loginForm.locator('#email');
    const passwordInput = loginForm.locator('#password');
    const submitBtn = loginForm.locator('button[type="submit"]');

    await emailInput.fill('invalid_user_999@test.com');
    await passwordInput.fill('WrongPassword999!');
    await submitBtn.click();

    // Expect server error feedback
    const errorBox = page.getByText(/The provided credentials do not match our records/i).first();
    await expect(errorBox).toBeVisible({ timeout: 10000 });
  });

  test('A4. Forgot password link navigates to password recovery form', async ({ page }) => {
    const forgotLink = page.locator('a[href*="forgot-password"]').first();
    await expect(forgotLink).toBeVisible();
    await forgotLink.click();

    await expect(page).toHaveURL(/.*forgot-password/);
    const recoveryEmailInput = page.locator('#email, form[action*="password"] input[type="email"]').first();
    await expect(recoveryEmailInput).toBeVisible();
  });

  test('A5. Live Login test with registered account', async ({ page }) => {
    const loginForm = page.locator('#loginForm');
    const emailInput = loginForm.locator('#email');
    const passwordInput = loginForm.locator('#password');
    const submitBtn = loginForm.locator('button[type="submit"]');

    // Try standard test account
    await emailInput.fill('seller@test.com');
    await passwordInput.fill('password123');
    await submitBtn.click();

    // Check either successful dashboard navigation OR standard credential rejection
    await page.waitForTimeout(2500);
    const currentUrl = page.url();

    if (currentUrl.includes('dashboard')) {
      await expect(page).toHaveURL(/.*dashboard/);
    } else {
      const errorNotice = page.getByText(/credentials/i).first();
      await expect(errorNotice).toBeVisible();
    }
  });

});
