const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    // mode: 'jit',
    darkMode: 'media',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        container: {
            center: true,
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                dark: {
                    100: '#A9A9B2',
                    600: '#3B3B40',
                    700: '#313135',
                    800: '#222225',
                    900: '#111111',
                    green: '#10CB8A'
                }
            }
        },
    },
    variants: {
        extend: {
            textColor: ['odd'],
            backgroundColor: ['odd']
        }
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
};
