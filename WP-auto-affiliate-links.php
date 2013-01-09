<?php
/*
Plugin Name: WP Auto Affiliate Links
Plugin URI: http://autoaffiliatelinks.com
Description: Auto add affiliate links to your blog content
Author: Lucian Apostol
Version: 2.9.5
Author URI: http://autoaffiliatelinks.com
*/

require "functions.php";

add_action('admin_init', 'wpaal_actions');
add_action('admin_menu', 'wpaal_create_menu');
add_filter('the_content', 'wpaal_add_affiliate_links');
add_action('init', 'wpaal_rewrite_rules');
add_action('wp', 'wpaal_add_query_var');
add_action('wp','wpaal_check_for_goto');
add_action('wp_print_scripts', 'aal_load_css');
add_action('wp_print_scripts', 'aal_load_js');
add_action('wp_ajax_aal_delete_link', 'aalDeleteLink');
add_action('wp_ajax_aal_add_link', 'aalAddLink');
add_action('wp_ajax_aal_change_options', 'aalChangeOptions');
add_action('wp_ajax_aal_add_exclude_posts', 'aalAddExcludePost');
add_action('wp_ajax_aal_update_exclude_posts', 'aalUpdateExcludePosts');

//add_action('wp_ajax_exclude_posts', 'aalExcludePosts');


// Add Wp Auto Affiliate Links to Wordpress Admnistration panel menu
function wpaal_create_menu() {
	add_options_page(__('Wp Auto Affiliate Links', 'automated_affiliate_links'), __('Wp Auto Affiliate Links', 'automated_affiliate_links')	, 10, basename(__FILE__), 'wpaal_manage_affiliates' );
}

function wpaal_actions() {
    
        global $wpdb;
        $table_name = $wpdb->prefix . "automated_links";
                

	//Check if a keyword was edited
	if($_POST['aal_edit']=='ok') {
			
		//Security and input check
		check_admin_referer('WP-auto-affiliate-links_edit_link');		
		$id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['id'];
		$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
		$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];

		//Update the database and redirect
		$rows_affected = $wpdb->update( $table_name, array( 'link' => $link, 'keywords' => $keywords ), array( 'id' => $id ));
		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");

			
	}
	
	

}  // wpaal_actions end


