const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament**/*.blade.php',
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
    'google_fonts' : 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap',
};
