<?php 

$aalCustomFeed = new aalModule('customfeed','Custom Feed',23);


$aalCustomFeed->aalModuleHook('content','aalCustomFeedDisplay');
function aalCustomFeedDisplay() {

	?>
	
	
<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Custom Feed Upload</h2>
                <br/><br />


				Upload your datafeed. The format should be keyword,url. The separator is the character who separate the columns, it can be a comma ( , ), a vertical bar ( | ) or a tab ( exactly 4 spaces ). For tab, just write "tab" in the text field. If you don't know, open the feed file in notepad or any other simple text editor. You can edit your datafeed in Microsoft Excell or Libre Office Calc. Make sure you save the file in csv format ( not in xls or odt ). Upon saving, you can select the separator. All the links inside the datafeed will be added to your affiliate links. 
				<br />
				<br />
				
				
			<form name="aal_import_form" method="post" enctype="multipart/form-data" onsubmit="">
			Upload the file here:    <input name="aal_import_file" type="file" /><br />
			Separator: <select name="aal_import_separator" onchange="if(document.aal_import_form.aal_import_separator.options[document.aal_import_form.aal_import_separator.selectedIndex].value == 'other') document.aal_import_form.aal_import_other.style.display = 'block'; else document.aal_import_form.aal_import_other.style.display = 'none';">
			<option value="|">| ( vertical line )</option>
			<option value="tab">Tab</option>
			<option value=",">, ( comma )</option>
			<option value=";">; ( semicolon )</option>
			<option value=".">. ( dot )</option>
			<option value="other">other ( specify below )</option>
			</select>
			<br /><input type="text" name="aal_import_other" value="|" style="display: none;"/>
			<br />
			<input type="submit" value="Import" /><input type="hidden" name="MAX_FILE_SIZE" value="10000000" /><input type="hidden" name="aal_import_check" value="1" />
			</form>
			
	</div>
				
	<?php

}



$aalModules[] = $aalCustomFeed;

add_action('admin_init', 'aalModuleCustomFeedAction');
function aalModuleCustomFeedAction() {
global $wpdb;
        $table_name = $wpdb->prefix . "automated_links";
	if($_POST['aal_import_check']) {
	
		//$sasid = filter_input(INPUT_POST, 'aal_sasid', FILTER_SANITIZE_SPECIAL_CHARS);
		//$scontent = file_get_contents($_FILES['aal_sasfeed']['tmp_name']);
		//print_r($_FILES['aal_sasfeed']);
		
		$separator = $_POST['aal_import_separator'];
		if($separator=='tab') $separator = "\t";
		if($separator=='other') $separator = $_POST['aal_import_other'];
		if(!$separator) $separator = "|";
		
		
		$handle = fopen($_FILES['aal_import_file']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
		//print_r($data);
		//$link = str_replace("YOURUSERID", $sasid, $data[4]);
		$link = $data[1];
		$keywords = $data[0];
		if($link && $keywords) $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords ) );
		}
		fclose($handle);
		
		wp_redirect("admin.php?page=aal_topmenu#aal_panel4");
		
		// echo $scontent;
		
		//die();
		
	
	
	}

}

?>