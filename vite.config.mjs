import { defineConfig } from 'vite';
import legacy from '@vitejs/plugin-legacy';
import path from 'path';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const themeDir = path.resolve(__dirname);

export default defineConfig(({ command }) => {
  const isDev = command === 'serve';

  return {
    root: path.resolve(themeDir, 'assets'),
    base: isDev ? '/' : '/wp-content/themes/mv-clients-crm/build/',
    build: {
      outDir: path.resolve(themeDir, 'build'),
      emptyOutDir: true,
      manifest: true,
      rollupOptions: {
        input: {
          'js/main': path.resolve(themeDir, 'assets/js/main.js'),
          'css/style': path.resolve(themeDir, 'assets/css/style.scss'),
          // 'css/header': path.resolve(themeDir, 'assets/css/header.scss'),
        }
      },     
    },
    css: {
      preprocessorOptions: {
        scss: {
          includePaths: [
            './node_modules', // 👈 necesario para que @import "variables-dark" funcione
          ],
          silenceDeprecations: [
            'import',
            'mixed-decls',
            'color-functions',
            'global-builtin',
          ],
        },
      },
    },
    server: {
      port: 5173,
      origin: 'http://localhost:5173',
      hmr: { host: 'localhost' },
      watch: {
        usePolling: true
      }
    },
    plugins: [
      legacy(),
    ]
  };
});
