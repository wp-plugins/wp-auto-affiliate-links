<?php

//Installation of plugin
function aal_install() {
	global $wpdb; 
	$table_name = $wpdb->prefix . "automated_links";
	

	//if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  link text NOT NULL,
	  keywords text,
	  meta text,
	  medium varchar(255),
	  grup int(5),
	  grup_desc varchar(255),
	  UNIQUE KEY id (id)
	);";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
	
}


function aal_admin_notice() {
	
	$aal_notice_dismissed = get_option('aal_option_dismissed'); 
	if(!$aal_notice_dismissed)
	{
    ?>
    <div id="aal_notice_div" class="updated">
        <p align="center"><?php _e( '<a href="http://autoaffiliatelinks.com/our-products/wp-auto-affiliate-links-pro/">Wo Auto Affiliate Links PRO 2.0</a> has been released. Affiliate Links can be automatically extracted from Amazon, Clickbank, Shareasale, commission junction and to be automatically displayed in your content. Check it out <a href="http://autoaffiliatelinks.com/our-products/wp-auto-affiliate-links-pro/"> here</a>. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="return aalDismiss();" >Dismiss this notice</a>', 'wp-auto-affiliate-links' ); ?></p>
    </div>
    
<script type="text/javascript">
	function aalDismiss() {


        var data = {action: 'aal_dismiss_notice'};
        
            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){
                    jQuery("#aal_notice_div").slideUp('slow', function() {jQuery("#aal_notice_div").remove();});
                                        }
                });
        	
		
		
	}

</script>    
    
    
    <?php
	}
	
}


function aalDismissNotice() {

		add_option('aal_option_dismissed',true);
	
	
}


add_action( 'admin_notices', 'aal_admin_notice' );
add_action('wp_ajax_aal_dismiss_notice', 'aalDismissNotice');




// Installation

register_activation_hook(__FILE__,'aal_install');

?>