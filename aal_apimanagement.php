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
                <?php echo $errormsg; ?>
                <br />
                <?php if($apikey) {
                		echo 'Your API key: '. $apikey .' seems to be valid.';
                	}
                	else { ?>
                <h3>Request an API key:</h3>
                <form method="post">
                Name: <input type="text" name="aal_apiname" /><br />
                Email: <input type="text" name="aal_apiemail" /><br />
                <input type="hidden" name="aal_apirequest" value="1" />
                <input type="submit" value="Save" />
                </form> 
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