//Function that will render the administration page
function wpaal_manage_affiliates() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";


	//Load the keywords and options
	$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
        
        $iscloacked = get_option('aal_iscloacked');
	if($iscloacked=='true') $isc = 'checked'; else $isc = '';
        
	$showhome = get_option('aal_showhome');
        if($showhome=='true') $shse = 'checked'; else $shsel = '';
        
	$notimes = get_option('aal_notimes');
        
	$targeto = get_option('aal_target');
	if($targeto=="_blank") $tsc1 = 'checked'; else $tsc2 = 'checked';
	
        
        $relationo = get_option('aal_relation');
	if($relationo=="nofollow") $rsc1 = 'checked'; else $rsc2 = 'checked';
	
        
        $excludeposts = get_option('aal_exclude');
        
	
	//Render the page
        ?>
        <h1>Manage Affiliate Links</h1>
	<br /><br />
	<span style="color: red;">The PRO version of this plugin was released. <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Wp Auto Affiliate Links PRO</a> automatically get links from Amazon, Clickbank, shareasale, or you can insert manually. Based on the content of the target links, the plugin will automatically add affiliate links trough the content. <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Find out more</a>.</span>
	<br /><br />
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="RGNWD2T23VX2J">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	<br /><br />
        
        	
        <ul class="tabs">
                <li><a href="" title="General Settings" onclick="document.location.hash = '#generalsettings;'">General Settings</a></li>
                <li><a href="" title="Exclude posts" onclick="document.location.hash = '#excludeposts';" >Exclude posts</a></li>
                <li><a href="" title="Add Affiliate Links" onclick="document.location.hash = '#addlinks';" >Add Affiliate Links</a></li>
                
        </ul>

        <!-- tab "panes" -->
        <div class="panes">
            <div>
                <h3>General Options</h3>
                
                <form name="aal_settings" id="changeOptions" method="post">
                    <b>Cloack links:</b> <input type="checkbox" name="aal_iscloacked" id="aal_iscloacked"  <?php echo $isc;?> /> (Disable this if the cloacked links are not working for you)<br /><br />
                    
                    <b>Add links on homepage:</b> <input type="checkbox" name="showhome" id="showhome" <?php echo $shse;?> /> <br /><br />
                    
                    <b>Target:</b> <input type="radio" name="aal_target" value="_blank" <?php echo $tsc1;?> /> New window <input type="radio" name="aal_target" value="_self" <?php echo $tsc2 ;?>/> Same Window <br /><br />
                    
                    <b>How many times every keyword should appear on a post ( max ):</b> <input type="text" name="notimes" id="notimes" value="<?php echo $notimes ;?>" size="1" /><br /><br />
                    
                    <b>Relation:</b> <input type="radio" name="aal_relation" value="nofollow" <?php echo $rsc1;?> /> Nofollow <input type="radio" name="aal_relation" value="dofollow" <?php echo $rsc2 ;?>/> Dofollow <br /><br /><br />
                    <input type="submit" value="Save" />
                </form>
                <span class="aal_add_link_status"> </span>
            </div>
            
            <div>
               
                <h3>Exclude posts</h3>
                <form name="aal_add_exclude_posts_form" id="aal_add_exclude_posts_form" method="post">
                    <b>Enter post ID </b>:
                    <input type="text" name="aal_exclude_post_id" id="aal_add_exclude_post_id"  size="10" />
                    <input type="submit" value="Exclude Post"/>
                </form>
                
                <p>Excluded Posts ID's</p>
                <form class="aal_exclude_posts">
                <?php 
                $aal_exclude_posts=get_option('aal_exclude');
                $aal_exclude_posts_array=explode(',', $aal_exclude_posts);
                
                foreach ($aal_exclude_posts_array as $aal_exclude_post_id)
                    echo "<span>
                            Post ID: <input type='text' name='aal_exclude_posts' class='all_exclude_post_item' value='".$aal_exclude_post_id."'/> 
                            <a href='javascript:' id='".$aal_exclude_post_id."' class='aal_delete_exclude_link'><img src='".plugin_dir_url(__FILE__)."images/delete.png'/></a><br/>
                          </span>";
                
               
                
                ?>
                </form>
                
                <span class="aal_exclude_status"> </span>
            </div>
            
            <div>
                    <p>After you add the affiliate links, make sure you write keywords in the respective field, separated by comma. If you don\'t enter any keyword, that link won\'t be displayed.</p>
                    <p>After you hit save, all keywords entered found in the content will be replaced with the links to the affiliate page</p>


                    <form name="add-link" method="post" action="<?php echo admin_url( "admin-ajax.php");?>" id="aal_add_new_link_form">
                        <input type="hidden" name="action" value="add_link" />
                        Affiliate link: <input type="text" name="link" value="http://" id="formlink" />
                        Keywords: <input type="text" name="keywords" id="formkeywords" />
                        <input type="submit" name="Save" />
                    </form>
                    
                    <br/>Here is a list with most used keywords in all your blog. Click on each and it will be added in the form above so you can assign a link for it.<br />
                                <?php aalGetSugestions();?>
                    
                    <h3>Affiliate Links:</h3>

                    <ul class="links">

                         <?php aalGetLinks($myrows); // Showing existent affiliate links with edit and delete options ?>


                    </ul>
            </div>
            
     </div>
        


 <?php  }  // manage_affliates end

