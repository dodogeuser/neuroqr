import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './tests/Browser',
  outputDir: '.qa/results',
  fullyParallel: false,
  workers: 1,
  reporter: 'list',
  use: {
    baseURL: 'http://127.0.0.1:4174',
    channel: process.env.BROWSER_CHANNEL || 'msedge',
    trace: 'retain-on-failure',
  },
  webServer: {
    command: 'php -S 127.0.0.1:4174 ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php',
    cwd: './public',
    url: 'http://127.0.0.1:4174/up',
    reuseExistingServer: false,
    stderr: 'ignore',
    timeout: 30000,
  },
});

