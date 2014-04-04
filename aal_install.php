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
	  PRIMARY KEY (id)
	  );";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        $wpdb->last_error;
       // die();
	
}


function aal_admin_notice() {
	
	$aal_notice_dismissed = get_option('aal_option_dismissed3'); 
	if(!$aal_notice_dismissed)
	{
    ?>
    <div id="aal_notice_div" class="updated">
        <p align="center"><?php _e( 'Thank you for using Wp Auto Affiliate Links. We are pleased to announce that there is a premium brand new feature in the plugin: Automated clickbank links. Links from clickbank will be automatically generated based on your content. You will need to <a href="'. admin_url() .'admin.php?page=aal_apimanagement">request an api key</a> and then <a href="'. admin_url() .'admin.php?page=clickbank">set-up clickbank</a>. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="return aalDismiss();" >Dismiss this notice</a>', 'wp-auto-affiliate-links' ); ?></p>
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
	
		delete_option('aal_option_dismissed3');
		add_option('aal_option_dismissed3',true);
	
	
}


add_action( 'admin_notices', 'aal_admin_notice' );
add_action('wp_ajax_aal_dismiss_notice', 'aalDismissNotice');






?>