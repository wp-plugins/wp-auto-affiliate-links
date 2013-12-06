<?php


$aalClickbank = new aalModule('clickbank','Clickbank Links');
$aalModules[] = $aalClickbank;

$aalClickbank->aalModuleHook('content','aalClickbankDisplay');


add_action( 'admin_init', 'aal_clickbank_register_settings' );


function aal_clickbank_register_settings() { 
  register_setting( 'aal_clickbank_settings', 'aal_clickbankid' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankactive' );
}




function aalClickbankDisplay() {

	?>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Clickbank Links</h2>
                <br /><br />
                Once you add your affiliate ID and activate clickbank links, they will start to appear on your website. The manual links that you add will have priority.
                <br /><br />
                
		<form method="post" action="options.php"> 
<?php
		settings_fields( 'aal_clickbank_settings' );
		do_settings_sections('aal_clickbank_settings_display');
		
?>

		Clickbank ID: <input type="text" name="aal_clickbankid" value="<?php echo get_option('aal_clickbankid'); ?>" /><br />
		Status: <select name="aal_clickbankactive">
			<option value="" <?php if(get_option('aal_clickbankactive')=='') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('fsrm-alignment')=='1') echo "selected"; ?> >Active</option>
		</select><br />

<?php
	submit_button('Save');
	echo '</form></div>';


}




?>