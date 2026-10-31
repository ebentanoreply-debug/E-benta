import { test, expect } from '@playwright/test';

test.describe('Playwright Automation & Testing Showcase', () => {

  test('should navigate to a website and verify title and text', async ({ page }) => {
    // 1. Navigate to URL
    await page.goto('https://example.com');

    // 2. Assert page title
    await expect(page).toHaveTitle('Example Domain');

    // 3. Locate text content
    const paragraph = page.locator('p').first();
    await expect(paragraph).toContainText('This domain is for use in documentation examples');
  });

  test('should simulate user clicks, form typing, and reactive DOM changes', async ({ page }) => {
    // 1. Render an interactive test interface directly in browser
    await page.setContent(`
      <!DOCTYPE html>
      <html>
      <head>
        <style>
          body { font-family: system-ui; padding: 2rem; background: #f8fafc; }
          .card { max-width: 400px; margin: auto; padding: 1.5rem; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
          button { background: #0d9488; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; }
          input { width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #cbd5e1; border-radius: 6px; }
          .badge { display: inline-block; padding: 4px 8px; background: #e0f2fe; color: #0369a1; border-radius: 4px; }
        </style>
      </head>
      <body>
        <div class="card">
          <h2>E-Benta Playwright Test</h2>
          <label for="username">Username:</label>
          <input id="username" placeholder="Enter username" />
          <button id="loginBtn">Log In</button>
          <p id="greeting" style="display:none; margin-top: 1rem;">Welcome, <span id="userDisplay"></span>!</p>
        </div>
        <script>
          document.getElementById('loginBtn').addEventListener('click', () => {
            const val = document.getElementById('username').value.trim();
            if (val) {
              document.getElementById('userDisplay').textContent = val;
              document.getElementById('greeting').style.display = 'block';
            }
          });
        </script>
      </body>
      </html>
    `);

    // 2. Type into input field
    const input = page.locator('#username');
    await input.fill('vincent');
    await expect(input).toHaveValue('vincent');

    // 3. Click button
    const loginBtn = page.locator('#loginBtn');
    await loginBtn.click();

    // 4. Assert element becomes visible with typed value
    const greeting = page.locator('#greeting');
    await expect(greeting).toBeVisible();
    await expect(page.locator('#userDisplay')).toHaveText('vincent');
  });

  test('should take full-page screenshot', async ({ page }) => {
    await page.setContent(`
      <div style="padding: 3rem; background: linear-gradient(135deg, #0d9488, #0f766e); color: white; text-align: center;">
        <h1>Playwright is 100% operational on Fedora Linux!</h1>
        <p>Headless Chromium running smoothly with hardware acceleration & rendering support.</p>
      </div>
    `);

    // Verify element
    await expect(page.locator('h1')).toContainText('operational on Fedora Linux');

    // Screenshot test
    const buffer = await page.screenshot();
    expect(buffer.length).toBeGreaterThan(1000);
  });

});
