const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    // presets: [
        
    //     require('./vendor/wireui/wireui/tailwind.config.js')
    // ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        // './vendor/wireui/wireui/resources/**/*.blade.php',
        // './vendor/wireui/wireui/ts/**/*.ts',
        // './vendor/wireui/wireui/src/View/**/*.php'
    ],

    theme: {
        screens: {
            xxs: "200px",
            // iPhone 12 Pro
            
            xs: "475px",
            //  galaxy fold -> full

            sm: "640px",
            // => @media (min-width: 640px) { ... }
            // Galaxy Note 3, Galaxy S9

            md: "768px",
            // => @media (min-width: 768px) { ... }
            // iPad Mini

            lg: "900px",
            // => @media (min-width: 1024px) { ... }
            //  Galaxy S20, pixel 7

            xl: "1024px",
            // => @media (min-width: 1280px) { ... }
            // Nest Hub

            "2xl": "1280px",
            // Nest HUb Max
            // => @media (min-width: 1536px) { ... }
        },
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            
            colors: {
                'blue-1': '#e6eaf3',

                'blue-2': '#9cabce',

                'blue-3': '#6b81b5',
                // ELM 3
                'blue-4': '#2058B8',
                // ELM 2
                'blue-5': '#153E9D',
                // ELM 1            //    
                'blue-6': '#082D84',
                
                'blue-7': '#06246a',
                // ELM 4
                'blue-8': '#08215B',

                'blue-9': '#01040d',
                
              },
        },
        
        fontFamily: {
            body: ['Poppins'],
        },

        
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
