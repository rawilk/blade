const darkModeSelector = require('./util/darkModeSelector');
const addDarkVariant = require('./util/addDarkVariant');
const plugin = require('tailwindcss/plugin');

module.exports = plugin.withOptions(function (options = {}) {
    return function ({ addUtilities, config, theme }) {
        const darkSelector = darkModeSelector(config('darkMode', 'class'));
        const styles = {};

        // buttons
        if (options.button ?? true) {
            addDarkVariant(styles, '.button', darkSelector, {
                backgroundColor: 'var(--button-dark-bg)',
                color: 'var(--button-dark-text-color, var(--button-color))',
            });

            addDarkVariant(styles, '.button-outlined:not([disabled]):not(.button--disabled):not(.button--busy):not(.button--no-hover)', darkSelector, {
                backgroundColor: 'var(--button-dark-bg)',
                borderColor: 'var(--button-dark-border-color)',
            });

            addDarkVariant(styles, '.button-contained:is([disabled], .button--disabled):not(.button--busy)', darkSelector, {
                backgroundColor: theme('colors.slate.300'),
                '@apply text-slate-700/50': {},
            });

            addDarkVariant(styles, '.button-outlined:is([disabled], .button--disabled):not(.button--busy)', darkSelector, {
                '@apply border-slate-300/25': {},
                '@apply text-slate-300/25': {},
            });

            addDarkVariant(styles, '.button-text:is([disabled], .button--disabled):not(.button--busy)', darkSelector, {
                '@apply text-slate-300/25': {},
            });
        }

        // cards
        if (options.card ?? true) {
            addDarkVariant(styles, '.card', darkSelector, {
                '--card-bg': 'var(--card-dark-bg)',
                '--card-border-color': 'var(--card-dark-border-color)',
                '--card-body-color': 'var(--card-dark-body-color)',
                '--card-header-bg': 'var(--card-dark-header-bg)',
                '--card-header-color': 'var(--card-dark-header-color)',
                '--card-subtitle-color': 'var(--card-dark-subtitle-color)',
                '--card-footer-bg': 'var(--card-dark-footer-bg)',
                '--card-footer-color': 'var(--card-dark-footer-color)',
                '--card-link-hover-bg': 'var(--card-dark-link-hover-bg)',
            });
        }

        // links
        if (options.link ?? true) {
            addDarkVariant(styles, '.app-link--dark', darkSelector, {
                '--link-text-color': 'var(--link-dark-dark-mode-text-color)',
                '--link-hover-text-color': 'var(--link-dark-dark-mode-hover-text-color)',
            });
        }

        addUtilities(styles);
    };
});
