/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./public/js/*.js"
  ],
  theme: {
    extend: {
      screens: {
      tablet: {'min': '640px'},
      desk : {'min': '1280px'},
      },
      colors: {
        primary: '#FFDED9',
        yellow: '#F7F4F1',
        secondary: '#171514',
        trinary: '#FF9C8C',
        pink: '#FF9C8C',
        test: '#F7F4F1',
        text: '#57534E',
        border: '#9CA3AF'
      },
      fontSize: {
        base: '18px'
      },
      fontFamily: {
        body: ['Gothic A1', 'sans-serif'],
        heading: ['Playfair Display', 'serif']
      },
      letterSpacing: {
      '1': '0.05rem',
      '2': '0.1rem',
      },
      translate: {
        'm100': '-100%',
      },
      spacing: {
        '100vh': '100vh',
        '20vh': '40vh', 
        '80vh': '80vh',
        '70vh': '70vh',
        '90' : '90%',
        '100p': '100px',
        '30p' : '25px',
        '15%': '15%',
        '80%': '80%',
        '700p': '700px',
      },
       gridTemplateColumns: {
        'color': 'repeat( auto-fit, 25px)',
        'admin1' : '50px repeat(5,1fr)',
        'product-images': '50px 1fr'
      }, 
      gridTemplateRows: {
        'color': 'repeat( auto-fit, 20px)',
      },
      transitionProperty: {
        'height': 'height',
      },
      // keyframes: {
      //    side_bar: {
      //     // '0%': { transform: 'translateX(100%)' },
      //     '100%': { transform: 'translateX(0)' },
      //   }
      // },
      // animation: {
      //   side_bar: 'side_bar 0.3s 3s',
      // }
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [],
  },
}
