# WC_Divi_Fix_Additional_Fields

## The Problem

When using Divi's Additional Fields modules in a WooCommerce checkout form, you may encounter DOM ID conflicts. These conflicts arise because Divi renders the Additional Fields section as a hidden div within the Shipping Form AND it renders the Shipping Fields as a hidden div within the Additional Fields form. This leads to duplicate form fields/inputs with the same name and id. The conflicts can cause unexpected behaviors and bugs, making it difficult to have a smooth checkout process. Some UI elements, like the datepicker, are non-responsive if Shipping comes before Additional Fields. This can also cause the values saved to not be the values that are visible, which can be detrimental to customer satisfaction.

## The Solution

The `WC_Divi_Fix_Additional_Fields` class aims to resolve DOM ID conflicts in the WooCommerce checkout form when using Divi's Additional Fields modules. It provides a way to selectively utilize either the shipping fields or the additional fields based on the current Divi module being rendered, without having to hide duplicate fields with css.

## Installation

1. Place the `WC_Divi_Fix_Additional_Fields` folder in your theme or plugin directory.
2. Include the class file in your `functions.php` or main plugin file:
   ```php
   require_once('path/to/WC_Divi_Fix_Additional_Fields/class-WC_Divi_Fix_Additional_Fields.php');
   ```
3. Enjoy custom Divi Checkout layouts without all the bugs.

## Limitations

- This does not yet work on Customer Payment Page or Order Received Page... only Checkout.

### Filters

- `wc_get_template`: Replaces the default WooCommerce `form-shipping.php` template.
- `et_pb_module_shortcode_attributes`: Grabs the current Divi module slug to determine which fields to display.
- `wc_divi_hide_shipping_fields`: Determines whether to hide shipping fields.
- `wc_divi_hide_additional_fields`: Determines whether to hide additional fields.

### Methods

- `replace_shipping_form($template, $template_name)`: Replaces the default WooCommerce shipping form template with a custom one.
- `get_current_module($props, $attrs, $slug)`: Sets the current Divi module slug.
- `hide_shipping_fields()`: Logic to hide shipping fields based on the current Divi module.
- `hide_additional_fields()`: Logic to hide additional fields based on the current Divi module.
