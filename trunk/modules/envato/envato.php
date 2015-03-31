<?php


$aalEnvato = new aalModule('envato','Envato Marketplace Links',8);
$aalModules[] = $aalEnvato;

$aalEnvato->aalModuleHook('content','aalEnvatoDisplay');
//$aalEbay->aalModuleHook('actions','aalBestbuyActions');


add_action( 'admin_init', 'aal_envato_register_settings' );


function aal_envato_register_settings() { 
   register_setting( 'aal_envato_settings', 'aal_envatoactive' );
   register_setting( 'aal_envato_settings', 'aal_envatosite' );
   register_setting( 'aal_envato_settings', 'aal_envatoid' );
}

function aalEnvatoDisplay() {
	
?>


<script type="text/javascript">

function aal_envato_validate() {
	
		if(!document.aal_envato.aal_envato.value) { alert("Please add your Envato Marketplace affiliate ID"); return false; }
		
		return true;
				
	}
</script>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Envato Links</h2>
                <br /><br />
Enter your Envato Marketpalce affiliate ID and activate the module
<br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_envatoform" onsubmit="return aal_envato_validate();"> 
<?php
		settings_fields( 'aal_envato_settings' );
		do_settings_sections('aal_envato_settings_display');
		
?>

			<span class="aal_label">Affiliate ID:</span> <input type="text" name="aal_envatoid" value="<?php echo get_option('aal_envatoid'); ?>" /><br />
			<span class="aal_label">Site:</span> <select name="aal_envatosite">
			<option value="themeforest" <?php if(get_option('aal_envatosite')=='themeforest') echo "selected"; ?> >Theme Forest</option>
			<option value="activeden" <?php if(get_option('aal_envatosite')=='activeden') echo "selected"; ?> >Active Den</option>
			<option value="audiojungle" <?php if(get_option('aal_envatosite')=='audiojungle') echo "selected"; ?> >Audio Jungle</option>
			<option value="videohive" <?php if(get_option('aal_envatosite')=='videohive') echo "selected"; ?> >Video Hive</option>
			<option value="graphicriver" <?php if(get_option('aal_envatosite')=='graphicriver') echo "selected"; ?> >Graphic River</option>
			<option value="3docean" <?php if(get_option('aal_envatosite')=='3docean') echo "selected"; ?> >3D Ocean</option>
			<option value="codecanyon" <?php if(get_option('aal_envatosite')=='codecanyon') echo "selected"; ?> >Code Canyon</option>
			<option value="photodune" <?php if(get_option('aal_envatosite')=='photodune') echo "selected"; ?> >Photo Dune</option>
			
		</select><br />
				<span class="aal_label">Status: </span><select name="aal_envatoactive">
			<option value="0" <?php if(get_option('aal_envatoactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_envatoactive')=='1') echo "selected"; ?> >Active</option>
		</select>



<?php
	submit_button('Save');
	echo '</form></div>';
	
	if(get_option('aal_envatoactive') ) {
		
	
?>

<?php

	}
	
	
	
	
	echo '</div>';

}
?>