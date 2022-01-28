const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: ['./resources/**/*.{css,js,vue,blade.php}'],
  safelist: [
    {
      pattern: /bg-\w+-\d+/
    }
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['"Roboto"', ...defaultTheme.fontFamily.sans],
      }
    }
  },
  variants: {},
  plugins: []
}
