import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Taobao Signature Flame Orange & Tmall Red Palette
                brand: {
                    50: '#fff5f0',
                    100: '#ffe8dc',
                    200: '#ffd0b8',
                    300: '#ffaa85',
                    400: '#ff774d',
                    500: '#ff5000', // Taobao Signature Flame Orange
                    600: '#e64000',
                    700: '#cc3000',
                    800: '#a32400',
                    900: '#801d00',
                    950: '#470d00',
                },
                tmall: {
                    500: '#ff0036', // Tmall Red
                    600: '#d9002e',
                },
                gold: {
                    400: '#ffd700',
                    500: '#ffc107',
                    600: '#e0a800',
                },
                dark: {
                    bg: '#0c0f17',
                    card: '#121824',
                    border: '#1e2638',
                    hover: '#1a2233'
                }
            },
            boxShadow: {
                'glow': '0 0 25px -5px rgba(255, 80, 0, 0.45)',
                'glow-gold': '0 0 25px -5px rgba(255, 193, 7, 0.45)',
            }
        },
    },
    plugins: [forms, typography],
};
