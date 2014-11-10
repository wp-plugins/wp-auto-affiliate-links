<?php


$aalBestbuy = new aalModule('bestbuy','Best Buy Links',8);
$aalModules[] = $aalBestbuy;

$aalBestbuy->aalModuleHook('content','aalBestbuyDisplay');
//$aalEbay->aalModuleHook('actions','aalBestbuyActions');


add_action( 'admin_init', 'aal_bestbuy_register_settings' );


function aal_bestbuy_register_settings() { 
   register_setting( 'aal_bestbuy_settings', 'aal_bestbuyactive' );
   register_setting( 'aal_bestbuy_settings', 'aal_bestbuyid' );
}

function aalBestbuyDisplay() {
	
?>


<script type="text/javascript">




function aal_bestbuy_validate() {
	
		if(!document.aal_bestbuyform.aal_bestbuyid.value) { alert("Please add your Best Buy campaign ID"); return false; }
		
		return true;
				
	}



	
</script>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Best Buy Links</h2>
                <br /><br />
Enter your Linkshare affiliate ID for BestBuy merchant and activate the module
<br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_bestbuyform" onsubmit="return aal_bestbuy_validate();"> 
<?php
		settings_fields( 'aal_bestbuy_settings' );
		do_settings_sections('aal_bestbuy_settings_display');
		
?>

			<span class="aal_label">Affiliate ID:</span> <input type="text" name="aal_bestbuyid" value="<?php echo get_option('aal_bestbuyid'); ?>" /><br />
				<span class="aal_label">Status: </span><select name="aal_bestbuyactive">
			<option value="0" <?php if(get_option('aal_bestbuyactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_bestbuyactive')=='1') echo "selected"; ?> >Active</option>
		</select>



<?php
	submit_button('Save');
	echo '</form></div>';
	
	if(get_option('aal_bestbuyactive') ) {
		
	
?>


<?php

	}
	
	
	
	
	echo '</div>';

}





?>