<?php


$aalEbay = new aalModule('ebay','Ebay Links',7);
$aalModules[] = $aalEbay;

$aalEbay->aalModuleHook('content','aalEbayDisplay');
//$aalEbay->aalModuleHook('actions','aalEbayActions');


add_action( 'admin_init', 'aal_ebay_register_settings' );


function aal_ebay_register_settings() { 
   register_setting( 'aal_ebay_settings', 'aal_ebayactive' );
   register_setting( 'aal_ebay_settings', 'aal_ebayid' );
}

function aalEbayDisplay() {
	
?>


<script type="text/javascript">




function aal_ebay_validate() {
	
		if(!document.aal_ebayform.aal_ebayid.value) { alert("Please add your Ebay campaign ID"); return false; }
		
		return true;
				
	}



	
</script>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Ebay Links</h2>
                <br /><br />
Enter your Ebay campaign ID and activate the module
<br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_ebayform" onsubmit="return aal_ebay_validate();"> 
<?php
		settings_fields( 'aal_ebay_settings' );
		do_settings_sections('aal_ebay_settings_display');
		
?>

			<span class="aal_label">Campaign ID:</span> <input type="text" name="aal_ebayid" value="<?php echo get_option('aal_ebayid'); ?>" /><br />
				<span class="aal_label">Status: </span><select name="aal_ebayactive">
			<option value="0" <?php if(get_option('aal_ebayactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_ebayactive')=='1') echo "selected"; ?> >Active</option>
		</select>



<?php
	submit_button('Save');
	echo '</form></div>';
	
	if(get_option('aal_ebayactive') ) {
		
	
?>


<?php

	}
	
	
	
	
	echo '</div>';

}





?>