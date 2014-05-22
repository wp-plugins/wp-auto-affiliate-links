<?php


	
	
	
add_action( 'admin_init', 'aal_api_register_settings' );


function aal_api_register_settings() { 
   register_setting( 'aal_api_settings', 'aal_apikey' );
}	
	


function wpaal_apimanagement() {
	global $wpdb;
	
	if($_POST['aal_apirequest']) {
		
		$apiname = $_POST['aal_apiname'];
		$apiemail = $_POST['aal_apiemail'];	
		
		$getcontent = 'apiname='. $apiname .'&apiemail='. $apiemail;	
		$returned = aal_post($getcontent,'http://autoaffiliatelinks.com/api/apirequest.php');
		$returned = json_decode($returned);
		
		//print_r($returned);
		if($returned->apikey) {
			
				delete_option('aal_apikey');
				add_option('aal_apikey', $returned->apikey);
			
			}
		else {
			
			$errormsg = "There was an error obtaining your API key. Please try again or contact support";
			
		}
		
	}
	
	
$apikey = get_option('aal_apikey');
	
	
?>

<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        
                 <h2>Api Key Management</h2>
                <br /><br />
                <b>Revenue sharing. </b> If you activate PRO features and then you set-up Amazon and Clickbank links, along with your automatically generated links there will be one link with our affiliate code from amazon or clickbank. This will ensure the continued development of the plugin and if the outcome is good it will keep the PRO features of the plugin FREE. If you do not want this just disable Amazon and Clickbank links, or contact us and maybe we can work something out. 
                <br /><br />
                <?php echo $errormsg; ?>
                <br />
                <?php if($apikey) {
                		//echo 'Your API key: '. $apikey .' seems to be valid.';
                	}
                	else { ?>
                <h3>Request an API key:</h3>
                To get you API key you have to subscribe to use our services. Use the following button to create your subscription. 
                <br/><br />
                <div ><a href="http://4.lucapostol.pay.ClickBank.net" target="_self"><img class="alignnone size-medium wp-image-110" title="download-now" alt="" src="http://autoaffiliatelinks.com/wp-content/uploads/2012/10/download-now-300x116.gif" width="180" /></a></div>
                
                
                <?php } ?>
                <br /><br />
    <form method="post" action="options.php" >

<?php
		settings_fields( 'aal_api_settings' );
		do_settings_sections('aal_api_settings_display');
		
?>    
    
    
	Enter your API key here: <input type="text" name="aal_apikey" value="<?php echo get_option('aal_apikey'); ?>" />
	<?php submit_button('Save'); ?>	
	
	</form>
	
	
	</div>
	
	
<?php
	
	
}










?>