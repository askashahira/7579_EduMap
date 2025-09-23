import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        // 'host' akan membuat Vite bisa diakses dari jaringan (untuk HP teman Anda)
        host: '0.0.0.0', 
        hmr: {
            // 'hmr.host' akan memastikan di laptop Anda sendiri, browser tetap
            // menggunakan 'localhost' untuk mengambil aset, memperbaiki layar putih.
            host: 'localhost',
        },
    },
    
    // server: {
    //     hmr: {
    //         host: 'localhost',
    //     },
    //     // Izinkan koneksi dari host ngrok Anda
    //     host: '0.0.0.0', // Ini membuat server bisa diakses dari jaringan lokal
    //     watch: {
    //         usePolling: true,
    //     },
    //     // Ini adalah bagian yang paling penting
    //     // Ganti dengan URL ngrok Anda tanpa https://
    //     origin: 'https://bd76802a353f.ngrok-free.app',
    // },
    
    plugins: [
        laravel({
            // PASTIKAN KEDUA FILE INI ADA DI DALAM 'input'
            input: ['resources/css/app.css', 'resources/js/app.js'],
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
});