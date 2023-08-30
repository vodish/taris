import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [svelte()],
  server: {
    port: 5006,
    proxy: {
      '/api': {
        target: 'http://k.tariz',
        changeOrigin: true,
      }
    }
  },
})
