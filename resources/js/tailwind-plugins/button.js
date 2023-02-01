module.exports = function ({ addComponents, addUtilities, theme, config }) {
    const colors = config('theme.colors', {}),
          expectedVariants = ['50', '100', '200', '300', '400', '500', '600', '700', '800', '900'],
          buttons = {};

    for (const colorName in colors) {
        const color = colors[colorName];

        if (typeof color !== 'object') {
            continue;
        }

        if (! expectedVariants.every(key => Object.keys(color).includes(key))) {
            continue;
        }

        buttons[`.button--${colorName}`] = {
            backgroundColor: color['500'],
            color: theme(`colors[white]`),
            '@apply shadow': {},
        };

        buttons[`.button--${colorName}:hover:not([disabled]):not(.button--disabled):not(.button--busy):not(.button--no-hover)`] = {
            backgroundColor: color['700'],
        };

        buttons[`.button--${colorName}:focus:not([disabled]):not(.button--disabled):not(.button--busy):not(.button--no-hover):not([x-ripple])`] = {
            [`@apply ring-${colorName}-500/75`]: {},
        };

        // Outlined buttons
        buttons[`.button-outlined.button--${colorName}`] = {
            color: color['600'],
            '--button-border-color': theme(`colors.${colorName}.500`),
            '--ripple-color': theme(`colors.${colorName}.400`),
        };

        buttons[`.button-outlined.button--${colorName}:hover:not([disabled]):not(.button--disabled):not(.button--busy):not(.button--no-hover)`] = {
            backgroundColor: theme(`colors.${colorName}.50`),
            '--button-border-color': theme(`colors.${colorName}.600`),
        };

        // Text buttons
        buttons[`.button-text.button--${colorName}`] = {
            color: color['600'],
            '--ripple-color': color['300'],
        };

        buttons[`.button-text.button--${colorName}:hover:not([disabled]):not(.button--disabled):not(.button--busy):not(.button--no-hover)`] = {
            backgroundColor: color['50'],
        };

        buttons[`.button-text.button--${colorName}:active:not([disabled]):not(.button--disabled):not(.button--busy):not(.button--no-hover)`] = {
            backgroundColor: color['50'],
        };
    }

    const buttonUtilities = {
        // icon
        '.button--icon': {
            paddingLeft: theme('spacing[2]'),
            paddingRight: theme('spacing[2]'),
        },

        // xs
        '.button--xs': {
            paddingTop: theme('spacing[1.5]'),
            paddingBottom: theme('spacing[1.5]'),
            fontSize: theme('fontSize.xs'),
            lineHeight: theme('lineHeight[4]'),
        },
        '.button--xs:not(.button--icon)': {
            paddingLeft: theme('spacing[2.5]'),
            paddingRight: theme('spacing[2.5]'),
        },
        '.button--xs svg:not(.plain)': {
            height: theme('height.4'),
            width: theme('width.4'),
        },
        '.button--xs.button--icon': {
            width: '25px',
            height: '25px',
        },

        // sm
        '.button--sm': {
            paddingTop: theme('spacing[2]'),
            paddingBottom: theme('spacing[2]'),
            fontSize: theme('fontSize.sm'),
            lineHeight: theme('lineHeight[4]'),
        },
        '.button--sm:not(.button--icon)': {
            paddingLeft: theme('spacing[3]'),
            paddingRight: theme('spacing[3]'),
        },
        '.button--sm.button--icon': {
            width: '36px',
            height: '36px',
        },

        // md
        '.button--md': {
            paddingTop: theme('spacing[2.5]'),
            paddingBottom: theme('spacing[2.5]'),
            fontSize: theme('fontSize.sm'),
        },
        '.button--md:not(.button--icon)': {
            paddingLeft: theme('spacing[5]'),
            paddingRight: theme('spacing[5]'),
        },
        '.button--md.button--icon': {
            width: '50px',
            height: '50px',
        },

        // lg
        '.button--lg': {
            paddingTop: theme('spacing[3]'),
            paddingBottom: theme('spacing[3]'),
            fontSize: theme('fontSize.base'),
        },
        '.button--lg:not(.button--icon)': {
            paddingLeft: theme('spacing[5]'),
            paddingRight: theme('spacing[5]'),
        },
        '.button--lg.button--icon': {
            width: '64px',
            height: '64px',
        },

        // xl
        '.button--xl': {
            paddingTop: theme('spacing[3.5]'),
            paddingBottom: theme('spacing[3.5]'),
            fontSize: theme('fontSize.base'),
        },
        '.button--xl:not(.button--icon)': {
            paddingLeft: theme('spacing[6]'),
            paddingRight: theme('spacing[6]'),
        },
        '.button--xl.button--icon': {
            width: '80px',
            height: '80px',
        },

        // Icon sizing in buttons with text and icon together
        '.button:is(.button--xs, .button--sm) .button__icon--left': {
            marginLeft: `-${theme('spacing[0.5]')}`,
        },
        '.button:is(.button--xs, .button--sm) .button__icon--right': {
            marginRight: `-${theme('spacing[0.5]')}`,
        },
        '.button:is(.button--lg, .button--xl) .button__icon--left': {
            marginRight: theme('spacing[3]'),
        },
        '.button:is(.button--lg, .button--xl) .button__icon--right': {
            marginLeft: theme('spacing[3]'),
        },
        '.button:is(.button--xs, .button--sm) .button__icon svg:not(.plain)': {
            height: theme('height.4'),
            width: theme('width.4'),
        },
        '.button:is(.button--md, .button--lg, .button--xl) .button__icon svg:not(.plain)': {
            height: theme('height.5'),
            width: theme('width.5'),
        },

        // Icon sizing in buttons with icon only
        '.button--md.button--icon svg:not(.plain), .button.button--icon svg:not(.plain)': {
            height: theme('height.6'),
            width: theme('width.6'),
        },
        '.button--xs.button--icon svg:not(.plain)': {
            height: theme('height[3]'),
            width: theme('width[3]'),
        },
        '.button--sm.button--icon svg:not(.plain)': {
            height: theme('height[4]'),
            width: theme('width[4]'),
        },
        '.button--lg.button--icon svg:not(.plain)': {
            height: theme('height.8'),
            width: theme('width.8'),
        },
        '.button--xl.button--icon svg:not(.plain)': {
            height: theme('height.9'),
            width: theme('width.9'),
        },

        // Loader sizes in buttons (md will use default size)
        '.button:is(.button--xs, .button--sm) .la-ball-clip-rotate-pulse': {
            height: '16px',
            width: '16px',
        },
        '.button:is(.button--xs, .button--sm) .la-ball-clip-rotate-pulse > div:first-child': {
            height: '16px',
            width: '16px',
            borderWidth: '1px',
        },
        '.button--sm:is(.button--xs, .button--sm) .la-ball-clip-rotate-pulse > div:last-child': {
            height: '8px',
            width: '8px',
        },

        '.button:is(.button--xl) .la-ball-clip-rotate-pulse': {
            height: '36px',
            width: '36px',
        },
        '.button:is(.button--xl) .la-ball-clip-rotate-pulse > div:first-child': {
            height: '36px',
            width: '36px',
            borderWidth: '3px',
        },
        '.button--sm:is(.button--xl) .la-ball-clip-rotate-pulse > div:last-child': {
            height: '22px',
            width: '22px',
        },
    };

    addComponents(buttons);
    addUtilities(buttonUtilities);
};
