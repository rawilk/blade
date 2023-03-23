---
title: Installation
sort: 3
---

## Installation

You can install the package via composer:

```bash
composer require rawilk/blade
```

## Configuration

You may publish the config file via:

```bash
php artisan vendor:publish --tag="blade-config"
```

[Click here](https://github.com/rawilk/blade/blob/{branch}/config/blade.php) to view the default configuration.

## Assets

### Package Styles

Assuming your app CSS file is located in `/resources/css/app.css`, you can load in the package's styles like this:

```css
@import '../../vendor/rawilk/blade/resources/css/index.css';
```

This will import all the package's styles into your stylesheet, however you are free to import only the stylesheets you need as well; they are all
located in the same directory as the `index.css` stylesheet.

> {tip} Check out the docs on [Customizing CSS](/docs/blade/{version}/advanced-usage/customizing-css) to learn how to properly configure Tailwind so the styles work correctly.

## Views

You may override any component's view by publishing them to your project:

```bash
php artisan vendor:publish --tag="blade-views"
```

## Components

Even though all components come enabled out-of-the-box, you might just want to
only load the components you need in your app for performance reasons. To do so,
first [publish the config file](#user-content-configuration), then remove the components
you don't need from the `components` settings.

You can also choose to use different classes for some components. This allows you
to either extend or completely change the component's functionality by using a custom class
and/or view of your own.

> {tip} If you remove an alias of a component, it will still be available under the `blade::` component namespace.

### Component Namespace

The package also declares a `blade` blade component namespace. This means that
for any component you may also use the `<x-blade::component-name>` syntax. For the `button`
component, you would use `<x-blade::buttons.button />`. If you choose to render components 
using this syntax, you can safely remove the component alias from the config.

## Prefixing

Using components from this library might conflict with other ones from a different
library or components from your own app. To prevent this you can opt to prefixing
components by default to prevent these collisions. You can do this by
setting the `prefix` option in the config file:

```php
'prefix' => 'tw',
```

Now all (aliases) components can be referenced as usual but with the prefix before their name:

```html
<x-tw-button ... />
```

For obvious reasons, the docs don't use any prefix in their code examples. So keep
this in mind when setting a prefix and copying/pasting code snippets.
