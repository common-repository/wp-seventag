=== WP-Seventag ===
Contributors: ClearcodeHQ, PiotrPress, i.m.szukala
Tags: 7tag, Seventag, tag manager, analytics, clearcode
Requires at least: 4.3.1
Tested up to: 4.6.1
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

7tag is a free, open-source tag manager that lets you effortlessly create, deploy, and manage your tags across your websites.

== Description ==

This plugin integrates your WordPress site with 7tag, allowing you to add the 7tag container code to your website with just a few clicks via your WordPress Dashboard.

7tag - The easy-to-use tag manager for the busy marketer.

7tag is an open-source tag manager that’s free to download, use, and customize. 

Download the latest version of [7tag](https://7tag.org/download/ "Download 7tag") now from [7tag.org](https://7tag.org/ "7tag")!

Please note: You will need to have downloaded 7tag, installed on your server, and created a container before you can use the WP-Seventag pluin.

= 7 Reasons to Choose 7tag =

1. **Easy-to-use & Intuitive Interface**
Save time and effortlessly add, change, and remove tags with the user-friendly 7tag interface. It’s incredibly easy to use for both non-technical and technical staff.

2. **No Data Limits**
Manage an unlimited number of containers, tags, and conditions, and process an unlimited volume of traffic.

3. **Gain Full Control Of The Software**
Host your 7tag tag management system on your own infrastructure and gain full control of the software. As 7tag is open source, you can review the code, modify it, & extend its functionalities.

4. **High-security Standards**
7tag was built using high-security standards to keep all your data and information safe. You can also enforce extra security by limiting access to the server.

5. **Free, Open-Source & Customizable**
Save your marketing dollars and download & use 7tag for FREE. As it’s open source, you can customize it to suit your needs and incorporate it into your own product.

6. **Works With All Tags On All Browsers**
Fire all types of JavaScript and pixel tags on all modern and legacy browsers to ensure your get all the information and data you need.

7. **Premium services for your 7tag**
Achieve more with your marketing campaigns! Our team can help you configure, optimize, and customize your 7tag tool to help you achieve your specific marketing goals and objectives.

= 7 Main Ways 7tag Can Help You =

1. **Manage All Your Tags in One Place**
Save time by managing all your tags in one place. You can add, change, and remove any tag across all websites with just a few clicks.

2. **Collect Certain Information with Triggers**
Save time by managing all your tags in one place. You can add, change, and remove any tag across all websites with just a few clicks.

3. **Specify When a Trigger is Fired with Conditions**
Limit firing tags based on user-defined rules to the specific URL paths, DOM elements or individual forms.

4. **Test & Debug Your Tags Before They Go Live**
Avoid having to play catch up and fix broken tags in the live environment by previewing your tags and removing bugs before they are deployed.

5. **Control User Access & Permissions**
Create numerous user accounts and set granular permissions for viewing, editing, and publishing tags.

6. **Fast Loading with CDN Hosting**
Your tags will always load instantly thanks to 7tag’s integration with all the popular Content Delivery Networks (CDN).

7. **API available**
Keep all your marketing tools in one place by adding 7tag to your marketing stack with the 7tag API.

== Installation ==

= From your WordPress Dashboard =

1. Go to 'Plugins > Add New'
2. Search for 'WP-Seventag'
3. Activate the plugin from the Plugin section in your WordPress Dashboard.

= From WordPress.org =

1. Download 'WP-Seventag'.
2. Upload the 'wp-seventag' directory to your '/wp-content/plugins/' directory using your favorite method (ftp, sftp, scp, etc...)
3. Activate the plugin from the Plugin section in your WordPress Dashboard.

= Once Activated =

Visit 'Settings > 7tag', add your server's URL in the 'Server URL' field, fill in the 'Container ID' field, and then decide where you would like to place the 7tag snippet. 

**Please note**

* wp_head is the preferred location for firing synchronous tags (e.g. for A/B testing).
* wp_body_open is the preferred location for firing asynchronous tags.

To learn more about which type of tags you should use (e.g. asynchronous or synchronous tags), read the [Tags](https://7tag.org/docs/tags/ "7tag Tags Documentation") section in the 7tag's documentation.

= Multisite =

The plugin can be activated and used for just about any use case.

* Activate at the site level to load the plugin on that site only.
* Activate at the network level for full integration with all sites in your network (this is the most common type of multisite installation).

== Frequently Asked Questions ==

= How do I use the wp_body_open function? =

Paste the following code directly after the opening `<body>` tag in your theme:
`<?php if ( function_exists( 'wp_body_open' ) ) : wp_body_open(); ?>`

= What's the difference between placing the 7tag snippet in the wp_head or the wp_body_open locations? =

* wp_head is the preferred location for firing synchronous tags (e.g. for A/B testing).
* wp_body_open is the preferred location for firing asynchronous tags.

To learn more about which type of tags you should use (e.g. asynchronous or synchronous tags), read the [Tags](https://7tag.org/docs/tags/ "7tag Tags Documentation") section in the 7tag's documentation.

= What are minimum requirements for the plugin? =

PHP interpreter version >= 5.3

== Screenshots ==

1. **WordPress General Settings** - Visit 'Settings > 7tag', add your server's URL in the 'Server URL' field, fill in the 'Container ID' field, and then decide where you would like to place the 7tag snippet (wp_head is the preferred location for firing synchronous tags – e.g. for A/B testing and wp_head_open is the preferred location for firing asynchronous tags).
2. **7tag Containers Settings** - Visit '7tag > Containers' and take note of the  Container ID you want to implement into your site. Then, write that container ID in the 'Container ID' field in your WordPress Dashboard.

== Changelog ==

= 1.4.1 =
*Release date: 09.09.2016*

* Added support for get_sites function introduced in WordPress 4.6 version.
* Added .htaccess file for increase plugin's security.
* Added for all php files, including templates, check condition for ABSPATH constant defined.

= 1.4.0 =
*Release date: 17.05.2016*

* Added synchronous snippets inclusion via output buffering.
* Expanded info on the 7tag Settings page about the synchronous and asynchronous methods of the 7tag inclusion snippets.
* Update script.js file handling checkbox behavior on settings page.
* Remove '-template' suffix from template file names.
* Replaced screenshots-1.png with a new one.
* Updated the Polish wp-seventag-pl_PL.po/.mo translation files.

= 1.3.0 =
*Release date: 12.05.2016*

* Added asynchronous snippets inclusion via output buffering.
* Added methods wrappers for handling options functions.
* Added script.js file handling checkbox behavior on settings page.
* Correct link to plugins settings page.
* Replaced screenshots-1.png with a new one.
* Updated the Polish wp-seventag-pl_PL.po/.mo translation files.

= 1.2.0 =
*Release date: 11.05.2016*

* Update synchronous and add asynchronous snippets.
* Enable synchronous and/or asynchronous snippets loading.
* Added info on the 7tag Settings page about the synchronous and asynchronous locations of the 7tag snippets.
* Replaced screenshots-1.png with a new one.
* Updated the Polish wp-seventag-pl_PL.po/.mo translation files.

= 1.1.0 =
*Release date: 21.04.2016*

* Moved settings to a separate 7tag sub page under the Settings section.
* Added info on the 7tag Settings page about the preferred location of the 7tag snippet.
* Added instructions on the 7tag Settings page about placing the 7tag snippet into the HTML `<body>` element.
* Added info about PHP interpreter's minimum requirements version and other small fixes in readme.txt file.
* Replaced screenshots-1.png with a new one.
* Updated the Polish wp-seventag-pl_PL.po/.mo translation files.
* Renamed a file from COPYING.txt to LICENSE.txt according to WordPress Detailed Plugin Guidelines.
* Removed the repository and support for GitHub and changed the Plugin URI tag in the plugin's header.

= 1.0.0 =
*Release date: 02.11.2015*

* First stable version of the plugin.

