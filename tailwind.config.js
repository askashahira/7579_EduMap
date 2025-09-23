import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                // Warna standar kita
                'primary': '#14B8A6', 
                'secondary': '#3B82F6',

                // GRADASI BARU YANG LEBIH LEMBUT
                'auth-start': '#E0F2F1',
                'auth-end': '#EBF8FF',

                // Gradasi Halaman Internal
                'content-start': '#F8FAFC',
                'content-end': '#F1F5F9',
                'primary-light': '#79D9B7',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        require('tailwind-scrollbar-hide'),
        require('tailwindcss-textshadow')
    ],
};