import { expect, test } from '@playwright/test';

const simpleComponents = [
    ['country-selector', '250 items loaded from the live API', 'Romania · RO · ID 181'],
    ['currency-selector', '250 items loaded from the live API', 'Euro · EUR · €'],
    ['language-selector', '183 items loaded from the live API', 'română · ro · LTR'],
    ['timezone-selector', '428 items loaded from the live API', 'Europe/Bucharest'],
];

for (const [slug, status, selectedValue] of simpleComponents) {
    test(`${slug} loads its live dataset`, async ({ page }) => {
        await page.goto(`/components/${slug}`);

        await expect(page.locator('[data-demo-status]')).toHaveText(status);
        await expect(page.locator('[data-demo-result]')).toContainText(selectedValue);
    });
}

test('location selector loads dependent states and cities', async ({ page }) => {
    await page.goto('/components/location-selector');

    await expect(page.locator('[data-demo-status]')).toHaveText('Country, state, and city are connected to the live API');
    await expect(page.locator('[data-location-country]')).toHaveValue('181');
    await expect(page.locator('[data-location-state]')).toHaveValue('3338');
    await expect(page.locator('[data-location-city]')).toHaveValue('95226');
    await expect(page.locator('[data-location-result]')).toHaveText('Romania · Cluj County · Cluj-Napoca');

    await page.getByRole('tab', { name: 'Angular' }).click();
    await expect(page.getByText('location-select.component.ts')).toBeVisible();
});

test('component documentation remains within a mobile viewport', async ({ page }) => {
    await page.goto('/components/country-selector');

    const dimensions = await page.locator('html').evaluate((element) => ({
        clientWidth: element.clientWidth,
        scrollWidth: element.scrollWidth,
    }));

    expect(dimensions.scrollWidth).toBeLessThanOrEqual(dimensions.clientWidth);
});
