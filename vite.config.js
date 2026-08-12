import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

const isGitHubPages = process.env.VITE_BASE_URL !== undefined;

export default defineConfig(
  isGitHubPages
    ? {
        // GitHub Pages standalone SPA build
        plugins: [
          vue({
            template: {
              transformAssetUrls: {
                base: null,
                includeAbsolute: false,
              },
            },
          }),
        ],
        resolve: {
          alias: {
            '@': path.resolve(__dirname, 'resources/js'),
          },
        },
        build: {
          manifest: true,
          rollupOptions: {
            input: {
              main: path.resolve(__dirname, 'resources/js/main.js'),
              app: path.resolve(__dirname, 'resources/css/app.css'),
            },
          },
        },
      }
    : {
        // Laravel local development build
        plugins: [
          laravel({
            input: ['resources/css/app.css', 'resources/js/main.js'],
            refresh: true,
          }),
          vue({
            template: {
              transformAssetUrls: {
                base: null,
                includeAbsolute: false,
              },
            },
          }),
        ],
        resolve: {
          alias: {
            '@': '/resources/js',
          },
        },
      }
);
