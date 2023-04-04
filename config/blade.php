<?php

use Rawilk\Blade\Components;

return [
    /*
    |--------------------------------------------------------------------------
    | Component Defaults
    |--------------------------------------------------------------------------
    |
    | We've added some common options you may want to globally edit to avoid
    | having to change them everytime you call a component or having to
    | override a component definition.
    |
    */
    'defaults' => [
        'button' => [
            // Apply a color by default to every button
            'color' => 'slate',

            // Apply a variant by default to every button.
            // Supported: 'contained', 'outlined', 'text'
            'variant' => 'contained',

            // Enable or disable the ripple effect globally
            'ripple' => true,

            // Enable or disable the ripple focus effect globally
            // Note: will not apply to the button.link component
            'ripple_focus' => true,

            // Show or hide the loader globally
            // Set to `null` to show/hide based on presence of a `wire:click` attribute
            'show_loader' => null,

            // Round the edges of buttons globally
            'pill' => false,

            // Set the default size of buttons globally
            'size' => 'md',
        ],

        'card' => [
            // Apply a CSS class to the card body by default.
            'body_class' => null,

            // Remove all padding from the card body by default.
            'flush' => false,

            // Make the card header sticky by default.
            'sticky_header' => true,

            // Define the space from the top that the sticky header will be anchored to.
            // Use a string with a unit (e.g. '1rem')
            'sticky_header_offset' => '0',

            // Define the z-index of the sticky header by default.
            'sticky_header_z_index' => '21',

            // Set the icon to use by default for the collapse button.
            // Tip: We will rotate the icon 180 degrees when the card is collapsed,
            // so it's advisable to use an icon that works well in both directions.
            'collapse_icon' => 'heroicon-m-chevron-down',

            // Apply the ripple effect to card actions by default.
            'action_ripple' => true,
        ],

        'link' => [
            // Applies a css `app-link` class to the link
            'app_link' => true,

            // Applies a css `app-link--dark` class to the link - requires `app_link` to be true
            // Not to be confused with Tailwind's "dark" mode.
            'dark' => false,

            // Hides a visible icon indicating a link is external.
            // External indicators will never show up on button links
            'hide_external_indicator' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Aliases
    |--------------------------------------------------------------------------
    |
    | Here you may register aliases for components this package provides.
    | For example, instead of rendering a button with <x-blade::button.button>,
    | you may register an alias of 'button' and render it with <x-button>
    | instead.
    |
    | You can also override the component class definition as well, but this
    | isn't the only way to do that.
    |
    */
    'components' => [
        'button' => Components\Button\Button::class,
        'card' => Components\Card\Card::class,
        'link' => Components\Navigation\Link::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Component Prefix
    |--------------------------------------------------------------------------
    |
    | This value will be a prefix for all components aliases under the
    | `components` key. This is useful if you want to avoid collisions
    | with components from other libraries.
    |
    | If you set it to "tw", for example, you can reference like this:
    |
    | <x-tw-button>...</x-tw-button>
    |
    */
    'component_prefix' => '',
];
