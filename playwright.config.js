import { defineConfig, devices } from '@playwright/test';

const externalBaseUrl = process.env.PLAYWRIGHT_BASE_URL;

export default defineConfig({
    testDir: './tests/Browser',
    fullyParallel: true,
    forbidOnly: Boolean(process.env.CI),
    retries: process.env.CI ? 2 : 0,
    workers: process.env.CI ? 1 : undefined,
    reporter: process.env.CI ? [['github'], ['html', { open: 'never' }]] : 'list',
    use: {
        baseURL: externalBaseUrl ?? 'http://127.0.0.1:8000',
        permissions: ['clipboard-read', 'clipboard-write'],
        screenshot: 'only-on-failure',
        trace: 'retain-on-failure',
    },
    projects: [
        {
            name: 'desktop-chromium',
            use: { ...devices['Desktop Chrome'] },
        },
        {
            name: 'mobile-chromium',
            use: { ...devices['Pixel 7'] },
        },
    ],
    webServer: externalBaseUrl
        ? undefined
        : {
              command: 'php artisan serve --host=127.0.0.1 --port=8000',
              url: 'http://127.0.0.1:8000/up',
              reuseExistingServer: !process.env.CI,
              timeout: 120_000,
          },
});
