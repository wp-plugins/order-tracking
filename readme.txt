=== Plugin Name ===
Contributors: Rustaurius, EtoileWebDesign
Tags: order tracking, order tracking system, purchase orders, order processing, order management, inventory management, deliveries, order status, customer orders, customer support, ticket tracking, support tickets, support ticket, tickets, client, customer, helpdesk, support software, help desk, help desk software
Requires at least: 3.5.0
Tested up to: 4.0
License: GPLv3
License URI:http://www.gnu.org/licenses/gpl-3.0.html

Allows a site's administrators to post updates about the status of orders or support tickets that can be accessed through the front-end of the WordPress site.

== Description ==

Allows a site's administrators to post updates about the status of orders or support tickets that can be accessed through the front-end of the WordPress site.

[youtube http://www.youtube.com/watch?v=rMULYuPjVXU]

Through the WordPress admin panel, you can:

* Set up order or ticket numbers which customers can search
* Automatic e-mailing when the status of an order/ticket changes
* Ability to create customers, assign a group of orders to a customer
* Ability to create sales rep and assign customers and orders to them
* Custom order fields to display information such as weight, estimated delivery, price, insurance options, etc.
* Ability to create/update orders by uploading a spreadsheet
* Ability to export orders to a spreadsheet
* Update the status of an order or ticket
* Create custom statuses that suit your business
* Hide or delete orders/tickets
* Options to decide what order information is displayed, whether the information should be displayed in a new window, with AJAX, etc.
* Responsive, clean CSS that's completely customizable

Upcoming features:
* PayPal integration
* Product catalogue integration
* Quickbooks online integration (potentially, depending on community interest level)

Please head to the "Support" tab to report errors or make suggestions.
Demo videos will be posted as soon as they are available.

Translation:
* Italian (thanks to MD Ariful)
* German (thanks to Benko)

== Installation ==

1. Upload the `order-tracking` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the newly created admin menu to input and update orders, or create new order statuses
4. Put a tracking form on the front-end of your site with the "[tracking-form]" shortcode
5. You can add the following attributes to the shortcode: order_form_title, order_field_text, submit_text

--------------------------------------------------------------



== Frequently Asked Questions ==

= What attributes does the "[tracking-form]" shortcode accept? =

You can specify the label for the field and the value of the submit button with "order_field_text" and "submit_text" respectively.

= Tutorial Videos = 
[youtube http://www.youtube.com/watch?v=YySDJa69HAE]
[youtube http://www.youtube.com/watch?v=IdfsGa0You0]


== Screenshots ==

1. Admin area
2. Sample order tracking page

== Changelog ==
= 2.0.3 =
- Fixed a spreadsheets error

= 2.0.2 =
- Fixed a debugging error

= 2.0.1 = 
- Fixed a PHPExcel error

= 2.0 =
- MAJOR UPDATE
- Added Custom Fields which can display any type of information associated with an order (weight, size, estimated delivery, etc.)
- Added Customers tab, lets you create customers and assign orders to them
- Added Sales Rep tab, lets you create sales rep, assign orders and customers to them
- Added the ability to export orders to Excel
- Added the ability to delete all orders
- Included a German translation
- Fixed a confirmation error

= 1.6 =
- Included an Italian translation
- Added an optoin to require verification of the e-mail address associated with an order
- Added a message for when there are no results found
- In the admin area, it is now possible to search the order list by order number
- Fixed an error that didn't allow the order form instructions to be changed via attribute

= 1.5 =
- Added a .pot file to the lang folder

= 1.4 =
- Added an attribute to allow admins to set the field labels for order results
- Fixed an error with the order form instructions attribute

= 1.3 =
- Added an atribute to set the order form title
- Added an option to change the order form instructions
- Added an option to set the timezone order statuses are calculated for (only applies to new statuses)
- Fixed an error that was limiting the number of orders displayed to 20
- Fixed an escaping error with order names and notes

= 1.2 =
- Made managing order statuses easier
- Added an optional graphic to show the progress of orders
- Update/Error messages have been fixed, so that they should now diplay

= 1.1 =
- Added an option to allow AJAX order retrieval
- Orders can be created and updated via uploading a spreadsheet

= 1.0 =
- First of 2 big updates to be released in June
- Order E-mails added (can send out e-mails automatically when an order is created or updated)
- Allow admins to select what information is displayed when an order is searched
- CSS customization through the option page
- Added in "Public" and "Private" order notes
- Option to open search results in a new window/tab

= 0.3 =
- Removed extra CSS that could cause compatibility issues

= 0.2 =
- Fixed the tabs errors

= 0.1 =
- Initial beta version. Please make comments/suggestions in the "Support" forum.

== Upgrade Notice ==

