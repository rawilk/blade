---
title: Customizing CSS
sort: 1
---

## Introduction

If you want to change the look of the components to match the style of your own app, you have multiple options.

## Option 1: Use Your Own Tailwind CSS Configuration

You can import the `index.css` and run every `@apply` rule through your own `tailwind.config.js`. This is the most common way.

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@import "../../vendor/rawilk/blade/resources/css/index.css";

/* override our styles here */
```

You may also choose to import only the stylesheets you need instead of everything in the index.css file. Most components have their own stylesheets (i.e. `button.css` for button elements).

## Option 2: Copy the CSS To Your Own Project

If you want full-control, you can always copy each of the stylesheets from `resources/css` to your own project and go wild. In this example, we created a file called `custom/blade.css`.
Beware: you will have to manually keep this CSS in sync with changes in future package updates:

```css
/* app.css */
@import "custom/blade.css";
```

Let's say you wanted to change some styling for the `.button--icon` variant of a button. You could do so like this in the file you just created with the pasted in styles from the package:

```css
/* custom/blade.css */
.button--icon {
    @apply rounded-none p-2;

    /* styles from the package */
    /*@apply rounded-full p-0;*/
}
```

## Tailwind Configuration

Some custom configuration is necessary to ensure our package's CSS compiles correctly, and that the components are styled correctly.

### Required Variants

if you choose [Option 1](#user-content-option-1-use-your-own-tailwind-css-configuration) above, make sure you have the following variants included in your `tailwind.config.js` configuration:

```js
// tailwind.config.js

const colors = require("tailwindcss/colors");

module.exports = {
    // ...
    theme: {
        extend: {
            colors: {
                slate: colors.slate,
            },
        },
    },
};
```

This will extend the default tailwind color palette to include the `slate` color variant.

### Plugins

Some components have custom tailwind plugins written for them to make styling for various colors easier. You will need to include the following plugins in your tailwind config for any
components you are using:

```js
// tailwind.config.js

module.exports = {
    // ...

    plugins: [
        require("./vendor/rawilk/blade/resources/js/tailwind-plugins/button"),
    ],
};
```

### Purge CSS/Tailwind JIT

Purge CSS is useful for trimming out unused styles from your stylesheets to reduce your overall build size. To ensure
the class styles from this package don't get purged from your production build, you should add the following to your
purge css content configuration:

> {note} The following code snippet is for a TailwindCSS build configuration using a `tailwind.config.js` file in the build.

```js
module.exports = {
    // ...
    content: [
        // Typical laravel app purge css content
        "./app/**/*.php",
        "./resources/**/*.php",
        "./resources/**/*.js",

        // Make sure you add these lines
        "./vendor/rawilk/blade/src/**/*.php",
        "./vendor/rawilk/blade/resources/**/*.php",
        "./vendor/rawilk/blade/config/blade.php",
    ],
};
```

Due to the dynamic nature of how some classes are rendered onto the markup, you may still find some of them being purged by Tailwind. Here's a few you may want to
add to your `safelist` to prevent from being purged:

```js
module.exports = {
    // ...
    safelist: [
        {
            // For button sizing and colors
            pattern: /button--*/,
        },
    ],
};
```

You can of course be more selective in what you safelist. For example, instead of using a pattern for the `.button--` color and sizing classes, you could explicitly define specific color
and size classes you want to safelist instead of using a regex pattern:

```js
module.exports = {
    // ...
    safelist: ["button--blue", "button--red", "button--md", "button--lg"],
};
```
