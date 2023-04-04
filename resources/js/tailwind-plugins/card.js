const darkModeSelector = require('./util/darkModeSelector');
const addDarkVariant = require('./util/addDarkVariant');

module.exports = function ({ addComponents, config, theme }) {
    const darkSelector = darkModeSelector(config('darkMode', 'class')),
        cards = {};

    const variants = {
        error: 'red',
        success: 'green',
        warning: 'orange',
        info: 'blue',
    };

    for (const variant in variants) {
        const color = variants[variant];

        cards[`.card-header--${variant}`] = {
            '--card-header-bg': theme(`colors.${color}.300`),
            '--card-header-color': theme(`colors.${color}.800`),
            '--card-subtitle-color': theme(`colors.${color}.800`),
            '--card-action-hover-bg': theme(`colors.${color}.200`),
        };

        addDarkVariant(cards, `.card-header--${variant}`, darkSelector, {
            '--card-header-bg': theme(`colors.${color}.400`),
            '--card-header-color': theme(`colors.${color}.900`),
            '--card-subtitle-color': theme(`colors.${color}.900`),
        });
    }

    addComponents(cards);
};
