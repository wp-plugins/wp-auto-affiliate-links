<?php


$aalShareasale = new aalModule('shareasale','Shareasale Links',5);
$aalModules[] = $aalShareasale;

$aalShareasale->aalModuleHook('content','aalShareasaleDisplay');
$aalShareasale->aalModuleHook('actions','aalShareasaleActions');


add_action( 'admin_init', 'aal_shareasale_register_settings' );


function aal_shareasale_register_settings() { 
   register_setting( 'aal_shareasale_settings', 'aal_shareasaleid' );
   register_setting( 'aal_shareasale_settings', 'aal_shareasaleactive' );
}

function aalShareasaleDisplay() {
	
?>


<script type="text/javascript">




function aal_shareasale_validate() {
	
		if(!document.aal_shareasale.aal_shareasalefeed.value) { alert("Please select a file to upload"); return false; }
		
		return true;
				
	}



	
</script>
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Shareasale Links</h2>
                <br /><br />
                First, add your shareasale affiliate ID and save it. Then upload any file you get from an affiliate merchant and press "Upload". Your affiliate ID will be added to the links. Keywords will be automatically generated.<br />
                This feature will only work if you have set the API Key in the "API Key" menu, and the API key is valid and active.
                <br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_shareasaleform" > 
<?php
		settings_fields( 'aal_shareasale_settings' );
		do_settings_sections('aal_shareasale_settings_display');
		
?>
		<span class="aal_label">Affiliate ID:</span> <input type="text" name="aal_shareasaleid" value="<?php echo get_option('aal_shareasaleid'); ?>" /><br />
				<span class="aal_label">Status: </span><select name="aal_shareasaleactive">
			<option value="0" <?php if(get_option('aal_shareasaleactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_shareasaleactive')=='1') echo "selected"; ?> >Active</option>
		</select>



<?php
	submit_button('Save');
	echo '</form></div>';
	
	if(get_option('aal_shareasaleid') && get_option('aal_shareasaleactive') ) {
		
		global $uploadmessage;
?>

	<h3>Upload a Shareasale .txt file</h3>
<div class="aal_general_settings">

	<form name="aal_shareasale" method="post" enctype="multipart/form-data" onsubmit="return aal_shareasale_validate();">
	<span class="aal_label">File: </span><input name="aal_shareasalefeed" type="file" /><input type="submit" value="Upload" />
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
<input type="hidden" name="aal_shareasaleaction" value="1" />
	</form>
	<?php echo $uploadmessage; ?>


</div>




<?php

	}
	
	?>
	
	<br /><br />
	<h3>Your Shareasale links</h3>
	<br />
	
	
	<?php
	
	
	
	echo aal_showcustomlinks('shareasale');
	
	echo '</div>';

}


function aalShareasaleActions() {
	global $wpdb;
	 $table_name = $wpdb->prefix . "automated_links";
	
	if($_POST['aal_shareasaleaction']) {
	
		$sasid = get_option('aal_shareasaleid');
		//$scontent = file_get_contents($_FILES['aal_sasfeed']['tmp_name']);
		//print_r($_FILES['aal_sasfeed']);


		global $uploadmessage;
		if($_FILES['aal_shareasalefeed']["error"]) { $uploadmessage = "File was too large"; }
		else {			
		
		$handle = fopen($_FILES['aal_shareasalefeed']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
			//print_r($data);
			$link = $data[4];
			if(!strpos($link, 'YOURUSERID')) $link = $data[3]; 
			if(!strpos($link, 'YOURUSERID')) $link = $data[2];
			if(!strpos($link, 'YOURUSERID')) $link = $data[4];
			if(!strpos($link, 'YOURUSERID')) $link = $data[5];
			if(!strpos($link, 'YOURUSERID')) continue;
			$merchant = $data[3];
			//$link = str_replace("YOURUSERID", $sasid, $data[4]);
			$meta = $data[1];
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
		$postcontent = "slejson=". urlencode($slejson) ."&shareasaleid=". get_option('aal_shareasaleid') ."&apikey=". get_option('aal_apikey');
		$response = aal_post($postcontent, 'http://autoaffiliatelinks.com/api/shareasale.php');
		
		echo $response;
		$uploadmessage = "Upload succesfull";
		
		}
		
	
	
	}	
	
}
?>