<?php
/*
Plugin Name: Add Logo to Admin
Plugin URI: http://bavotasan.com/tidbits/add-your-logo-to-the-wordpress-admin-and-login-page/
Description: Adds a custom logo to your site's Admin header and your login page.
Author: c.bavota
Version: 1.0.2
Author URI: http://bavotasan.com
*/

function add_logo_to_admin() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/add-logo-to-admin/css/wp-admin.css" />'."\n";
    echo '<script type="text/javascript" src="'  . get_settings('siteurl') . '/wp-content/plugins/add-logo-to-admin/js/admin.js"></script>'."\n";
}

add_action('admin_head', 'add_logo_to_admin');

function wp_admin_login_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_settings('siteurl') . '/wp-content/plugins/add-logo-to-admin/css/login.css" />'."\n";
    echo '<script type="text/javascript" src="'  . get_settings('siteurl') . '/wp-content/plugins/add-logo-to-admin/js/login.js"></script>'."\n";
}

add_action('login_head', 'wp_admin_login_css');

?>