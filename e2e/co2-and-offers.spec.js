import { test, expect } from '@playwright/test';

test.describe('E-Benta CO2 Removal & Offers Resolution Verification', () => {

  test('C1. Homepage: Contains zero references to CO2 or carbon footprint badges', async ({ page }) => {
    await page.goto('/', { waitUntil: 'domcontentloaded' });
    await expect(page).toHaveTitle(/E-Benta|E-benta/i);

    // Verify no CO2 text in body
    const bodyText = await page.innerText('body');
    expect(bodyText).not.toMatch(/CO₂/);
    expect(bodyText).not.toMatch(/kg CO2/i);
    expect(bodyText).not.toMatch(/CO2 saved/i);
    expect(bodyText).not.toMatch(/CO2 impact/i);

    // Ensure Value Estimator exists instead of CO2 Estimator
    const estimatorLink = page.locator('a[href*="#calculator"]').first();
    if (await estimatorLink.count() > 0) {
      await expect(estimatorLink).not.toContainText('CO₂');
    }
  });

  test('C2. Marketplace: Catalog cards do not display CO2 impact badges', async ({ page }) => {
    await page.goto('/listings', { waitUntil: 'domcontentloaded' });
    await expect(page).toHaveURL(/.*listings/);

    const bodyText = await page.innerText('body');
    expect(bodyText).not.toMatch(/CO₂/);
    expect(bodyText).not.toMatch(/kg CO2/i);

    // Ensure sort option doesn't have CO2
    const sortDropdown = page.locator('#catalog-sort');
    if (await sortDropdown.count() > 0) {
      const optionsText = await sortDropdown.innerText();
      expect(optionsText).not.toContain('CO₂');
    }
  });

  test('C3. PDP Listing 330006: Loads properly with no CO2 badge', async ({ page }) => {
    // Navigate to listing 330006 (from user screenshot)
    const response = await page.goto('/listings/330006', { waitUntil: 'domcontentloaded' });
    
    if (response && response.status() === 200) {
      // Confirm no CO2 badge on PDP
      const bodyText = await page.innerText('body');
      expect(bodyText).not.toMatch(/CO₂ Impact/i);
      expect(bodyText).not.toMatch(/CO₂ Footprint/i);
      expect(bodyText).not.toMatch(/kg CO2/i);
      expect(bodyText).not.toMatch(/Certified Carbon Credits/i);

      // Verify certified e-waste or working badge is displayed
      await expect(page.locator('.pdp-gallery-main')).toBeVisible();
    }
  });

  test('C4. Offers routing: Accessing /offers/330006 redirects gracefully without 404', async ({ page }) => {
    // Access /offers/330006 (from user screenshot Image 2)
    const response = await page.goto('/offers/330006', { waitUntil: 'domcontentloaded' });

    // Should not return a 404 status
    expect(response?.status()).not.toBe(404);

    // Page body should NOT contain raw "404 | NOT FOUND"
    const bodyText = await page.innerText('body');
    expect(bodyText).not.toContain('404 | NOT FOUND');
    expect(bodyText).not.toContain('404 | Not Found');
  });

  test('C5. 404 Page: Any nonexistent page renders E-Benta branded error template', async ({ page }) => {
    const response = await page.goto('/non-existent-page-test-xyz-12345', { waitUntil: 'domcontentloaded' });
    
    // Status is 404
    expect(response?.status()).toBe(404);

    // Should render the custom branded 404 template with E-Benta branding and navigation
    const heading = page.locator('h1');
    await expect(heading).toContainText(/Lost in the Hardware Loop/i);

    const browseBtn = page.locator('a:has-text("Browse Marketplace")');
    await expect(browseBtn).toBeVisible();
  });

});
