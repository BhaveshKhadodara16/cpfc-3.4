=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's), freemius
Donate link: http://www.multidots.com
Tags: comments, spam
Requires at least: 4.0
Tested up to: 5.4
Requires PHP: 5.7
Stable tag: 3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.

== Description ==

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `woocommerce-conditional-product-fees-for-checkout.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==
= 3.4 - 28-04-2020 =
* New - Global settings - Display all fee in one label.
* Compatible with WooCommerce 4.0.x
* Compatible with WordPress 5.4.x

= 3.3 - 18-03-2020 =
* Fixed - Once multiple postcodes added only last postcode works.
* New: Added master settings to hide all the fees once 100% discount applies.

= 3.2 = 17-12-2019
* Fixed - minor bug fixing

= 3.1 = 21-11-2019
* New - AND/OR rule in General Shipping Rule
* New - AND/OR rule in Particular advance shipping rule
* New - Advance shipping cost based on Category subtotal
* New - Advance shipping cost based on Product subtotal
* New - Advance shipping cost based on Shipping class subtotal
* New - Import Export shipping method with json file
* New - Deactivate plugin automatically when deactivate WooCommerce
* New - Freemius for both plugin free and pro
* Fixed - Validation for Max qty/weight/subtotal in admin side 
* Fixed - Advance Pricing Rules is not working when you set normal condition fee rule as Cart SubTotal ( before discount ) and Cart SubTotal ( after discount )
* Fixed - New fees order not properly
* Fixed - Zone with Postcode range not working.
* Fixed - Multiple product qty count for multiple category with same product
* Compatible with WordPress 5.3.x and WooCommerce 3.8.x

= 1.5.2 = 17-09-2019
* Compatible with WPML

= 1.5.1 =
* Fixed - Zone issue

= 1.5 =
* VIP minimum - Included with all version.
* Compatible with WooCommerce 3.7.x

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`