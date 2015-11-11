=== Plugin Name ===
Contributors: Rustaurius, EtoileWebDesign
Donate Link: http://www.etoilewebdesign.com/plugin-donations/
Tags: order tracking, order management, order management system, order tracking system, order tracking software, e-commerce, delivery, delivery note, product shipping, ship orders, shipping, shop, track email, track, purchase orders, order processing, inventory management, deliveries, order status, customer orders, customer support, ticket tracking, support tickets, support ticket, tickets, client, customer, helpdesk, support software, help desk, help desk software, WooCommerce, order tracking app, tracking updated app, order status app, PayPal, widget, widgets
Requires at least: 3.5.0
Tested up to: 4.3
License: GPLv3
License URI:http://www.gnu.org/licenses/gpl-3.0.html

Easily post status updates, collect payments, import from WooCommerce and send email notifications to customers when the order status changes.

== Description ==

<a href='http://www.etoilewebdesign.com/order-tracking-demo/'>Order Tracking Demo</a>

This order tracking software allows you to manage order quickly and easily by posting updates about the status of orders or tickets that can be viewed through the front-end of your WordPress site. It’s software that's easy to use through the WordPress admin panel and completely customizable with CSS. Orders can be inputted and updated manually, or entered by uploading a spreadsheet. Accept payment for orders through PayPal, or turn on WooCommerce integration to automatically create orders whenever someone checks out! Options are available to decide what information is displayed, to style the tracking form, to import and export orders via spreadsheet,to send out status update emails and more!

Simply insert the ‘tracking-form’ shortcode into any page, and the tracking form will be displayed. It's the simplest order tracking system around!

= Key Features =

* Update the status of orders
* Setup searchable orders or ticket numbers for customers
* Automatically send an email to a customer whenever an order is created or updated
* Create custom statuses tailored to your business 
* Hide or delete orders
* Display options in Settings
* Responsive and customizable CSS 
* Custom emails that can associated with different order statuses
* Options for AJAX results, results in a new window, setting time zone, date formating and much more!

= Premium Features =

* PayPal integration to allow order payment
* WooCommerce integration
* Dozens of styling and labeling options
* Require login for WordPress or Front-End Only users before viewing an order's status
* Custom fields for orders, customers and sales reps to display information such as weight, estimated delivery, price etc.
* Import and export orders to Excel
* Assign orders to customers and sales reps
* Let sales reps manage only their orders

= Shortcodes =

* [tracking-form]
* [customer-form]
* [sales-rep-form]
* [customer-order] (Premium)

Click here to find out more and to purchase the premium version:
<http://www.etoilewebdesign.com/order-tracking/>

= Additional Languages =

* Italian (thanks to MD Ariful)
* German (thanks to Benko)
* Norwegian (thanks to EinarSkaug)
* Spanish (Thanks to Pablo M.)


Check out our Frequently Asked Questions here: 
<https://wordpress.org/plugins/order-tracking/faq/>

Please head to the "Support" forum to report issues or make suggestions:
<https://wordpress.org/support/plugin/order-tracking>

