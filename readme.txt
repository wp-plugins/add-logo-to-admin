=== Add Logo to Admin ===
Contributors: c.bavota
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=1929921
Tags: custom logo, admin, login
Requires at least: 2.7
Tested up to: 2.7
Stable tag: 1.0.2

Add a custom logo to your admin header and to your login page.

== Description ==

Add a custom logo to your admin header and to your login page.

This plugin allows a user to customize their admin panel by adding their own logo to the header. It also replaces the WordPress logo on the login screen with the same custom logo.

== Installation ==

1. Unzip the add-logo-to-admin.zip file.
2. Create your own logo and name it logo.png. Add it to add-logo-to-admin/images folder.
3. Upload the `add-logo-to-admin` folder to the `/wp-content/plugins/` directory.
4. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions == 

1) How do I add my own logo?

Create your own logo and name it logo.png. Add it to add-logo-to-admin/images folder.

2) How big does my logo need to be?

You can make it any width or height.

3) Can my logo by a jpg file?

Yes it can. But you would need to edit two lines in two files of the plugin to make it work.

Open file js/login.js and change line 8 to

var imgSrc = "../wp-content/plugins/add-logo-to-admin/images/logo.jpg";

Open file js/admin.js and change line 8 to 

var imgSrc = "../wp-content/plugins/add-logo-to-admin/images/logo.jpg";

NOTE: You can also change it to logo.gif or whichever file format you prefer. I chose .png to take advantage of the high quality transparency it offers.

== Screenshots ==

1. Admin before and after
2. Login page before and after

== Change Log ==

1.0.2 (2008-12-16)
Fixed weirdness with extra folder

1.0.1 (2008-12-16)
Fixed the code to direct to the proper plugin folder

1.0 (2008-12-15)
Initial Public Release
