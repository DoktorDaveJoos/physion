const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sansguest: ['Inter', ...defaultTheme.fontFamily.sans],
                displayguest: ['Lexend', ...defaultTheme.fontFamily.sans],
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Lato'],
                number: ['Roboto Mono'],
            },
            colors: {
                primary: {
                    DEFAULT: '#0000BF',
                    50: '#EAEAFF',
                    100: '#D3D3FF',
                    200: '#A6A6FF',
                    300: '#7878FF',
                    400: '#4A4AFF',
                    500: '#1C1CFF',
                    600: '#0000ED',
                    700: '#0000BF',
                    800: '#000091',
                    900: '#000063',
                    950: '#00004C',
                },
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
