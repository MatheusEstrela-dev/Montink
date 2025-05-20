import defaultTheme from 'tailwindcss/defaultTheme';

export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        background: '#0B0B0B',
        surface: '#1A1A1A',
        neonPurple: '#B15EFF',
        neonBlue: '#00F0FF',
        neonYellow: '#FFD93D',
        neonPink: '#FF4AE2',
        neonHover: '#8A00D4',
        textBase: '#EDEDED',
      },
    },
  },
  plugins: [],
};
