/** @type {import('tailwindcss').Config} config */

//--------------------------------------------------------------------------
// Tailwind site configuration
//--------------------------------------------------------------------------
//
// Use this file to completely define the current sites design system by
// adding and extending to Tailwinds default utility classes.
//

const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')
const colors = require('tailwindcss/colors')

module.exports = {
  content: ['./index.php', './app/**/*.php', './resources/**/*.{php,vue,js}'],
  presets: [require('tailwindcss/defaultConfig')],
  theme: {
    // Here we define the default colors available. If you want to include
    // all default Tailwind colors you should extend the colors instead.
    colors: {
        black:     '#000',
        blue:      '#2A7DE1',
        orange:    '#FF6B00',
        pink:      '#F97FB5',
        white:     '#fff',
        yellow:    '#FFB71B',
        // Neutrals: neutral colors, with a default fallback if you don't need shades. Always set a DEFAULT when you use shades.
        neutral: {
            DEFAULT: colors.black,
            ...colors.slate
        },
        // Primary: primary brand color with a default fallback if you don't need shades. Always set a DEFAULT when you use shades.
        primary: {
            DEFAULT: colors.black
        },
    },
    extend: {
      zIndex: {
        '60': '60',
        '70': '70',
        '80': '80',
        '90': '90',
        '100': '100',
      },
      padding: {
         '18': '4.5rem',
      },
      // Set default transition durations and easing when using the transition utilities.
      transitionDuration: {
        DEFAULT: '300ms',
      },
      transitionTimingFunction: {
        DEFAULT: 'cubic-bezier(0.4, 0, 0.2, 1)',
      },
      animation: {
        appearsin: 'appearsIn 1.2s ease forwards',
        appearsout: 'appearsOut 0.6s ease forwards',
      },
    },
    // that is actual animation
    keyframes: theme => ({
        appearsIn: {
            '0%': {
              opacity: 0,
              transform: 'translateY(40px)',
              },
            '100%': {
              opacity: 1,
              transform: 'translateY(0)',
            },
        },
        appearsOut: {
            '0%': {
                opacity: 1,
                transform: 'translateY(0)',
            },
            '100%': {
                opacity: 0,
                transform: 'translateY(40px)',
            },
        },
      }),
    // Remove the font families you don't want to use.
    fontFamily: {
      mono: [],
      sans: [
        'Aeonik',
        ...defaultTheme.fontFamily.sans,
      ],
      serif: [],
    },
    // The font weights available for this site.
    fontWeight: {
      // hairline: 100,
      // thin: 200,
      // light: 300,
      normal: 400,
      // medium: 500,
      // semibold: 600,
      bold: 700,
      // extrabold: 800,
      // black: 900,
    },
    fontSize: {
        sm: '0.8rem',
        base: '1rem', // 20px
        'xl': '1.25rem', // 25px
        '2xl': '1.5rem', // 30px
        '3xl': '1.875rem', // 37.5px
        '4xl': '2.25rem', // 45px
        '5xl': '3rem', // 60px
        '6xl': '3.75rem', // 75px
        '7xl': '4.5rem', // 90px
        '8xl': '6rem', // 120px
        '9xl': '8rem', // 160 px
    },
    letterSpacing: { //tracking
        //tightest: '-.075em',
        //tighter: '-.05em',
        tight: '-.025em',
        normal: '0',
        //wide: '.025em',
        //wider: '.05em',
        //widest: '.1em',
        //widest: '.25em',
    },
    lineHeight: { //leading
        none: '1',
        tight: '1.25',
        snug: '1.375',
    }
  },
  plugins: [
    plugin(function({ addBase, theme }) {
      addBase({
        ':root': {
            // Fluid typography from 1 rem to 1.2 rem with fallback to 20px.
            fontSize: '20px',
            letterSpacing: '-0.2px',
            lineHeight: '1.2',
            fontWeight: '450',

            // Safari resize fix.
            minHeight: '0vw',
        },
        // Default color transition on links unless user prefers reduced motion.
        '@media (prefers-reduced-motion: no-preference)': {
          'a': {
            transition: 'color .3s ease-in-out',
          },
        },
        'html': {
            color: theme('colors.neutral.DEFAULT'),
            //--------------------------------------------------------------------------
            // Set sans, serif or mono stack with optional custom font as default.
            //--------------------------------------------------------------------------
            // fontFamily: theme('fontFamily.mono'),
            fontFamily: theme('fontFamily.sans'),
            // fontFamily: theme('fontFamily.serif'),
        },
        'mark': {
          backgroundColor: theme('colors.primary.DEFAULT'),
          color: theme('colors.white')
        },
      })
    }),

    // Custom components for this particular site.
    plugin(function({ addComponents, theme }) {
        const components = {
          '.fluid-container, .container': {
              width: '100%',
              maxWidth: '100%',
              marginLeft: 'auto',
              marginRight: 'auto',
              // Use safe-area-inset together with default padding for Apple devices with a notch.
              paddingLeft: `calc(env(safe-area-inset-left, 0rem) + ${theme('padding.5')})`,
              paddingRight: `calc(env(safe-area-inset-right, 0rem) + ${theme('padding.5')})`,
          },
          '@media screen(sm)': {
            '.container': {
                maxWidth: theme('screens.md'),
            },
          },
          '@media screen(md)': {
            // Larger horizontal padding on larger screens.
            '.fluid-container , .container': {
              // Use safe-area-inset together with default padding for Apple devices with a notch.
              paddingLeft: `calc(env(safe-area-inset-left, 0rem) + ${theme('padding.10')})`,
              paddingRight: `calc(env(safe-area-inset-right, 0rem) + ${theme('padding.10')})`,
            },
            '.container': {
                maxWidth: theme('screens.md'),
            },
          },
          '@media screen(lg)': {
            '.container': {
                maxWidth: theme('screens.lg'),
            },
          },
          '@media screen(xl)': {
            '.container': {
                maxWidth: theme('screens.xl'),
            },
          },
          '@media screen(2xl)': {
            '.container': {
                maxWidth: theme('screens.2xl'),
            },
          },
          '.main': {
              paddingTop: 0,
              paddingBottom: 0,
              rowGap: 0,
          },
        }
        addComponents(components)
    }),

    // Custom utilities for this particular site.
    plugin(function({ addUtilities, theme, variants }) {
      const newUtilities = {
      }
      addUtilities(newUtilities)
    }),
    // Custom variants for this particular site.
    plugin(function ({ addVariant }) {
        // Instead of hard-coded px use sm, md, lg breakpoints value from config.
        addVariant('mobile-only', "@media screen and (max-width: calc(theme('screens.sm') - 1px) ) ");
        addVariant('tablet-only', "@media screen and (min-width: theme('screens.sm')) and (max-width: calc(theme('screens.lg') - 1px) )");
        addVariant('mbtb-only', "@media screen and (max-width: calc(theme('screens.lg') - 1px) )");
    }),
  ]
}
