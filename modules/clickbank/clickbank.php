<?php


$aalClickbank = new aalModule('clickbank','Clickbank Links');
$aalModules[] = $aalClickbank;

$aalClickbank->aalModuleHook('content','aalClickbankDisplay');


add_action( 'admin_init', 'aal_clickbank_register_settings' );


function aal_clickbank_register_settings() { 
   register_setting( 'aal_clickbank_settings', 'aal_clickbankid' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankcat' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankgravity' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankactive' );
}




function aalClickbankDisplay() {

	?>
	
	<script type="text/javascript">


function aal_getScript(url, callback) {
   var script = document.createElement("script");
   script.type = "text/javascript";
   script.src = url;

   script.onreadystatechange = callback;
   script.onload = callback;

   document.getElementsByTagName("head")[0].appendChild(script);
}


aal_getScript("//autoaffiliatelinks.com/api/api.php?action=allcats", function(){
 
	var maincat = document.getElementById("aal_clickbankcat");
			number = maincats.length;
			
			//alert(number);
			var i=0;
			for(ir=1;ir<number+1;ir++) {
				
			
			//alert("aaa");
			
			//alert(catarray[parent][ir-1][0] + catarray[parent][ir-1][1] );
			

					
				ovalue = maincats[ir-1][0];
				otext = maincats[ir-1][1];
				if(maincats[ir-1][2] != 0) otext = '--- ' + otext;
				option= new Option(otext,ovalue);
				document.getElementById("aal_clickbankcat").options[ir] = option; 
				
				if("<?php echo get_option('aal_clickbankcat'); ?>" == ovalue) document.getElementById("aal_clickbankcat").selectedIndex = ir;
	
			}

});


function aal_clickbank_validate() {
	
		if(!document.aal_clickbankform.aal_clickbankcat.value) { alert("Please select a category"); return false; }
		if(!document.aal_clickbankform.aal_clickbankid.value) { alert("Please add your clickbank ID"); return false; }
		if(!document.aal_clickbankform.aal_clickbankgravity.value) { alert("If you wish to get all the products regardless the gravity, add leave the gravity field with 0"); return false; }
				
	}



	
	</script>
	
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Clickbank Links</h2>
                <br /><br />
                Once you add your affiliate ID and activate clickbank links, they will start to appear on your website. The manual links that you add will have priority.<br />
                This feature will only work if you have set the API Key in the respective menu.
                <br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_clickbankform" onsubmit="return aal_clickbank_validate();"> 
<?php
		settings_fields( 'aal_clickbank_settings' );
		do_settings_sections('aal_clickbank_settings_display');
		
?>
		<span class="aal_label">Affiliate ID:</span> <input type="text" name="aal_clickbankid" value="<?php echo get_option('aal_clickbankid'); ?>" /><br />
	<span class="aal_label">Category: </span><select id="aal_clickbankcat"  name="aal_clickbankcat" ><option value="">-Select a cateogry-	</option>
	</select>
	<br />
		<span class="aal_label">Minimum gravity: </span><input type="text" name="aal_clickbankgravity" value="<?php echo get_option('aal_clickbankgravity'); ?>" /><br />
		<span class="aal_label">Status: </span><select name="aal_clickbankactive">
			<option value="0" <?php if(get_option('aal_clickbankactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_clickbankactive')=='1') echo "selected"; ?> >Active</option>
		</select><br />




<?php
	submit_button('Save');
	echo '</form></div>';
	echo '</div>';

		

?>


</div>




<?php 
	

} ?>