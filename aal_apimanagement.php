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
        
                 <h2>Auto Affiliate Links PRO features</h2>
                 
                 <br /><br />           
                 
              	 To use PRO features of Wp Auto Affiliate Links you have to go to our website and get  <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">your own API Key</a>. 
              		<br /><br /><br />
              	What you get by activating PRO features:
              	<br />
              	<ul class=aal_admin_list>
						<li>Links will be added <b>automatically</b> based on your content 
						<li><b>Amazon</b> Links are automatically extracted and inserted in content
						<li><b>ClickBank</b> Links are automatically extracted and inserted
						<li><b>Shareasale</b> links can be uploaded and displayed into your content              	
              	</ul>
              	<br /><br /><br />

                <?php if($apikey) {
                		
                	}
                	else { ?>                   	
              	
              	
              	<h3>Request an API key:</h3><br /><br />
              	You can get more info and request your API key on our website: <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Auto Affiliate Links</a>
                <br /><br />
                <?php echo $errormsg; ?>
                <br />

                <?php } ?>
                <br /><br />
    <form method="post" action="options.php" >

<?php
		settings_fields( 'aal_api_settings' );
		do_settings_sections('aal_api_settings_display');
		
?>    

	<?php
	
		$valid = file_get_contents('http://autoaffiliatelinks.com/api/apivalidate.php?apikey='. $apikey );
		$valid = json_decode($valid);
		
	
	
	?>
    
    
	Enter your API key here: <input type="text" name="aal_apikey" value="<?php echo get_option('aal_apikey'); ?>" />
	<br /><?php if($apikey) { ?>Your API key is <?php echo $valid->status; ?> <?php } ?> 
	<?php submit_button('Save'); ?>	
	
	<?php if($valid->status == 'expired' ) { 
	
	echo 'If you requested your API key for free then it is no longer usable. You have to go to <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">our website</a> and get a new one by subscribing for PRO version <br /><br />';
	
	
	}  ?>
	
	</form>
	<br /><br />

	.
	
	
	</div>
	
	
<?php
	
	
}










?>