<?php
/*
Plugin Name: WP Auto Affiliate Links
Plugin URI: http://autoaffiliatelinks.com
Description: Auto add affiliate links to your blog content
Author: Lucian Apostol
Version: 4.1.2
Author URI: http://autoaffiliatelinks.com
*/

//Load css stylesheets
function aal_load_css() {
	
        //load css styles
        wp_register_style( 'aal_style', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style('aal_style');


}

//load javascript files
function aal_load_js() {
	
		
		
	
        // load our jquery file that sends the $.post request1
		wp_enqueue_script( "js", plugin_dir_url( __FILE__ ) . 'js/js.js', array( 'jquery' ) );
        $aal_plugin_url=plugin_dir_url(__FILE__);
        // make the ajaxurl var available to the above script
		wp_localize_script( 'js', 'ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php'),'aal_plugin_url' =>$aal_plugin_url  ) );	     
}

function aal_load_front_scripts() {
	
	if(get_option('aal_apikey')) { 
		wp_register_script( 'aal_apijs', plugin_dir_url( __FILE__ ) . 'js/api.js', array( 'jquery' ) );
		wp_enqueue_script( 'aal_apijs');
	}
	
}


//Get list of link showed on Add Affiliate Links tab



include(plugin_dir_path(__FILE__) . 'aal_install.php');
include(plugin_dir_path(__FILE__) . 'aal_cloaking.php');
include(plugin_dir_path(__FILE__) . 'aal_functions.php');
include(plugin_dir_path(__FILE__) . 'aal_ajax.php');
include(plugin_dir_path(__FILE__) . 'aal_engine.php');
include(plugin_dir_path(__FILE__) . 'aal_settings.php');
include(plugin_dir_path(__FILE__) . 'aal_exclude.php');
include(plugin_dir_path(__FILE__) . 'aal_modules.php');
include(plugin_dir_path(__FILE__) . 'aal_importexport.php');
include(plugin_dir_path(__FILE__) . 'aal_apimanagement.php');

include(plugin_dir_path(__FILE__) . 'classes/link.php');


add_action('admin_init', 'wpaal_actions');
add_action('admin_menu', 'wpaal_create_menu');
add_filter('the_content', 'wpaal_add_affiliate_links',5);
add_action('init', 'wpaal_rewrite_rules');
add_action('query_vars', 'wpaal_add_query_var');
add_action('wp','wpaal_check_for_goto');
add_action('wp_print_scripts', 'aal_load_css');
add_action('wp_print_scripts', 'aal_load_js');
add_action('wp_ajax_aal_delete_link', 'aalDeleteLink');
add_action('wp_ajax_aal_add_link', 'aalAddLink');
add_action('wp_ajax_aal_change_options', 'aalChangeOptions');
add_action('wp_ajax_aal_add_exclude_posts', 'aalAddExcludePost');
add_action('wp_ajax_aal_update_exclude_posts', 'aalUpdateExcludePosts');
add_action('wp_enqueue_scripts', 'aal_load_front_scripts');

// Installation

register_activation_hook(__FILE__,'aal_install');

//add_action('wp_ajax_exclude_posts', 'aalExcludePosts');




// Add Wp Auto Affiliate Links to Wordpress Admnistration panel menu
function wpaal_create_menu() {

	add_menu_page( 'Auto Affiliate Links', 'Wp Auto Affiliate Links', 'publish_pages', 'aal_topmenu', 'wpaal_manage_affiliates', $icon_url, $position );	
	add_submenu_page( 'aal_topmenu', 'General Settings', 'General Settings', 'publish_pages', 'aal_general_settings', 'wpaal_general_settings' );
	//add_submenu_page( 'aal_topmenu', 'Modules', 'Modules', 'publish_pages', 'aal_modules', 'wpaal_modules' );
	add_submenu_page( 'aal_topmenu', 'Activate PRO features', 'Activate PRO features', 'publish_pages', 'aal_apimanagement', 'wpaal_apimanagement' );

global $aalModules;
		if(get_option('aal_apikey')) foreach($aalModules as $aalMod) {
			
		add_submenu_page( 'aal_topmenu', $aalMod->nicename, $aalMod->nicename, 'publish_pages', $aalMod->shortname, $aalMod->hooks['content'] );			
			
		}


	add_submenu_page( 'aal_topmenu', 'Exclude Posts', 'Exclude Posts', 'publish_pages', 'aal_exclude_posts', 'wpaal_exclude_posts' );
	add_submenu_page( 'aal_topmenu', 'Import/Export', 'Import/Export', 'publish_pages', 'aal_import_export', 'wpaal_import_export' );

}

