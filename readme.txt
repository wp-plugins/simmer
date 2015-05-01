=== Simmer for Recipes ===
Contributors: ChaseWiseman, lchelak, gobwd
Tags: recipes, recipe, cooking, food, food blog, content marketing, food content marketing, drinks, drink recipes, tutorial maker, tutorials, recipe maker, baking, crafts, DIY, do it yourself
Requires at least: 3.8
Tested up to: 4.2.1
Stable tag: 1.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simmer is a recipe publishing tool for WordPress.

== Description ==

We all love the simple, human act of sharing how to prepare a favorite meal. Simmer enables WordPress users to quickly and easily publish their recipes with minimal hassle. With a focus on the key areas necessary for a great recipe publishing experience, Simmer stays lightweight and easy to use and doesn't get bogged down by 101 half-baked features.

**Elegant UI**

Add ingredients, step-by-step instructions, sub-headings, structured cook times, and a lot more all within a user-friendly drag and drop interface.

**Built for Discovery**

Simmer automatically bakes semantic structure and [schema.org](http://schema.org) microdata in to the core of every recipe you publish. This allows Google to standardize and serve your recipes across a variety of devices and platforms.

**Easily Extendable**

Simmer is built with developers in mind. Utilize the many actions and filters detailed in the [Developer API](http://develop.simmerwp.com) to customize Simmer to fit any project. Or, check out the official [Extensions Library](https://simmerwp.com/extensions/) to find an extension that meets your needs. Check back often as new extensions are always being developed!

**Additional Features**

* Bulk-add ingredients & instructions
* Recipe categories
* Add recipe servings, yield, and source name and/or link
* Embed recipes anywhere in your posts or pages
* Front-end recipe printing

**Follow Simmer's development on [Github](http://github.com/bwdinc/simmer/)**

== Installation ==

1. Activate the plugin through the 'Plugins' menu in WordPress
2. Go to Settings > Recipes and configure the options
3. Go to Recipes > Add New to start creating with Simmer!
4. Have questions? Feel free to [consult the documentation](http://docs.simmerwp.com/).

== Screenshots ==

1. Simmer's recipe ingredients editor.
2. Simmer's recipe instructions editor.
3. Fine tune your recipe's detailed information.
4. Simmer's comprehensive settings screen for easily customizing your recipes.

== Frequently Asked Questions ==

= Is there a way to add an ingredient without adding a numerical value or measurement to it? (For instance, if an ingredient is to be added "to taste" or is optional.) =

Yes! Simply leave any measurement fields that you don't need blank, and they won't be included in your recipe at all. Then, write in "to taste" or any other instructions in the recipe name line itself or in your instructions.

= Can I change the wording used in the "add an ingredient" section? ie: a splash, a drop in the Misc. category? =

Yes. This labelling can be changed very easily through your [Simmer settings](https://simmer.zendesk.com/hc/en-us/articles/203867035-Configuring-Simmer-Settings).

= Can I add things like cook time and prep time to my recipes? =

Yes, Simmer provides a number of customized options for each recipe to provide metadata, including an attribution link back to an original recipe author if you'd like to include one.

= Can I use Simmer for e-commerce? =

Yes, with the Tinypass for Simmer extension (coming soon) you can easily monetize your media business or blog through micro payments. [Find out more from Tinypass](http://tinypass.com/).

== Changelog ==

= 1.3.0 =
* New: Items API for handling ingredients, instructions, and other custom recipe data
* New: Refactored architecture and file structure to allow for greater extensibility
* New: Major feature addition welcome screen
* Tweak: Documentation overhaul for the [Developer API reference](http://develop.simmerwp.com)

= 1.2.3 =
* Fix: Prevent theme icon font incompatibilities

= 1.2.2 =
* Fix: Ingredient amount display error with trailing or leading spaces

= 1.2.1 =
* New: Easy recipe printing
* Tweak: Refine microdata markup for single recipes
* Tweak: Ensure WordPress 4.2 compatibility
* Fix: Instructions microdata error

= 1.2.0 =
* New: Bulk add recipe ingredients or instructions
* New: 'Add Recipe' shortcode button and modal UI
* New: Enhanced embedded recipe display with excerpts and thumbnails
* New: [Developer API reference](http://develop.simmerwp.com)
* Tweak: Additional template classes and styling
* Tweak: Recipe author setting
* Tweak: Add more code documentation

= 1.1.0 =
* Add the Recent Recipes widget
* Add the Recipe Categories widget
* Add no-JS ingredient/instruction sorting
* Add shortcode recipe template with link & excerpt
* Adjust admin UI styling
* Change "attribution" to "source" and add label
* Remove <p> option from instructions list display
* Fix instructions list display setting
* Fix recipe excerpt display
* Update inline docs

= 1.0.3 =
* Add focus to input when adding new ingredients or instructions
* Add a plugin list table Settings link
* Fix a sortable UI scrolling bug
* Fix an admin JS error

= 1.0.2 =
Add licensing support

= 1.0.1 =
Fixed an early exit error on clean uninstall

= 1.0.0 =
Preheating the oven to 450...

== Upgrade Notice ==

= 1.3.0 =
This update makes significant database changes. It is recommended that you fully back up your recipes before proceeding.

= 1.0.1 =
This version fixes an error some encounter when attempting to uninstall the plugin. Please upgrade.
