import { test, expect } from '@playwright/test';

const pages = ['/', '/about', '/services', '/products', '/products/nexa', '/contact'];

for (const width of [1440, 768, 390, 320]) {
  test(`all pages work at ${width}px`, async ({ page }) => {
    await page.setViewportSize({ width, height: 1000 });
    const failures = [];
    page.on('pageerror', error => failures.push(error.message));
    page.on('response', response => {
      if (response.status() >= 400) failures.push(`${response.status()} ${response.url()}`);
    });

    for (const path of pages) {
      await page.goto(path);
      await expect(page.locator('h1')).toBeVisible();
      await expect(page).toHaveTitle(/Nexus Qart/);
      if (path === '/products/nexa') await page.screenshot({ path: `.qa/nexa-${width}.png`, fullPage: true });
      expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
      expect(await page.locator('img').evaluateAll(images => images.every(image => image.complete && image.naturalWidth > 0))).toBe(true);
    }

    expect(failures).toEqual([]);
    await page.goto('/');
    await page.screenshot({ path: `.qa/home-${width}.png`, fullPage: true });
  });
}

test('mobile navigation opens, escapes, and follows links', async ({ page }) => {
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto('/');
  const toggle = page.getByRole('button', { name: 'Menu' });
  await toggle.click();
  await expect(toggle).toHaveAttribute('aria-expanded', 'true');
  await expect(page.getByRole('navigation', { name: 'Mobile navigation' })).toBeVisible();
  await page.keyboard.press('Escape');
  await expect(toggle).toHaveAttribute('aria-expanded', 'false');
  await expect(toggle).toBeFocused();
  await toggle.click();
  await page.getByRole('navigation', { name: 'Mobile navigation' }).getByRole('link', { name: 'About', exact: true }).click();
  await expect(page).toHaveURL(/\/about$/);
});

test('product, contact and keyboard paths work', async ({ page }) => {
  await page.goto('/');
  await page.keyboard.press('Tab');
  await expect(page.getByRole('link', { name: 'Skip to content' })).toBeFocused();
  await page.getByRole('link', { name: 'Discover Nexa' }).click();
  await page.getByText('Where do I sign in?', { exact: true }).click();
  await expect(page.locator('details').first()).toHaveAttribute('open', '');
  await expect(page.getByRole('link', { name: 'Open Nexa login' })).toHaveAttribute('href', 'https://getwooperly.com/login');
  await page.getByRole('link', { name: 'Ask about Nexa' }).click();
  await expect(page.getByRole('link', { name: 'Start an email' })).toHaveAttribute('href', /mailto:.*subject=.*Nexa%20QR%20Menu/);
});

test('local links resolve and scripts are optional', async ({ page, request, browser }) => {
  const paths = new Set();
  for (const path of pages) {
    await page.goto(path);
    for (const href of await page.locator('a[href]').evaluateAll(links => links.map(link => link.href))) {
      if (href.startsWith('http://127.0.0.1:4174')) paths.add(href.split('#')[0]);
    }
  }
  for (const href of paths) expect((await request.get(href)).ok()).toBe(true);

  const context = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 390, height: 844 }, reducedMotion: 'reduce' });
  const fallback = await context.newPage();
  await fallback.goto('http://127.0.0.1:4174/');
  await expect(fallback.getByRole('navigation', { name: 'Page navigation' })).toBeVisible();
  await context.close();
});

