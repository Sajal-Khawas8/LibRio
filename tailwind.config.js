export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      backgroundImage: {
        "home": "url(" + "../../public/banner.jpeg" + ")"
      },
      container: {
        screens: {
          '2xl': '1400px',
        },
        center: true,
      }
    },
  },
  plugins: [],
}