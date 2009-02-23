<?php
/*
Plugin Name: Add Logo to Admin
Plugin URI: http://bavotasan.com/tidbits/add-your-logo-to-the-wordpress-admin-and-login-page/
Description: Adds a custom logo to your site's Admin header and your login page.
Author: c.bavota
Version: 1.2
Author URI: http://bavotasan.com
*/

//Initialization
add_action('admin_menu', 'add_logo_init');


//add page to admin 
function add_logo_init() {
	add_options_page('Add Logo to Admin', 'Add Logo to Admin', 10, __FILE__, 'my_plugin_options');
}

//set default options
function set_add_logo_options() {	
	add_option('add_logo_on_login','yes','Do you want the logo to appear on the login page?');
	add_option('add_logo_on_admin','yes','Do you want the logo to appear on the admin pages?');	
	add_option('add_logo_logo','/wp-content/plugins/add-logo-to-admin/images/logo.png','Logo location');	
}

//delete options upon plugin deactivation
function unset_add_logo_options() {
	delete_option('add_logo_on_login');
	delete_option('add_logo_on_admin');
	delete_option('add_logo_logo');
}

register_activation_hook(__FILE__,'set_add_logo_options');
register_deactivation_hook(__FILE__,'unset_add_logo_options');

//add logo to admin if "yes" selected
if(get_option('add_logo_on_admin') == "yes") {
	if (is_admin()) {
	add_action('admin_head', 'wp_admin_admin_css');
	function wp_admin_admin_css() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_option('siteurl') . '/wp-content/plugins/add-logo-to-admin/css/wp-admin.css" />'."\n";
    }
	wp_enqueue_script('add_logo_admin_script', get_option('siteurl') . '/wp-content/plugins/add-logo-to-admin/js/admin.js');
	wp_localize_script( 'add_logo_admin_script', 'newLogo', array(
	  	'logo' => get_option('add_logo_logo'),
	  	'site' => get_option('siteurl')
		));
	}
}

//add logo to login if "yes" is selected
if(get_option('add_logo_on_login') == "yes") {
	add_action('login_head', 'wp_admin_login_css');
	function wp_admin_login_css() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_option('siteurl') . '/wp-content/plugins/add-logo-to-admin/css/login.css" />'."\n";
		echo '<script type="text/javascript">' . "\n" . '/* <![CDATA[ */' . "\n" . '	newLogo = {' . "\n" . '	logo: "' . get_option('add_logo_logo') . '",' . "\n" . '	site: "' . get_option('siteurl') . '"' . "\n" .'	}' . "\n" . '/* ]]> */' . "\n" . '</script>' . "\n";
    echo '<script type="text/javascript" src="'  . get_option('siteurl') . '/wp-content/plugins/add-logo-to-admin/js/login.js"></script>'."\n";
	}
}

//creating the admin page
function my_plugin_options() {
?>
  <div class="wrap">
  <h2>Add Logo to Admin</h2>
  <?php
	if($_REQUEST['submit']) {
	update_add_logo_options();
	}
	print_add_logo_form();
	?>
 </div>
<?php
}

//updating the options
function update_add_logo_options() {
	$ok = false;
	
	if($_REQUEST['add_logo_on_login']) {
		update_option('add_logo_on_login',$_REQUEST['add_logo_on_login']);
		$ok = true;
	}
	
	if($_REQUEST['add_logo_on_admin']) {
		update_option('add_logo_on_admin',$_REQUEST['add_logo_on_admin']);
		$ok = true;
	}
	
	if($_REQUEST['add_logo_logo']) {
		update_option('add_logo_logo',$_REQUEST['add_logo_logo']);
		$ok = true;
	}	
	
	if($ok) {
		echo'<div id="message" class="updated fade">';
		echo '<p>Options saved.</p>';
		echo '</div>';
	} else {
		echo'<div id="message" class="error fade">';
		echo '<p>Failed to save options.</p>';
		echo '</div>';	
	}
}

//the actual admin page
function print_add_logo_form() {
	$default_login = get_option('add_logo_on_login');
	$default_admin = get_option('add_logo_on_admin');
	$the_logo = get_option('add_logo_logo');
	if ($default_login == "yes") { $login_yes = "checked"; } else { $login_no = "checked"; }
	if ($default_admin == "yes") { $admin_yes = "checked"; } else { $admin_no = "checked"; }
	?>
    <!-- Add Logo to Admin box begin-->
	<form method="post">
    <table class="form-table">
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="add_logo_on_login">Would you like your logo to appear on the login page?</label>
	</th>
    <td>
    	<input type="radio" name="add_logo_on_login" value="yes" <?=$login_yes?> />Yes
    	<input type="radio" name="add_logo_on_login" value="no" <?=$login_no?> />No
    </td>
     </tr>   
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="add_logo_on_admin">Would you like your logo to appear on the admin pages?</label>
    </th>
    <td>
    	<input type="radio" name="add_logo_on_admin" value="yes" <?=$admin_yes?> />Yes
    	<input type="radio" name="add_logo_on_admin" value="no" <?=$admin_no?> />No
    </td>
    </tr>
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="add_logo_logo">Where is your logo located? </label>
    </th>
    <td>
    	<?php bloginfo('url'); ?><input type="text" name="add_logo_logo" size="60" value="<?=$the_logo?>" /><br />
    </td>
    </tr>
    </table>   
	<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="Save Changes" />
	</p>
    </form>
    <p><em>NOTE: You need to refresh this page or just navigate to another page if you switch the Admin option from "No" to "Yes" and want to see the option take affect.</em></p>
    <!-- Add Logo to Admin admin box end-->
<?php 
}
?>