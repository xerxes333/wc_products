=== Plugin Name ===
Donate link: http://triple3studios.com
Tags: diffbot
Requires at least: 4.4
Tested up to: 4.4
Stable tag: 4.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin connects to the Diffbot API and retrieves a product from a user supplied URL.  
It uses the WordPress Plugin Boilerplate as a template (http://wppb.io/).

== Installation ==

1. Download the ZIP file from GitHub
2. Extract the folder into your WordPress `/wp-content/plugins/` dir
3. Rename the plugin to `wc_products`
4. Log into the WordPress Admin panel and activate the plugin
5. Navigate to Settings >> Product Settings and save the Diffbot API token


== Use ==

1. Add a new product
2. In the Diffbot Search box copy/paste a URL to a product you wish to create
3. Click the Diffbot! button
4. Confirm results are as expected
5. Publish (or Save Draft) to save the product

== Notes ==

- The request did not indicate that the Products should be viewable to the public
  so when creating the custom post type I set the public flag to false.  But I left 
  the boilerplate code for the public side in the repo since its completely reasonable 
  this would become a necessary feature in a real world plugin.  

- I decided to use JQuery to make the ajax request to DiffBot rather than using PHP and 
  curl because I wanted to avoid going through WordPress admin-ajax.  This makes
  the code a little harder to maintain but offers the users a better experience (imho).
  
- Rather than having the user submit the URL to DiffBot and automatically creating a Product
  in the database (as outlined in the request), I wanted to give the user the ability to review 
  and modify the information returned from Diffbot before the product was saved.  I felt it was 
  necessary to deviate from the request because the results from DiffBot are sometimes not what 
  the user would expect and this gives them the ability to manage any discrepancies.   

- I changed the Wc_products_Admin->wc_products_add_product_fields() method to 
  remove any post meta data records that had empty values.  This made more sense 
  from the user perspective and also helps keep clutter out of the post_meta table.
  
- There are a lot more features and better (more robust) design patterns I could incorporate but 
  I forced myself to limit the time I spent on this project to the suggested time limit of 8-10 hours.

- If I spent more time on the project I would re-work the js portion to make it
  more extensible and maintainable by using Backbone & Underscore to handle the 
  requests and DOM manipulation.