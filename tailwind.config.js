/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./public/js/*.js"
  ],
  theme: {
    extend: {
      colors: {
        // primary: '#FFDED9',
        yellow: '#F7F4F1',
        secondary: '#171514',
        trinary: '#FF9C8C',
        test: '#F7F4F1',
        text: '#57534E'
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
        '20vh': '40vh',
        '80vh': '80vh',
        '70vh': '70vh',
        '90' : '90%',
        '100p': '100px',
        '30p' : '25px'
      },
       gridTemplateColumns: {
        'color': 'repeat( auto-fit, 30px)',
        'color-xl': 'repeat( auto-fit, 30px)',
      }, 
      gridTemplateRows: {
        'color': 'repeat( auto-fit, 30px)',
        'color-xl': 'repeat( auto-fit, 30px)',
      }
    },
  },
  plugins: [require("daisyui")],
  daisyui: {
    themes: [],
  },
}
