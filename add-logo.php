<?php
/*
Plugin Name: Add Logo to Admin
Plugin URI: http://bavotasan.com/tidbits/add-your-logo-to-the-wordpress-admin-and-login-page/
Description: Adds a custom logo to your site's Admin header and your login page.
Author: c.bavota
Version: 1.3.2
Author URI: http://bavotasan.com
*/

//Initialization
add_action('admin_menu', 'add_logo_init');


//add page to admin 
function add_logo_init() {
if(stristr($_SERVER['REQUEST_URI'],'?page=add-logo-to-admin/add-logo.php')) {
	if(stristr($_SERVER['REQUEST_URI'],'&delete-logo')) {
		$directory = dirname(__FILE__) . "/images/";
		unlink($directory . $_REQUEST['delete-logo']);
		if($_REQUEST['delete-logo'] == get_option('add_logo_filename')) {
			update_option('add_logo_filename', ""); 
			update_option('add_logo_logo', ""); 
		}
		
		$location = str_replace("&delete-logo=". $_REQUEST['delete-logo'], "", $_SERVER['REQUEST_URI']."&deleted=true");
		header("Location: $location");
		die;		
	}
	if($_REQUEST['submit']) {
		
		if ($_FILES["file"]["type"]){
			$directory = dirname(__FILE__) . "/images/";
			$image = str_replace(" ", "-", $_FILES["file"]["name"]);
			move_uploaded_file($_FILES["file"]["tmp_name"],
			$directory . $image);
			update_option('add_logo_logo', get_option('siteurl'). "/wp-content/plugins/add-logo-to-admin/images/". $image);
			update_option('add_logo_filename', $image); 
		}
		
		if($_REQUEST['add_logo_on_login']) {
			update_option('add_logo_on_login',$_REQUEST['add_logo_on_login']);
		}
		
		if($_REQUEST['add_logo_on_admin']) {
			update_option('add_logo_on_admin',$_REQUEST['add_logo_on_admin']);
		}	
	
		if($_REQUEST['add_logo_filename']) {
			update_option('add_logo_filename',$_REQUEST['add_logo_filename']);
			update_option('add_logo_logo', get_option('siteurl'). "/wp-content/plugins/add-logo-to-admin/images/". $_REQUEST['add_logo_filename']);
		}	
		
		if(stristr($_SERVER['REQUEST_URI'],'&saved=true')) {
			$location = $_SERVER['REQUEST_URI'];
			} else {
			$location = str_replace("&deleted=true", "", $_SERVER['REQUEST_URI']."&saved=true");		
		}
		header("Location: $location");
		die;
	}
	
}	
  add_options_page('Add Logo to Admin', 'Add Logo to Admin', 10, __FILE__, 'my_plugin_options');
}

function addConfigureLink( $links ) { 
  $settings_link = '<a href="options-general.php?page=add-logo-to-admin/add-logo.php">Settings</a>'; 
  array_unshift( $links, $settings_link ); 
  return $links; 
}
 
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'addConfigureLink' );

//set default options
function set_add_logo_options() {	
	add_option('add_logo_on_login','yes','Do you want the logo to appear on the login page?');
	add_option('add_logo_on_admin','yes','Do you want the logo to appear on the admin pages?');	
	add_option('add_logo_logo',get_option("siteurl").'/wp-content/plugins/add-logo-to-admin/images/logo.png','Logo location');	
	add_option('add_logo_filename', 'logo.png','Logo filename');	
}

//delete options upon plugin deactivation
function unset_add_logo_options() {
	delete_option('add_logo_on_login');
	delete_option('add_logo_on_admin');
	delete_option('add_logo_logo');
	delete_option('add_logo_filename');
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
		));
	}
}