For more OTP videos check out the FAQ page!
[youtube https://www.youtube.com/watch?v=rMULYuPjVXU]




== Installation ==

1. Upload the `order-tracking` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use the newly created admin menu to input and update orders, or create new order statuses
4. Put a tracking form on the front-end of your site with the "[tracking-form]" shortcode
5. You can add the following attributes to the shortcode: order_form_title, order_field_text, submit_text

--------------------------------------------------------------



== Frequently Asked Questions ==

= Is there a Premium version available? =

Yes, it was released early November 2014. Premium features include custom fields, the ability to import and export orders to Excel, the ability to assign orders to customers and sales reps, and the ability to automatically send an email to a customer whenever an order is created or updated. For more information go to:

 <http://www.etoilewebdesign.com/order-tracking/>

= How do I add the tracking form to the front-end? = 

You can add an order form by putting the following shortcode on whatever page you’d like your tracking form to be: [tracking-form].
= What attributes does the [tracking-form] shortcode accept? =

You can specify the label for the field and the value of the submit button with the attributes ‘order_field_text’ and ‘submit_text’ respectively.
= How do I customize the tracking form? = 
 
There is a text area where you can add Custom CSS to customize the form in “Settings” under “Options”.

= How do I access an uploaded excel file? =  
To access the upload directory, it's: (yourdomainhere.com)/wp-content/plugins/order-tracking/order-sheets/
= Can I modify the date and hour? =

Yes, under “Options” you can set the Timezone for your orders.

= What are the columns for the spreadsheet and is it possible to add more information? =

There's no way to display additional information about an order other than by using the "Public Notes" at the moment.The columns that can be uploaded currently are:

Number, Name, Status, Display, Public Notes, Private Notes, Email.

= Is it possible to delete data of an incorrect order completely? =
If you click the checkbox beside the incorrect order and select "Delete" that should get rid of the order.
= Is it possible to change the position of the status to show only the most recent? =
It's not currently possible to load only the most recent status, but we’re keeping this in mind as a future feature.
= How do I translate the plugin into my language? =
A great place to start learning about how to translate a plugin is at the link below: <http://premium.wpmudev.org/blog/how-to-translate-a-wordpress-plugin>

Once translated, you'll need to put the translated mo- and po- files directly in the lang folder and make sure they are named properly for your localization.
If you do translate the plugin, other users would love to have access to the files in your language. You can send them to us at Contact@EtoileWebDesign.com, and we’ll be sure they’re included in a future release.
= How do I change the title of “Order Form Instructions”? =
You can edit “Order Form Instructions” on the “Options” page. They can also be set as an attribute, instructions set as an attribute will take priority.
= How do I change the label “Order Number”  field to, for example, “Job Number” in the front end display? =
To change the label, try adding these attributes into your shortcode:
[tracking-form order_field_text='Job Number' field_names='Order Number=>Job Number']

= Is there a way to modify multiple field labels? = 

You can change multiple names by separating them with a comma. 

= My order graph is not displaying properly, all of the statuses are overlapping. How do I fix this? =

Make sure that you set the column “Percentages” on the order statuses page. If the problem persists you can also try editing the spacing using CSS on the “Options” page in the “Custom CSS” box.

For a more in depth list, please visit our FAQ page:
<http://www.etoilewebdesign.com/order-tracking-faq/>

For more questions and support you can post in the support forum:
<https://wordpress.org/plugins/order-tracking/>

= Videos =

Tutorial Part 1
[youtube https://www.youtube.com/watch?v=YySDJa69HAE]

Tutorial Part 2
[youtube  https://www.youtube.com/watch?v=IdfsGa0You0]

Premium Features
[youtube https://www.youtube.com/watch?v=GVsrJT1O0X0] 

== Screenshots ==

1. Admin area
2. Sample order tracking page


== Screenshots ==

1. Sample order tracking start page
2. Sample order information with graphic and note
3. Customer form with results and email confirmation required
4. Customer order form to allow customers to create orders
5. The admin order creation area
6. The payment options for payments through PayPal
7. The styling options to control fonts, colors, and spacing
8. The labeling options for the different text areas
9. The 'Round' tracking graphic
10. The 'Streamlined' tracking graphic

== Changelog ==
= 2.6.3 =
- Small fixes for the display graphic, customer and sales rep tracking forms

= 2.6.2 =
- Fixed a bug preventing CSS customizations

= 2.6.1 =
- Fixed bugs on the Dashboard and Orders tabs
- Fixed a bug with the customer note button for AJAX orders
- Fixed a bug with the customer form

= 2.6.0 =
- Added PayPal integration, so orders can be paid for via PayPal
- Added a "picture" custom field type, so that an image of the product being shipped can be included
- Fixed a number of small errors

= 2.5.5 =
- Fixed an AJAX bug which was preventing the tracking form from submitting

= 2.5.4 =
- Improved the sizing of the tracking graphic on page load

= 2.5.3 =
- Put the correct statuses back in the 'Bulk Actions' select box

= 2.5.2 =
- Fixed an error where new statuses wouldn't display

= 2.5.1 =
- Fixed an error where the last three tabs weren't displayed if another plugin wasn't installed

= 2.5.0 =
- Complete overhaul of the e-mails system for order updates. IMPORTANT - If you're using the plugin in production, the plugin is switching from native SMTP e-mailing to using the pluggable wp_mail function, which means that options can now be set using a third party plugin (ex: https://wordpress.org/plugins/wp-mail-smtp/)
- Associate messages with an order status, so that each status has a different email message sent out when an order is set to that status
- Assign a WordPress or Front-End Only User (https://wordpress.org/plugins/front-end-only-users/) to a customer so that orders assigned to that customer are automatically displayed by the [customer-form] shortcode when they're logged in

= 2.4.9 =
- Fixed the tracking graphix for email links

= 2.4.8 =
- Updated labeling options
- Updated "Dashboard" tab

= 2.4.7 =
- Shortcode variables can now be used in the email subject line

= 2.4.6 =
- Minor CSS update

= 2.4.5 =
- Minor CSS fix

= 2.4.4 =
- Added "Customer ID" as one of the possible fields that can be added to an email

= 2.4.3 =
- Minor functionality fix

= 2.4.2 =
- Fixed the styling functions, since a number of the settings weren't being included
- Minor changes to customers and sales reps details pages

= 2.4.1 =
- Fixed styling customization for customer, sales rep, and customer order forms
- Minor CSS fixes

= 2.4.0 =
- Extended custom field functionality to sales reps and customers
- Changed the way statuses are displayed on the order graphic
- Minor CSS fixes

= 2.3.6 =
- Increased security for spreadsheets being uploaded

= 2.3.5 =
- Made the [customer-form] shortcode compatible with the latest plugin features
- Added "Sales Rep ID" as a column that could be imported

= 2.3.4 =
- Fixed an HTML error on the "Options" tab that was causing the page to cut off.

= 2.3.3 =
- Minor styling update, with small PHP updates

= 2.3.2 =
- Updated the mailing files, to improve the compatibility of the plugin. If mailing is working for you and important, not upgrading might be advisable.
- Added a Spanish translation

= 2.3.1 =
- Fixed a problem with WooCommerce integration

= 2.3.0 =
- Completely changed the options page
- Added labelling options in a simpler to use format
- Added styling options
- Added the ability to display all orders in a list that can be clicked on, by setting the "show_orders" attribute to "Yes" in the tracking-form shortcode

= 2.2.11 =
- Fixed a potential WooCommerce integration warning

= 2.2.10 =
- Fixed a small display bug

= 2.2.9 =
- Fixed an image display bug in Firefox

= 2.2.8 =
- Fixed a potential emailing subject and send from issue

= 2.2.7 =
- Updated the dashboard tab with support information

= 2.2.6 =
- Fixed a potential spreadsheet issue for those using it to update orders

= 2.2.5 =
- Fixed a small CSS overflow problem

= 2.2.4 =
- Fixed a possible options bug and email settings bug
- Fixed a tracking graphic display bug

= 2.2.3 =
- CSS update that moves the plugin away from using Yahoo's Pure CSS (WARNING: if you're using your own custom CSS with this plugin, the selectors in the shortcodes are being changed)
- Added new premium arrow options, improved the responsiveness of the mobile stylesheet
- Fixed a bug that prevented statuses with quotes from being deleted

= 2.2.2 =
- Added a premium shortcode, customer-order, that allows customers to create orders 

= 2.2.1 =
- Fixed a bug where adding a status would overwrite the old ones
- Fixed a bug where adding a location would overwrite the old ones

= 2.2.0 =
- Added a tracking form widget
- Added "Locations" premium tab
- Fixed a number of update/error messages
- Stopped statuses from being displayed twice when an order is edited and the status doesn't change

= 2.1.4 =
- Added the ability to include "Show in Admin Table" in spreadsheet uploads

= 2.1.3 =
- Added in a premium mobile stylesheet option
- Added another premium tracking graphic option

= 2.1.2 =
- Added in a premium option to change the tracking graphic

= 2.1.1 =
- Commented out the debugging lines in the Main.php file

= 2.1 = 
- Added the ability to automatically import WooCommerce orders
- Added the ability to assign a WordPress user to a sales rep, so that the sales rep can only track their orders
- Fixed an access role bug

= 2.0.24 =
- Fixed a potential problem with Customer email validation

= 2.0.23 =
- Added "Customer Notes" feature, to get information from visitors about an order
- Added the ability to add more than 1 e-mail address for an order

= 2.0.22 =
- Added additional e-mail settings

= 2.0.21 =
- Fixed a small upload error

= 2.0.20 =
- Added the ability to put links in order notes
- Added the ability to set which user role has access to the plugin
- Changed the export column names, so that they match the upload columns

= 2.0.19 =
- Fixed an error with adding tracking numbers to URL

= 2.0.18 =
- Fixed an error with spreadsheet uploading of custom fields

= 2.0.17 =
- Fixed an error with custom fields editing 

= 2.0.16 =
- Fixed an include call that was failing on a number of server setups

= 2.0.15 =
- Added the ability to include a tracking link in order e-mails

= 2.0.14 =
- Changed how tracking graphics are created, so that they will be compatible with more sites
- Tracking pages can now be linked to with an order pre-loaded, by added an argument to the the URL
- Fixed an ajax error

= 2.0.13 =
- Fixed an encryption/display bug

= 2.0.12 =
- Fixed an e-mailing bug with mass status changes

= 2.0.11 =
- Fixed a number of errors with the "file" custom field type

= 2.0.10 =
- Made it possible to align the text towards the bottom of the top information divs

= 2.0.9 =
- Removed two alerts which were left in from debugging

= 2.0.8 =
- Fixed an error with AJAX updating of the order information
- Fixed an error with displaying custom fields

= 2.0.7 =
- Fixed an error with custom fields
- Fixed an error with field re-labelling
- Fixed an error with custom field labelling

= 2.0.6 = 
- Fixed a number of warnings that would appear when fields were re-labelled 

= 2.0.5 =
- Added a new customer orders shortcode
- Added a new sales rep orders shortcode
- Added an option to set the subject for order e-mails
- Added an option to change the date format for fields
- Included additional fields that can be included in the body of e-mails

= 2.0.4 =
- Included a missing file for the custom fields feature

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