// The function that will actually add links when the post content is rendered
function wpaal_add_affiliate_links($content) {
		global $wpdb;
		
		//Getting the keywords and options
		$showhome = get_option('aal_showhome');
		$notimes = get_option('aal_notimes'); if(!$notimes) $notimes = -1;
		$aal_exclude = get_option('aal_exclude');
		$iscloacked = get_option('aal_iscloacked');
		//$iscloacked = 0;
		
		$targeto = get_option('aal_target');
		$relationo = get_option('aal_relation');
		$excludearray = explode(',',$aal_exclude);
		$table_name = $wpdb->prefix . "automated_links";
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
		
		if($relationo=='nofollow') $relo = ' rel="nofollow" ';
		else $relo = '';

		$patterns = array();

		//If no keywords are set, exit the function
		if(is_null($myrows)) return $content;
		
		else foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
 						if($key) if(!in_array('/'. $key .'/', $patterns)) { 

							//regular expression setup
							$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	
							$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
							$strpos_fnc		=	 'stripos';
								
								
							if($iscloacked=='true') $link = get_option( 'home' ) . "/goto/" . wpaal_generateSlug($key);
							$url = $link;
							$name = $key;
							
							
							$replace[] = "<a title=\"$1\" class=\"aal\" target=\"". $targeto ."\" ". $relo ." href=\"$url\">$1</a>";
							$regexp[] = str_replace('$name', $name, $reg);	


						}
					}
				}
		}

		global $post;

		//Check if the post is set for exclusion and do nothing
		if(in_array($post->ID, $excludearray)) { }
		else {
			//Check to see if it is the homepage
			if(is_array($regexp)) { if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index.php') $ishome = 1; else $ishome=0;
			
			if(!$ishome) $content = preg_replace($regexp, $replace, $content,$notimes);	
				else if($showhome=='true') if($regexp[0]) $content = preg_replace($regexp, $replace, $content,$notimes);	 }
		}				
		return $content;


}  // add_affiliate_links end

// Contribution of Jos Steenbergen
// Rewrite engine for links

function wpaal_check_for_goto() { 
       global $wpdb;
       global $wp_query;
	
       if(isset($wp_query->query_vars['goto'])) { 
       //echo $wp_query->query_vars['goto'];
       //echo 'having goto';
	  // die();


       $table_name = $wpdb->prefix . "automated_links";
               $myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );

                               $patterns = array();

               if(is_null($myrows)) return;
               else foreach($myrows as $row) {

                               $link = $row->link;
                               //$link = get_option( 'home' ) . "/goto/" . wpaal_generateSlug($row->keywords);
                               $keywords = $row->keywords;

                               if(!is_null($keywords)) {
                                       $keys = explode(',',$keywords);

                                       foreach($keys as $key) {

                                               $key = trim($key);

                                               if(!in_array($key, $patterns)) {

                                                       //Added 3 times to cover first letter capped, and all uppercase
                                                       $patterns[] = wpaal_generateSlug($key);
                                                       $redirect_link[] = $link;
                                               }
                                       }
                               }

               }
               if (in_array($wp_query->query_vars['goto'], $patterns)) {
                       // link exist so find the corresponding key
                       //echo "Founded link: " . $redirect_link[array_search($wp_query->query_vars['goto'], $patterns)] . "/r/n";
                       wp_redirect( $redirect_link[array_search($wp_query->query_vars['goto'], $patterns)], 301 );
                       exit;
               }

               }
       //print_r($array = $GLOBALS['wp_query']->query_vars);
}

function wpaal_rewrite_rules() {
		add_rewrite_tag('%goto%','([^&]+)');
                add_rewrite_rule( 'goto/?([^/]*)', 'index.php?goto=$matches[1]', 'top');
       }
function wpaal_add_query_var($vars)  {  //print_r($vars); die();
        global $wp_query;

	set_query_var('goto',$wp_query->query_vars['attachment']);
       
       return $vars;
       }

function wpaal_generateSlug($phrase)
{
       $maxLength = 45;
       $result = strtolower($phrase);

       $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
       $result = trim(preg_replace("/[\s-]+/", " ", $result));
       $result = trim(substr($result, 0, $maxLength));
       $result = preg_replace("/\s/", "-", $result);

       return $result;
}

// Installation

register_activation_hook(__FILE__,'aal_install');

