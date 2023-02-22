/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      'resources/js/**/*.vue'
  ],
  theme: {
    extend: {
        textColor: {
            main: '#4796b4'
        },
        backgroundColor: {
            'main-blue': '#4796b4',
            'second-blue': '#77b8cd'
        },
        backgroundImage: {
            home: "url('/images/home/background.webp')"
        }
    },
  },
  plugins: [],
}
