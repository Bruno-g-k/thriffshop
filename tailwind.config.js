// tailwind.config.js

import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'music-bg':     '#FEF3C7',
                'music-brown':  '#451A03',
                'music-yellow': '#FBBF24',
                'music-red':    '#DC2626',
            },
            fontFamily: {
                display: ['"Bebas Neue"', ...defaultTheme.fontFamily.sans],
                body:    ['Inter',        ...defaultTheme.fontFamily.sans],
                // mantém 'sans' apontando para Inter também
                sans:    ['Inter',        ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
