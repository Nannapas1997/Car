const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament**/*.blade.php',
        './src/**/*.{html,js}',
        './src/input.css'
    ],

    theme: {
        extend: {
           colors: colors.rose,
           primary: colors.blue,
           success: colors.green,
           warning: colors.yellow,
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
    'google_fonts' : 'href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet',
};
