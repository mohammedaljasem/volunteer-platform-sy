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
            fontFamily: {
                sans: ['Cairo', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#2D3748',
                    light: '#4A5568',
                    dark: '#1A202C',
                },
                secondary: {
                    DEFAULT: '#48BB78',
                    light: '#68D391',
                    dark: '#38A169',
                },
            },
        },
    },

    plugins: [forms],
};
