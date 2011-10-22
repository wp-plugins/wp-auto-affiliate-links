<?php
/*
Plugin Name: WP Auto Affiliate Links
Plugin URI: http://www.flamescorpion.com/wp-auto-affiliate-links/
Description: Auto add affiliate links to your blog content
Author: Lucian Apostol
Version: 0.1.9.1
Author URI: http://www.lucianapostol.com
*/

add_action('admin_init', 'wpaal_actions');
add_action('admin_menu', 'create_menu');
add_filter('the_content', 'add_affiliate_links');


function wpaal_actions() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";

	if($_GET['aal_action']=='delete') {

		check_admin_referer('WP-auto-affiliate-links_delete_link');

		$id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)); // $_GET['id'];

		$wpdb->query("DELETE FROM ". $table_name ." WHERE id = '". $id ."' LIMIT 1");

		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");


	}


	if($_POST['aal_sent']=='ok') {
			
			check_admin_referer('WP-auto-affiliate-links_add_link');

			
			$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
			$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];


		$rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords ) );

		

		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");

			
	}



	if($_POST['aal_edit']=='ok') {
			
			check_admin_referer('WP-auto-affiliate-links_edit_link');
			
			$id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['id'];
			$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
			$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];


		// $rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords ) );

		$rows_affected = $wpdb->update( $table_name, array( 'link' => $link, 'keywords' => $keywords ), array( 'id' => $id ));

		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");

			
	}




}



function create_menu() {

			add_options_page(__('Manage Affiliate Links', 'automated_affiliate_links'), __('Manage Affiliate Links', 'automated_affiliate_links')	, 10, basename(__FILE__), 'manage_affiliates' );

}


function manage_affiliates() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";



	$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );


	echo '<h1>Manage Affiliate Links</h1>
	<br /><br />
	<span style="color: red;">If you like this plugin, please donate to support the continued development. There are many features that are awaiting on line.</span>
	<br /><br />
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="RGNWD2T23VX2J">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

	<br /><br />
	<p>After you add the affiliate links, make sure you write keywords in the respective field, separated by comma. If you don\'t enter any keyword, that link won\'t be displayed.</p>
	<p>After you hit save, all keywords entered found in the content will be replaced with the links to the affiliate page</p>
	<br /><br />

	<form name="add-link" method="post">';


if ( function_exists('wp_nonce_field') )
	wp_nonce_field('WP-auto-affiliate-links_add_link');

		echo '

		Affiliate link: <input type="text" name="link" value="http://" />
		Keywords: <input type="text" name="keywords" />
		<input type="submit" name="Save" />
		<input type="hidden" name="aal_sent" value="ok" />
	</form>
	<br />
	<br />
	<h3>Affiliate Links:</h3>
	<ul>
		';

		foreach($myrows as $row) {
				
				$id = $row->id;
				$link = $row->link;
				$keywords = $row->keywords;

				$deletelink = '?page=WP-auto-affiliate-links.php&aal_action=delete&id='. $id;
				$deletelink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($deletelink, 'WP-auto-affiliate-links_delete_link') : $deletelink;

			//	echo '<li><b>Link:</b> '. $link .'   &nbsp;&nbsp;<b>Keywords:</b> '. $keywords .'  &nbsp;&nbsp; <a href="'. $deletelink .'">Delete</a></li>';
			?>

				<form name="edit-link-<?php echo $id; ?>" method="post">

				<?php
					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('WP-auto-affiliate-links_edit_link');
				?>
					
					Link: <input type="text" name="link" value="<?php echo $link; ?>" />
					Keywords: <input type="text" name="keywords" value="<?php echo $keywords; ?>" />
					<input type="submit" name="ed" value="Edit" />
					<input value="<?php echo $id; ?>" name="edit_id" type="hidden" />
					<input type="hidden" name="aal_edit" value="ok" />
					<?php echo '<a href="'. $deletelink .'">Delete</a></li>'; ?>
				</form>

				

			<?php
		}

		echo '
	</ul>

	
	';

//	print_r($myrows);
	
}



function add_affiliate_links($content) {
		global $wpdb;
		$table_name = $wpdb->prefix . "automated_links";
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );

				$patterns = array();

		if(is_null($myrows)) return $content;
		else foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
 
						if(!in_array('/'. $key .'/', $patterns)) { 

							$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	
							$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
							$strpos_fnc		=	 'stripos';
								
							//$url = 'http://www.zipr.com';
							$url = $link;
							//$name = 'zip';
							$name = $key;
							
							$replace[] = "<a title=\"$1\" target=\"_blank\" href=\"$url\">$1</a>";
							$regexp[] = str_replace('$name', $name, $reg);	


						}

					}


				}

		}

		// print_r($patterns);




	//	$content = preg_replace($patterns, $replacements, $content);

	//	$content = preg_replace('/<a(.*?)><a(.*?)>(.*?)a>(.*?)a>/', '<a$1>$3a>' ,$content);


		
		
	if($regexp[0]) $content = preg_replace($regexp, $replace, $content);	
		
		
	//	$content = preg_replace('/<(.*?)<a(.*?)>(.*?)<(.*?)a>(.*?)>/', '<$1$3$5>' ,$content);

				

		return $content;


}







// Installation

register_activation_hook(__FILE__,'aal_install');


function aal_install() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {


		$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  link text NOT NULL,
	  keywords text,
	  UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

	}

}
