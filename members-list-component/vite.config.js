import { defineConfig } from 'vite'
import { svelte } from '@sveltejs/vite-plugin-svelte'
import { fileURLToPath } from 'url'



// https://vitejs.dev/config/
export default defineConfig({
  plugins: [svelte()],
  build: {
    manifest: true,
    rollupOptions: {
      input: {
        main: fileURLToPath(new URL('./src/main.js', import.meta.url)),
      },

      /*
      output: {
          entryFileNames: `[name].js`,
          chunkFileNames: `[name].js`,
          assetFileNames: `[name].[ext]`
      }*/
    },
  },
  server: {

    // required to load scripts from custom host
    cors: true,

    // we need a strict port to match on PHP side
    // change freely, but update in your functions.php to match the same port
    strictPort: true,
    port: 3000,

    // serve over http
    https: false,

    // serve over httpS
    // to generate localhost certificate follow the link:
    // https://github.com/FiloSottile/mkcert - Windows, MacOS and Linux supported - Browsers Chrome, Chromium and Firefox (FF MacOS and Linux only)
    // installation example on Windows 10:
    // > choco install mkcert (this will install mkcert)
    // > mkcert -install (global one time install)
    // > mkcert localhost (in project folder files localhost-key.pem & localhost.pem will be created)
    // uncomment below to enable https
    //https: {
    //  key: fs.readFileSync('localhost-key.pem'),
    //  cert: fs.readFileSync('localhost.pem'),
    //},

    hmr: {
      protocol: 'ws',
      host: 'localhost',
      port: 3000,
    },

  },

  // required for in-browser template compilation
  // https://v3.vuejs.org/guide/installation.html#with-a-bundler
  resolve: {
    alias: {
      //vue: 'vue/dist/vue.esm-bundler.js'
    }
  }
})
