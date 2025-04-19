import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { resolve, dirname } from 'node:path'
import { fileURLToPath } from 'url'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'
import { vuestic } from '@vuestic/compiler/vite'
import { nodeResolve as viteNodeResolve } from '@rollup/plugin-node-resolve';

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    
    sourcemap: true,
    
  },
  plugins: [
    nodeResolve({
      exportConditions: ["node"]
    }),
    vuestic({
      devtools: true,
      cssLayers: true,
    }),
    vue(),
    VueI18nPlugin({
      include: resolve(dirname(fileURLToPath(import.meta.url)), './src/i18n/locales/**'),
    }),
  ],
})
function nodeResolve(arg0: { exportConditions: string[] }): import("vite").PluginOption {
  return viteNodeResolve(arg0) as any
}

