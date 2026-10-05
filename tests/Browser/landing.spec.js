import { expect, test } from '@playwright/test';

test('country selector filters, selects, switches framework, and copies code', async ({ page }) => {
    await page.goto('/');

    await expect(page.getByRole('heading', { name: 'The world, ready for your UI.' })).toBeVisible();
    await expect(page.getByText('250 countries loaded')).toBeVisible();
    await expect(page.locator('[data-api-usage-chart] span')).toHaveCount(30);

    const countrySearch = page.getByRole('combobox', { name: 'Country' });
    await countrySearch.fill('Japan');
    await page.getByRole('option', { name: '🇯🇵 Japan JP' }).click();

    await expect(countrySearch).toHaveValue('Japan');
    await expect(page.getByText('ISO JP · ID 110')).toBeVisible();

    await page.getByRole('tab', { name: 'Vue' }).click();
    await expect(page.getByText('CountrySelect.vue')).toBeVisible();

    const copyButton = page.locator('[data-copy-code]');
    await copyButton.click();
    await expect(copyButton).toContainText('Copied');
});

test('landing page remains within a mobile viewport', async ({ page }) => {
    await page.goto('/');

    await expect(page.getByRole('heading', { name: 'The world, ready for your UI.' })).toBeVisible();

    const dimensions = await page.locator('html').evaluate((element) => ({
        clientWidth: element.clientWidth,
        scrollWidth: element.scrollWidth,
    }));

    expect(dimensions.scrollWidth).toBeLessThanOrEqual(dimensions.clientWidth);
});