//add logo to login if "yes" is selected
if(get_option('add_logo_on_login') == "yes") {
	add_action('login_head', 'wp_admin_login_css');
	function wp_admin_login_css() {
		echo '<link rel="stylesheet" type="text/css" href="' . get_option('siteurl') . '/wp-content/plugins/add-logo-to-admin/css/login.css" />'."\n";
		echo '<script type="text/javascript">' . "\n" . '/* <![CDATA[ */' . "\n" . '	newLogo = {' . "\n" . '	logo: "' . get_option('add_logo_logo') . '",' . "\n" . '	}' . "\n" . '/* ]]> */' . "\n" . '</script>' . "\n";
    echo '<script type="text/javascript" src="'  . get_option('siteurl') . '/wp-content/plugins/add-logo-to-admin/js/login.js"></script>'."\n";
	}
}

//creating the admin page
function my_plugin_options() {
?>
  <div class="wrap">
  <h2>Add Logo to Admin</h2>
  
  <?php
	if ( $_REQUEST['saved'] ) { echo '<div id="message" class="updated fade"><p><strong>Add Logo to Admin settings saved.</strong></p></div>'; }
	if ( $_REQUEST['deleted'] ) { echo '<div id="message" class="updated fade"><p><strong>Logo deleted.</strong></p></div>'; }
	print_add_logo_form();
	?>
 </div>
<?php
}

//updating the options
function update_add_logo_options() {

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
	<form method="post" id="myForm" enctype="multipart/form-data">
    <table class="form-table">
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="add_logo_on_login">Would you like your logo to appear on the login page?</label>
	</th>
    <td>
    	<input type="radio" name="add_logo_on_login" value="yes" <?=$login_yes?> />&nbsp;Yes&nbsp;&nbsp;
    	<input type="radio" name="add_logo_on_login" value="no" <?=$login_no?> />&nbsp;No
    </td>
     </tr>   
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="add_logo_on_admin">Would you like your logo to appear on the admin pages?</label>
    </th>
    <td>
    	<input type="radio" name="add_logo_on_admin" value="yes" <?=$admin_yes?> />&nbsp;Yes&nbsp;&nbsp;
    	<input type="radio" name="add_logo_on_admin" value="no" <?=$admin_no?> />&nbsp;No
    </td>
    </tr>
    <tr valign="top">
	<th scope="row" style="width: 370px;">
    	<label for="add_logo_logo">Choose a file to upload: </label>
    </th>
    <td>
		<input type="file" name="file" id="file" />&nbsp;<em><small>Click Save Changes below to upload your logo.</small></em>
		<?php
            update_option('add_logo_logo', get_option('siteurl'). "/wp-content/plugins/add-logo-to-admin/images/". get_option('add_logo_filename'));
            $path = dirname(__FILE__) . "/images/";
            $directory = get_option('siteurl'). "/wp-content/plugins/add-logo-to-admin/images/";
            // Open the folder 
            $dir_handle = @opendir($path) or die("Unable to open $path"); 
            // Loop through the files 
            $count = 1;
            while ($file = readdir($dir_handle)) { 
            
                if($file == "." || $file == ".." || $file == "index.php" ) {
                    continue; 
                    }
                if($count==1) { echo "<br /><br />Select which logo you would like to use.<br />"; $count++; }
                if($file == get_option('add_logo_filename')) { $checked = "checked"; } else { $checked = ""; }
                echo "<br /><table><tr><td style=\"padding-right: 5px;\"><img src=\"$directory$file\" style=\"max-height:100px;border:1px solid #aaa;padding:10px;\" /></td><td><input id=\"add_logo_filename\" name=\"add_logo_filename\" type=\"radio\" value=\"$file\" $checked />&nbsp;Select<br /><br /><a href=\"options-general.php?page=add-logo-to-admin/add-logo.php&delete-logo=$file\">&laquo; Delete</a></td></tr></table>"; 
            } 
            
            // Close 
            closedir($dir_handle); 
         ?>    </td>
    </tr>
    </table>   
	<p class="submit">
	<input type="submit" name="submit" class="button-primary" value="Save Changes" />
	</p>
    </form>
    <!-- Add Logo to Admin admin box end-->
<?php 
}
?>
