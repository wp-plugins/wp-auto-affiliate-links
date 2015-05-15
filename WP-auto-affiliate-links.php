<?php
/*
Plugin Name: Auto Affiliate Links
Plugin URI: http://autoaffiliatelinks.com
Description: Auto add affiliate links to your blog content
Author: Lucian Apostol
Version: 4.9.8.6
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
include(plugin_dir_path(__FILE__) . 'aal_generatedlinks.php');
include(plugin_dir_path(__FILE__) . 'aal_metabox.php');
include(plugin_dir_path(__FILE__) . 'aal_getstarted.php');

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


register_activation_hook(__FILE__,'aal_install');

//add_action('wp_ajax_exclude_posts', 'aalExcludePosts');




// Add Wp Auto Affiliate Links to Wordpress Admnistration panel menu
function wpaal_create_menu() {

	add_menu_page( 'Auto Affiliate Links', 'Auto Affiliate Links', 'publish_pages', 'aal_topmenu', 'wpaal_manage_affiliates', $icon_url, $position );	
	add_submenu_page( 'aal_topmenu', 'Getting Started', 'Getting Started', 'publish_pages', 'aal_gettingstarted', 'wpaal_gettingstarted' );
	add_submenu_page( 'aal_topmenu', 'General Settings', 'General Settings', 'publish_pages', 'aal_general_settings', 'wpaal_general_settings' );
	//add_submenu_page( 'aal_topmenu', 'Modules', 'Modules', 'publish_pages', 'aal_modules', 'wpaal_modules' );
	add_submenu_page( 'aal_topmenu', 'Upgrade to PRO', 'Upgrade to PRO', 'publish_pages', 'aal_apimanagement', 'wpaal_apimanagement' );
	if(get_option('aal_apikey'))  add_submenu_page( 'aal_topmenu', 'Generated Links', 'Generated Links', 'publish_pages', 'aal_generatedlinks', 'wpaal_generatedlinks' );
	
global $aalModules;
		if(get_option('aal_apikey')) foreach($aalModules as $aalMod) {
			
			if(get_option('aal_'. $aalMod->shortname .'active')) add_submenu_page( 'aal_topmenu', $aalMod->nicename, $aalMod->nicename, 'publish_pages', 'aal_module_'. $aalMod->shortname, $aalMod->hooks['content'] );			
			
		}


	add_submenu_page( 'aal_topmenu', 'Exclude Posts/Pages', 'Exclude Posts/Pages', 'publish_pages', 'aal_exclude_posts', 'wpaal_exclude_posts' );
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
	
	
	if($_POST['aal_massactionscheck']) {
	
			$massids = $_POST['aal_massstring'];
			//echo $massids; die();
			
			$wpdb->query("DELETE FROM ". $table_name ." WHERE id IN (". $massids .");");	
	
	
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
	
	if($_POST['aal_excluderulesaction']) {		
	
		$date = $_POST['aal_excluderulesdatebefore'];
		//echo $date;
		delete_option('aal_excluderulesdatebefore');
		add_option('aal_excluderulesdatebefore', $date);
	
	}
	
	
	
	if($_POST['aal_export_settings_check']) {		
	

	$pluginDefinedOptions = array('aal_iscloacked', 'aal_showhome', 'aal_notimes', 'aal_notimescustom', 'aal_exclude', 'aal_target', 'aal_relation', 'aal_cssclass', 'aal_langsupport', 'aal_display', 'aal_displayc', 'aal_samekeyword', 'aal_apikey', 'aal_amazonactive', 'aal_clickbankactive', 'aal_shareasaleactive', 'aal_cjactive', 'aal_ebayactive', 'aal_bestbuyactive', 'aal_walmartactive', 'aal_amazonid', 'aal_amazoncat', 'aal_shareasaleid', 'aal_clickbankid', 'aal_clickbankcat', 'aal_clickbankgravity', 'aal_clickbankactive', 'aal_amazonlocal', 'aal_ebayid', 'aal_bestbuyid', 'aal_walmartid', 'aal_envatoactive', 'aal_envatosite', 'aal_envatoid' ); // etc

	// Clear up our settings
	foreach($pluginDefinedOptions as $optionName) {
    	if(get_option($optionName)) {
    		$optionsToExport[$optionName] = get_option($optionName);
    	}
	}		
	
		

		
		$File = 'aal_exported_settings.txt';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header('Content-type: text/plain');
header("Connection: close");
		
echo json_encode($optionsToExport);
		
		die();
		
		wp_redirect("admin.php?page=aal_topmenu");	
	}
	
	
		global $aalModules;
		foreach($aalModules as $aalMod) {
			
		
			if(function_exists($aalMod->hooks['actions'])) call_user_func($aalMod->hooks['actions']);		
			
		}
		
		
		
		
		if($_POST['aal_exclude_post_byurl_check'] && $_POST['aal_exclude_post_url']) {
			
			
			$url = esc_url($_POST['aal_exclude_post_url']);
			$postid = url_to_postid( $url );
			
			if($postid) {
				
				$aal_exclude_id = $postid;
			
			 $aal_posts = get_option('aal_exclude');
			    $post = get_post($aal_exclude_id);
                $data['post_title'] = $post->post_title;
                if(!$post->ID) {
                die('nopost');
					}
					
					$aal_posts_array = explode(',',$aal_posts);
					if(in_array($post->ID,$aal_posts_array)) {
						die('duplicate');					
					}
               
                
                if($aal_posts=='')$aal_exclude=$aal_exclude_id;
                    else $aal_exclude=$aal_posts.",".$aal_exclude_id;
                    
                 
                delete_option('aal_exclude'); add_option( 'aal_exclude', $aal_exclude);
			 
		}
			
			
			
		}	
	
	

}  // wpaal_actions end


//Function that will render the administration page
function wpaal_manage_affiliates() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";

	//Load the keywords and options
	$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
	//Load excluded posts	
	$excludeposts = get_option('aal_exclude');
        
	$apikey = get_option('aal_apikey');	
	
	//Render the page
    ?>
	<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        <h2>Auto Affiliate Links</h2>
		<br /><br />
        <div id="aal_panel3">
       

			Thank you for using Auto Affiliate Links. The plugin will display affiliate links to your visitors based on your chosen keywords. Add affiliate links that you want to be displayed, and the keywords or keyphrases where you want them to be displayed into your content. 
			<br /><br />
                                
			<h3>Add affiliate links and keywords to be displayed:</h3>

            <form name="add-link" method="post" action="<?php echo admin_url( "admin-ajax.php");?>" id="aal_add_new_link_form">
                <input type="hidden" name="action" value="add_link" />
                Affiliate link: <input class="aal_biginput" type="text" name="link" value="http://" id="aal_formlink" />
                Keywords: <input class="aal_biginput" type="text" name="aal_keywords" id="aal_formkeywords" />
                <input type="submit" class="button-primary" name="Save" value="Save" />&nbsp;&nbsp;&nbsp; <?php aalGetSugestions($myrows);?>
            </form>
                    
			<div>
			
			<br />
			
			
	
				
				
	<?php
	
	
		
	if($apikey) {
		
		$valid = file_get_contents('http://autoaffiliatelinks.com/api/apivalidate.php?apikey='. $apikey );
		$valid = json_decode($valid);
		
	
	
	 if($valid->status == 'expired' && $apikey) { 
	
	echo 'Your subscription to Wp Auto Affiliate Links PRO is expired. Please <a href="https://safecart.com/autoaffiliate/.aalmonth?apikey='. $apikey .'">renew your subscription</a> or <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">create a new API key</a> <br /><br />';
	
	
	}  
	
	if($valid->status == 'invalid' && $apikey) { 
	
	echo 'The API key you entered is invalid. You have to <a href="http://autoaffiliatelinks.com/wp-login.php?action=register">register on our website</a> to get a valid API key. <br /><br />';
	
	
		}
	
	
	
	}	
	
	else {
	
		echo 'If you want links to be extracted and displayed automatically from Amazon, Clickbank, Shareasale, Ebay, Walmart, Commision Junction and Envato Marketplace you should consider activating PRO features. <a href="http://autoaffiliatelinks.com/wp-login.php?action=register">Get your API key.</a>';	
	
	
	}
	
	  ?>				
				
			<br /><br />	
				
				
			</div>   
                                    
                    
                    <h3>Affiliate Links:</h3>
                    <form name="aal_linksorderform" method="get">
                    <br />
                    Order list by: 
                    
                    <a href="?page=aal_topmenu&aalorder=id" >Date</a> | 
                    <a href="?page=aal_topmenu&aalorder=keywords">Name</a>
							<input type="hidden" name="aal_linksorderinput" value="" />
							</form>
                    <ul class="aal_links">

                         <?php AalLink::showAll(); // Showing existent affiliate links with edit and delete options ?>


                    </ul>
                    
                    
                   <form name="aal_linksorderform" method="get">
                    <br />
                    Order list by: 
                    
                    <a href="?page=aal_topmenu&aalorder=id" >Date</a> | 
                    <a href="?page=aal_topmenu&aalorder=keywords">Name</a>
							<input type="hidden" name="aal_linksorderinput" value="" />
							</form>                    
                    
                    
                    <br /><br />
                    
                    <form name="aal_massactions" method="post" onsubmit="return aal_masscomplete(); " >
                    	<input class="button-primary" type="submit" name="aal_selectall" id="aal_selectall" value="Select all" onclick="return false"/>
							
							
							<input type="hidden" name="aal_massactionscheck" value="1" />
							<input type="hidden" name="aal_massstring" value="" id="aal_massstring" />
							<input type="submit"  class="button-primary"  value="Delete selected" onclick="" />
							</form>                    
                    
<p>If you have problems or questions about the plugin, or if you just want to send a suggestion or request to our team, you can use the <a href="http://wordpress.org/support/plugin/wp-auto-affiliate-links">support forum</a>. Make sure that you consult our <a href="http://wordpress.org/plugins/wp-auto-affiliate-links/faq/">FAQ</a> first. </p>                    
                    
                    
                    
                    
                    </div>
    </div>



 <?php  }  // manage_affliate links


?>