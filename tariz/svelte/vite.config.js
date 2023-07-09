import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [svelte()],
  server: {
    port: 5006,
    proxy: {
      '/data': {
        target: 'http://karasev.taris',
        changeOrigin: true,
      }
    }
  },
})
