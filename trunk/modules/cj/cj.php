<?php


$aalCj = new aalModule('cj','Commission Junction Links',6);
$aalModules[] = $aalCj;

$aalCj->aalModuleHook('content','aalCjDisplay');
$aalCj->aalModuleHook('actions','aalCjActions');


add_action( 'admin_init', 'aal_cj_register_settings' );


function aal_cj_register_settings() { 
   register_setting( 'aal_cj_settings', 'aal_cjactive' );
}

function aalCjDisplay() {
	
?>


<script type="text/javascript">




function aal_cj_validate() {
	
		if(!document.aal_cj.aal_cjfeed.value) { alert("Please select a file to upload"); return false; }
		
		return true;
				
	}



	
</script>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Commission Junction Links</h2>
                <br /><br />
                Upload any file you get from an affiliate merchant and press "Upload".  Keywords will be automatically generated.<br />
                This feature will only work if you have set the API Key in the "API Key" menu, and the API key is valid and active.
                <br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_cjform" > 
<?php
		settings_fields( 'aal_cj_settings' );
		do_settings_sections('aal_cj_settings_display');
		
?>
				<span class="aal_label">Status: </span><select name="aal_cjactive">
			<option value="0" <?php if(get_option('aal_cjactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_cjactive')=='1') echo "selected"; ?> >Active</option>
		</select>



<?php
	submit_button('Save');
	echo '</form></div>';
	
	if(get_option('aal_cjactive') ) {
		
		global $uploadmessage;
?>

	<h3>Upload a Commission Junction .txt file</h3>
<div class="aal_general_settings">

	<form name="aal_cj" method="post" enctype="multipart/form-data" onsubmit="return aal_cj_validate();">
	<span class="aal_label">File: </span><input name="aal_cjfeed" type="file" /><input type="submit" value="Upload" />
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
<input type="hidden" name="aal_cjaction" value="1" />
	</form>
	<?php echo $uploadmessage; ?>


</div>




<?php

	}
	
	
	?>
	
	<br /><br />
	<h3>Your Commission Junction links</h3>
	<br />
	
	
	<?php
	
	echo aal_showcustomlinks('cj');
	
	
	echo '</div>';

}


function aalCjActions() {
	global $wpdb;
	 $table_name = $wpdb->prefix . "automated_links";
	
	if($_POST['aal_cjaction']) {
	
		global $uploadmessage;
		if($_FILES['aal_cjfeed']["error"]) { $uploadmessage = "File was too large"; }
		else {			
		
		$handle = fopen($_FILES['aal_cjfeed']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 100000, "|")) !== FALSE) {
			//print_r($data);
			$link = $data[17];
			if(!strpos($link, 'ttp')) continue;
			$merchant = $data[0];
			//$link = str_replace("YOURUSERID", $sasid, $data[4]);
			$meta = $data[4];
			if($link && $meta && $merchant) {
				
					$sle = new stdClass(); 
					$sle->link = $link;
					$sle->merchant = $merchant;
					$sle->title = $meta;
					$slearray[] = $sle;
					
				
				}
		
		
		
		}
		fclose($handle);

		$slejson = json_encode($slearray); 
		$postcontent = "slejson=". urlencode($slejson) ."&apikey=". get_option('aal_apikey');
		$response = aal_post($postcontent, 'http://autoaffiliatelinks.com/api/cj.php');
		
		echo $response;



		$uploadmessage = "Upload succesfull";
		
		}
		
	
	
	}	
	
}




?>