<?php

//Installation of plugin
function aal_install() {
	global $wpdb; 
	$table_name = $wpdb->prefix . "automated_links";
	
	delete_option('aal_target'); add_option( 'aal_target', '_blank');
	delete_option('aal_notimes'); add_option( 'aal_notimes', '3');
	delete_option('aal_showhome'); add_option( 'aal_showhome', 'true');
	$displayc[] = 'post';
	$displayc[] = 'page';
	$dc = json_encode($displayc); 
	delete_option('aal_displayc'); add_option( 'aal_displayc', $dc);
	
	

	//if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  link text NOT NULL,
	  keywords text,
	  meta text,
	  medium varchar(255),
	  grup int(5),
	  grup_desc varchar(255),
	  PRIMARY KEY (id)
	  ) CHARACTER SET utf8 COLLATE utf8_general_ci;";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        $wpdb->last_error;
       // die();
	
}


function aal_admin_notice() {  
	
	$aal_notice_dismissed = get_option('aal_option_dismissed19'); 
	if(!$aal_notice_dismissed && !get_option('aal_apikey') )
	{ 
    ?>
    <div id="aal_notice_div" class="updated">
     <div style="float: right;padding-top: 10px;"><a href="javascript:;" onclick="return aalDismiss();" >Dismiss this notice</a></div>
      <p><?php  // _e( 'Amazon, Clickbank and Shareasale, Ebay, Walmart, Commission Junction, Bestbuy and Envato Marketplace  links can be automatically added into your content , you only have to <a href="http://autoaffiliatelinks.com/wp-login.php?action=register">get your API key</a>, add your affiliate ID and start earning. ', 'wp-auto-affiliate-links' ); 
      
 _e( 'Thank you for using Wp Auto Affiliate Links. To take advantage of all the plugin features, you need to go to our website and  <a href="http://autoaffiliatelinks.com/wp-login.php?action=register">get your API key</a>.', 'wp-auto-affiliate-links' );      

      
      ?></p>
     
    </div>  
    
    
    <?php
    
	}
	
}


function aalDismissNotice() {
	
	
		delete_option('aal_option_dismissed15');
		delete_option('aal_option_dismissed16');
		delete_option('aal_option_dismissed17');
		delete_option('aal_option_dismissed18');
		add_option('aal_option_dismissed19',true);
	
	
}


add_action( 'admin_notices', 'aal_admin_notice' );
add_action('wp_ajax_aal_dismiss_notice', 'aalDismissNotice');






?>