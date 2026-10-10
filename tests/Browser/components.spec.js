import { expect, test } from '@playwright/test';

test('component library links to every documented selector', async ({ page }) => {
    await page.goto('/components');

    await expect(page.getByRole('heading', { name: 'Geographic UI components for Laravel and JavaScript.' })).toBeVisible();
    await expect(page.getByRole('link', { name: /Country selector/ })).toHaveAttribute('href', /\/components\/country-selector$/);
    await expect(page.getByRole('link', { name: /Country, state, and city selector/ })).toHaveAttribute('href', /\/components\/location-selector$/);
    await expect(page.getByRole('link', { name: /Currency selector/ })).toHaveAttribute('href', /\/components\/currency-selector$/);
    await expect(page.getByRole('link', { name: /Language selector/ })).toHaveAttribute('href', /\/components\/language-selector$/);
    await expect(page.getByRole('link', { name: /Timezone selector/ })).toHaveAttribute('href', /\/components\/timezone-selector$/);
});

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
    await expect(page.locator('[data-location-country] option:checked')).toContainText('Romania');
    await expect(page.locator('[data-location-state] option:checked')).toHaveText('Cluj County');
    await expect(page.locator('[data-location-city] option:checked')).toHaveText('Cluj-Napoca');
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

test('World 2.0 returns optional flags and the Cayman districts and cities', async ({ request }) => {
    const flagResponse = await request.get('/api/countries?fields=iso2,flag&filters[iso2]=KY');
    expect(flagResponse.ok()).toBeTruthy();
    const flagPayload = await flagResponse.json();
    expect(flagPayload.success).toBe(true);
    expect(flagPayload.data).toHaveLength(1);
    expect(flagPayload.data[0]).toMatchObject({ iso2: 'KY', flag: '🇰🇾' });

    const statesResponse = await request.get('/api/states?fields=country_code&filters[country_code]=KY');
    expect(statesResponse.ok()).toBeTruthy();
    const statesPayload = await statesResponse.json();
    expect(statesPayload.data).toHaveLength(6);
    expect(statesPayload.data.map((state) => state.name)).toEqual(expect.arrayContaining([
        'George Town', 'West Bay', 'Bodden Town', 'North Side', 'East End', 'Sister Islands',
    ]));

    const citiesResponse = await request.get('/api/cities?fields=state_id,country_code&filters[country_code]=KY');
    expect(citiesResponse.ok()).toBeTruthy();
    const citiesPayload = await citiesResponse.json();
    expect(citiesPayload.data).toHaveLength(15);
    const stateIds = statesPayload.data.map((state) => state.id);
    for (const city of citiesPayload.data) {
        expect(city.country_code).toBe('KY');
        expect(stateIds).toContain(city.state_id);
    }
});

test('component setup distinguishes World 2.0 from existing 1.x installations', async ({ page }) => {
    await page.goto('/components/country-selector');
    await expect(page.getByText('composer require nnjeim/world:^2.0', { exact: true })).toBeVisible();
    await expect(page.getByRole('link', { name: '2.0 upgrade guide' })).toHaveAttribute('href', /docs\/2\.0\/UPGRADE\.md$/);
    await expect(page.getByRole('link', { name: '1.x documentation' }).first()).toHaveAttribute('href', /docs\/1\.x\/README\.md$/);
});
