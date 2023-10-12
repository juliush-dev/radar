import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: "resources/js/app.js",
            ssr: "resources/js/ssr.js",
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
    server: {
        host: "172.22.110.73",
        watch: {
            usePolling: true,
        },
        hmr: {
            host: "192.168.0.102",
        },
    },
    ssr: {
        noExternal: ["vue", "@protonemedia/laravel-splade"],
    },
});
