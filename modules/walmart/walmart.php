<?php


$aalWalmart = new aalModule('walmart','Walmart Links',9);
$aalModules[] = $aalWalmart;

$aalWalmart->aalModuleHook('content','aalWalmartDisplay');
//$aalEbay->aalModuleHook('actions','aalWalmartActions');


add_action( 'admin_init', 'aal_walmart_register_settings' );


function aal_walmart_register_settings() { 
   register_setting( 'aal_walmart_settings', 'aal_walmartactive' );
   register_setting( 'aal_walmart_settings', 'aal_walmartid' );
}

function aalWalmartDisplay() {
	
?>


<script type="text/javascript">




function aal_walmart_validate() {
	
		if(!document.aal_walmartform.aal_walmartid.value) { alert("Please add your Walmart campaign ID"); return false; }
		
		return true;
				
	}



	
</script>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Walmart Links</h2>
                <br /><br />
Enter your Linkshare affiliate ID for Walmart merchant and activate the module
<br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_walmartform" onsubmit="return aal_walmart_validate();"> 
<?php
		settings_fields( 'aal_walmart_settings' );
		do_settings_sections('aal_walmart_settings_display');
		
?>

			<span class="aal_label">Affiliate ID:</span> <input type="text" name="aal_walmartid" value="<?php echo get_option('aal_walmartid'); ?>" /><br />
				<span class="aal_label">Status: </span><select name="aal_walmartactive">
			<option value="0" <?php if(get_option('aal_walmartactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_walmartactive')=='1') echo "selected"; ?> >Active</option>
		</select>



<?php
	submit_button('Save');
	echo '</form></div>';
	
	if(get_option('aal_walmartactive') ) {
		
	
?>


<?php

	}
	
	
	
	
	echo '</div>';

}





?>