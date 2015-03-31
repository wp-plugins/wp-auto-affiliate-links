<?php
//error_reporting(0);

	
	
	
add_action( 'admin_init', 'aal_api_register_settings' );


function aal_api_register_settings() { 
   register_setting( 'aal_api_settings', 'aal_apikey' );
   register_setting( 'aal_api_settings', 'aal_amazonactive' );
   register_setting( 'aal_api_settings', 'aal_clickbankactive' );
   register_setting( 'aal_api_settings', 'aal_shareasaleactive' );
   register_setting( 'aal_api_settings', 'aal_cjactive' );
   register_setting( 'aal_api_settings', 'aal_ebayactive' );
   register_setting( 'aal_api_settings', 'aal_bestbuyactive' );
   register_setting( 'aal_api_settings', 'aal_walmartactive' );
   register_setting( 'aal_api_settings', 'aal_envatoactive' );
}	
	


function wpaal_apimanagement() {
	global $wpdb;
	
	
	//Old code for requesting api key
	/*
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
		
	} */
	
	
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
						<li><b>Ebay</b> auctions can be automatically linked based on your content
						<li><b>Walmart</b> links can be automatically extracted and displayed
						<li><b>Commission Junction</b> product datafeeds can be uploaded and automatically displayed
						<li><b>Shareasale</b> links will be automatically shown          
						<li><b>Envato Marketplace</b> automatic links    	
              	</ul>
              	<br />
					 More info about Auto Affiliate Links PRO features <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">here</a>.        	
              	<br /><br />

                <?php if($apikey) {
                		
                	}
                	else { ?>                   	
              	
              	
              	<h3>Request an API key:</h3><br /><br />
              	 <a href="http://autoaffiliatelinks.com/wp-login.php?action=register">Click here</a> to get your own API key.
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
	<?php submit_button('Save');  ?>	
	
	
	
	<br /><!-- <?php if($apikey) { ?>Your API key is <?php echo $valid->status; ?> <?php } ?> -->
	
	<br />
	
		
	
	<?php if($valid->status == 'expired' && $apikey) { 
	
	echo 'Your subscription to Wp Auto Affiliate Links PRO is expired. Please <a href="https://safecart.com/autoaffiliate/.aalmonth?apikey='. $apikey .'">renew your subscription</a> or <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">create a new API key</a> <br /><br />';
	
	
	} 
	
	 if($valid->status == 'invalid' && $apikey) { 
	
	echo 'The API key you entered is invalid. You have to <a href="http://autoaffiliatelinks.com/wp-login.php?action=register">register on our website</a> to get a valid API key. <br /><br />';
	
	
	}   
	
	
	 if(get_option('aal_apikey') && $valid->status!='expired' && $valid->status!='invalid' ) {  ?>
	
	<br /><br />
	After you activate the modules, you need to set them up from the Wp Auto Affiliate Links menu ( Amazon Links, Clickbank Links, Shareasale Links ).
<br /><br />

	<h3>Manage PRO Modules</h3>
	<table class="widefat fixed" > 
	<thead>
		<th>Module name</th>
		<th>Status</th>
		<th>Actions</th>
		<th></th>
		<th></th>
		<th></th>
	</thead>
	
	
	<tr class="alternate">
		<td>Amazon</td>
		<td><select name="aal_amazonactive">
			<option value="0" <?php if(get_option('aal_amazonactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_amazonactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_amazon'); ?>">Configure Amazon Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td>Clickbank</td>
		<td><select name="aal_clickbankactive">
			<option value="0" <?php if(get_option('aal_clickbankactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_clickbankactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_clickbank'); ?>">Configure Clickbank Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr class="alternate">
		<td>Shareasale</td>
		<td><select name="aal_shareasaleactive">
			<option value="0" <?php if(get_option('aal_shareasaleactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_shareasaleactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_shareasale'); ?>">Configure Shareasale Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>	
	<tr>
		<td>Commission Junction</td>
		<td><select name="aal_cjactive">
			<option value="0" <?php if(get_option('aal_cjactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_cjactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_cj'); ?>">Configure Commission Junction Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>	
	<tr class="alternate">
		<td>Best Buy</td>
		<td><select name="aal_bestbuyactive">
			<option value="0" <?php if(get_option('aal_bestbuyactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_bestbuyactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_bestbuy'); ?>">Configure Best Buy Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>	
	<tr>
		<td>Ebay</td>
		<td><select name="aal_ebayactive">
			<option value="0" <?php if(get_option('aal_ebayactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_ebayactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_ebay'); ?>">Configure Ebay Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>	
	<tr>
		<td>Walmart</td>
		<td><select name="aal_walmartactive">
			<option value="0" <?php if(get_option('aal_walmartactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_walmartactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_walmart'); ?>">Configure Walmart Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>	
	<tr>
		<td>Envato Marketplace</td>
		<td><select name="aal_envatoactive">
			<option value="0" <?php if(get_option('aal_envatoactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_envatoactive')=='1') echo "selected"; ?> >Active</option>
		</select></td>
		<td><a href="<?php echo admin_url('admin.php?page=aal_module_envato'); ?>">Configure Envato Module</a></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	</table>
	
	
	<?php submit_button('Save'); ?>	
	
	<?php } else { ?>
	
	
	<input type="hidden" name="aal_amazonactive" value="<?php echo get_option('aal_amazonactive'); ?>" />
	<input type="hidden" name="aal_clickbankactive" value="<?php echo get_option('aal_clickbankactive'); ?>" />
	<input type="hidden" name="aal_shareasaleactive" value="<?php echo get_option('aal_shareasaleactive'); ?>" />
	<input type="hidden" name="aal_ebayactive" value="<?php echo get_option('aal_sebayactive'); ?>" />
	<input type="hidden" name="aal_cjactive" value="<?php echo get_option('aal_cjactive'); ?>" />
	<input type="hidden" name="aal_bestbuyactive" value="<?php echo get_option('aal_bestbuyactive'); ?>" />
	<input type="hidden" name="aal_walmartactive" value="<?php echo get_option('aal_walmartactive'); ?>" />
	<input type="hidden" name="aal_envatoactive" value="<?php echo get_option('aal_envatoactive'); ?>" />
	
	<?php } ?>
	
	</form>
	</div>
	
	
<?php
	
	
}










?>