function wpaal_actions() {
    
        global $wpdb;
        $table_name = $wpdb->prefix . "automated_links";
                

	//Check if a keyword was edited
	if($_POST['aal_edit']=='ok') {
			
		//Security and input check
		check_admin_referer('WP-auto-affiliate-links_edit_link');		
		$id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['id'];
		$link = filter_input(INPUT_POST, 'aal_link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
		$keywords = filter_input(INPUT_POST, 'aal_keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];

		//Update the database and redirect
		$rows_affected = $wpdb->update( $table_name, array( 'link' => $link, 'keywords' => $keywords ), array( 'id' => $id ));
		wp_redirect("admin.php?page=aal_topmenu");

			
	}
	
	

	
	
	
	if($_POST['aal_export_check']) {				
		
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
		$separator = $_POST['aal_export_separator'];
		if($separator=='tab') $separator = "\t";
		if(!$separator) $separator = "|";
		//$separator = "|";
		
		$File = 'aal_export.txt';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header('Content-type: text/plain');
header("Connection: close");
		
foreach($myrows as $row) {

	echo $row->keywords . $separator . $row->link . "\n";

}
		
		die();
		
		wp_redirect("admin.php?page=aal_topmenu");	
	}
	
	
		global $aalModules;
		foreach($aalModules as $aalMod) {
			
		
			if(function_exists($aalMod->hooks['actions'])) call_user_func($aalMod->hooks['actions']);		
			
		}	
	
	

}  // wpaal_actions end




	



//Function that will render the administration page
function wpaal_manage_affiliates() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";


	//Load the keywords and options
	$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
	
        
        $excludeposts = get_option('aal_exclude');
        
	
	//Render the page
        ?>
<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        <h2>Wp Auto Affiliate Links PRO</h2>
	<br /><br />
        

<div class="updated"><br />To activate PRO features, go to <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">our website</a> to get your API key. The PRO features include automated generation and insertion of Amazon and Clickbank links <br /><br /></div>


            
            <div id="aal_panel3">
            			<p><b>Here you can add auto affiliate links manually. If you want links to be added automatically from Amazon, Clickbank and Shareasale use the "Activate PRO features" in the plugin menu ( on the left ), then go to each affiliate network menu and set your credentials. </b></p>
                    <p>After you add the affiliate links, make sure you write keywords in the respective field, separated by comma. If you don\'t enter any keyword, that link won\'t be displayed.</p>
                    <p>After you hit save, all keywords entered found in the content will be replaced with the links to the affiliate page</p>


                    <form name="add-link" method="post" action="<?php echo admin_url( "admin-ajax.php");?>" id="aal_add_new_link_form">
                        <input type="hidden" name="action" value="add_link" />
                        Affiliate link: <input type="text" name="link" value="http://" id="aal_formlink" />
                        Keywords: <input type="text" name="aal_keywords" id="aal_formkeywords" />
                        <input type="submit" name="Save" value="Save" />
                    </form>
                    
                    <br/>Here is a list with most used keywords in all your blog. Click on each and it will be added in the form above so you can assign a link for it.<br />
                                <?php aalGetSugestions($myrows);?>
                    
                    <h3>Affiliate Links:</h3>

                    <ul class="aal_links">

                         <?php AalLink::showAll(); // Showing existent affiliate links with edit and delete options ?>


                    </ul>
                    
                    </div>
    </div>



 <?php  }  // manage_affliates end





?>