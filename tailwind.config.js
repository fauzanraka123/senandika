/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        serif: ['Inter', 'serif'],
        sans: ['Inter', 'sans-serif'],
      },
      colors: {
        'brand': '#8B5E3C',
      }
    },
  },
  plugins: [],
}
