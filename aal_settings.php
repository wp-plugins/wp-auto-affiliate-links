<?php

//Change General setings through ajax 
function aalChangeOptions(){	
		//Input check
		$aal_showhome = filter_input(INPUT_POST, 'aal_showhome', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_notimes = filter_input(INPUT_POST, 'aal_notimes', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_notimescustom = filter_input(INPUT_POST, 'aal_notimescustom', FILTER_SANITIZE_SPECIAL_CHARS);
		//$aal_exclude = filter_input(INPUT_POST, 'aal_exclude', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_iscloacked = filter_input(INPUT_POST, 'aal_iscloacked', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_targeto = filter_input(INPUT_POST, 'aal_target', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_relationo = filter_input(INPUT_POST, 'aal_relation', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_cssclass = filter_input(INPUT_POST, 'aal_cssclass', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_langsupport = filter_input(INPUT_POST, 'aal_langsupport', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_display = filter_input(INPUT_POST, 'aal_display', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_samekeyword = filter_input(INPUT_POST, 'aal_samekeyword', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_displayc = $_POST['aal_displayc'];
		//$aal_displayc = json_encode($aal_displayc);
		
		
		$aal_showhome = sanitize_text_field($aal_showhome);	
		$aal_notimes = sanitize_text_field($aal_notimes);	
		$aal_notimescustom = sanitize_text_field($aal_notimescustom);	
		$aal_iscloacked = sanitize_text_field($aal_iscloacked);	
		$aal_targeto = sanitize_text_field($aal_targeto);	
		$aal_relationo = sanitize_text_field($aal_relationo);	
		$aal_cssclass = sanitize_text_field($aal_cssclass);	
		$aal_langsupport = sanitize_text_field($aal_langsupport);	
		$aal_display = sanitize_text_field($aal_display);	
		$aal_samekeyword = sanitize_text_field($aal_samekeyword);	
		$aal_displayc = sanitize_text_field($aal_displayc);	
		
		
		
		
		
		//Delete the settings and re-add them		
                delete_option('aal_iscloacked'); add_option( 'aal_iscloacked', $aal_iscloacked);		
		delete_option('aal_showhome'); add_option( 'aal_showhome', $aal_showhome);		
		delete_option('aal_notimes'); add_option( 'aal_notimes', $aal_notimes);	
		delete_option('aal_notimescustom'); add_option( 'aal_notimescustom', $aal_notimescustom);				
		//delete_option('aal_exclude'); add_option( 'aal_exclude', $aal_exclude);		
		delete_option('aal_target'); add_option( 'aal_target', $aal_targeto);
		delete_option('aal_relation'); add_option( 'aal_relation', $aal_relationo);
      delete_option('aal_cssclass'); add_option( 'aal_cssclass', $aal_cssclass);
      delete_option('aal_langsupport'); add_option( 'aal_langsupport', $aal_langsupport);
      delete_option('aal_display'); add_option( 'aal_display', $aal_display);
      delete_option('aal_samekeyword'); add_option( 'aal_samekeyword', $aal_samekeyword);
      delete_option('aal_displayc'); add_option( 'aal_displayc', $aal_displayc);           
               
               
           die();
}


function wpaal_general_settings() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";	
	

        
        $iscloacked = get_option('aal_iscloacked');
	if($iscloacked=='true') $isc = 'checked'; else $isc = '';
	
        $langsupport = get_option('aal_langsupport');
	if($langsupport=='true') $langsc = 'checked'; else $langsc = '';
        
	$showhome = get_option('aal_showhome'); //echo $showhome;
        if($showhome=='true') $shse = 'checked'; else $shsel = '';
        
	$notimes = get_option('aal_notimes');
	$notimescustom = get_option('aal_notimescustom');
	$samekeyword = get_option('aal_samekeyword');
	$cssclass = get_option('aal_cssclass');
        
	$targeto = get_option('aal_target');
	if($targeto=="_blank") $tsc1 = 'checked';
	if($targeto=="_self") $tsc2 = 'checked';
	
	$displayo = get_option('aal_display');
        
        $relationo = get_option('aal_relation');
	if($relationo=="nofollow") $rsc1 = 'checked'; else $rsc2 = 'checked';	
	
	
	$displayc = get_option('aal_displayc'); 
	$displayc =json_decode(stripslashes($displayc));
	$post_types = get_post_types( '', 'names' ); 
	unset($post_types['revision']);
	unset($post_types['attachment']);
	unset($post_types['nav_menu_item']);
	//print_r($post_types);	
	
	
	?>
	
	
<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>General Settings</h2>
                <div class="aal_general_settings">
                <form name="aal_settings" id="aal_changeOptions" method="post">
                    <span class="aal_label">Cloak links:</span> <input type="checkbox" name="aal_iscloacked" id="aal_iscloacked"  <?php echo $isc;?> /> (Disable this if the cloaked links are not working for you)<br /><br />
                    
                    <span class="aal_label">Add links on homepage:</span> <input type="checkbox" name="showhome" id="aal_showhome" <?php echo $shse;?> /> <br /><br />
                    
                    <span class="aal_label">Target:</span> <input type="radio" name="aal_target" value="_blank" <?php echo $tsc1;?> /> New window <input type="radio" name="aal_target" value="_self" <?php echo $tsc2 ;?>/> Same Window <br /><br />
                    
                    <span class="aal_label">Link Frequency:</span> <select name="notimes" id="aal_notimes" value="<?php echo $notimes ;?>" size="1" onchange="aalFrequencySelector();" />
                    	<option value="1" <?php if($notimes=="1") echo "SELECTED"; ?> >Very Low</option>
						<option value="2" <?php if($notimes=="2") echo "SELECTED"; ?> >Low</option>
						<option value="3" <?php if($notimes=="3") echo "SELECTED"; ?> >Average</option>
						<option value="4" <?php if($notimes=="4") echo "SELECTED"; ?> >High</option>
						<option value="5" <?php if($notimes=="5") echo "SELECTED"; ?> >Very High</option>
						<option value="0" <?php if($notimes=="0") echo "SELECTED"; ?> >No Links</option>
						<option value="custom" <?php if($notimes=="custom") echo "SELECTED"; ?> >Custom Value</option>
					</select>                    
                    <br /><br />

                    <div id="aal_custom_frequency" <?php if($notimes=="custom") echo 'style="display: block;"'; else echo 'style="display: none;"'; ?>><span class="aal_label">Links in every article:</span> <input type="text" name="notimes" id="aal_notimescustom" value="<?php echo $notimescustom ;?>" size="1" />            
                    <br /><br /></div>
 
                     <span class="aal_label">Same keyword limit:</span> <select name="aal_samekeyword" id="aal_samekeyword" value="<?php echo $samekeyword ;?>" size="1" />
                    	<option value="1" <?php if($samekeyword=="1") echo "SELECTED"; ?> >1</option>
						<option value="2" <?php if($samekeyword=="2") echo "SELECTED"; ?> >2</option>
						<option value="3" <?php if($samekeyword=="3") echo "SELECTED"; ?> >3</option>
						<option value="4" <?php if($samekeyword=="4") echo "SELECTED"; ?> >4</option>
						<option value="5" <?php if($samekeyword=="5") echo "SELECTED"; ?> >5</option>
						<option value="nolimit" <?php if($samekeyword=="nolimit") echo "SELECTED"; ?> >No limit</option>
					</select>                    
                    <br /><br />                   
                    
                    
                    <span class="aal_label">Display:</span> 
                    <?php foreach($post_types as $pt) { ?>
                    	<input id="aal_displayc" type="checkbox" name="aal_displayc[]" value="<?php echo $pt; ?>" <?php if(in_array($pt,$displayc)) echo 'checked'; ?> /><?php echo $pt; ?> &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php } ?>
                    <!-- <select name="aal_display" id="aal_display" value="<?php echo $displayo; ?>" size="1" />
                  <option value="" <?php if($displayo=="") echo "SELECTED"; ?> >All content</option>
						<option value="post" <?php if($displayo=="post") echo "SELECTED"; ?> >Posts Only</option>
						<option value="page" <?php if($displayo=="page") echo "SELECTED"; ?> >Pages Only</option>

					</select>  -->                  
                    <br /><br />
                    <?php //echo $relationo; ?>
                    <span class="aal_label">Relation:</span> <input type="radio" name="aal_relation" value="nofollow" <?php echo $rsc1; ?> /> Nofollow <input type="radio" name="aal_relation" value="dofollow" <?php echo $rsc2 ;?>/> Dofollow <br /><br /><br />
                  <span class="aal_label">Link class :</span> <input type="text" name="aal_cssclass" id="aal_cssclass" value="<?php echo $cssclass; ?>" /> <br /><br /> 
                    <span class="aal_label">International Language Support:</span> <input type="checkbox" name="aal_langsupport" id="aal_langsupport"  <?php echo $langsc;?> /> (Experimental, disable it if causing problems)<br /><br />
                   
                   <p class="submit"> <input type="submit" class="button-primary"  value="Save Changes" /> </p>
                </form>
                <span class="aal_add_link_status"> </span>	
				</div>
				
	<br />
	<br />
<p>If you have problems or questions about the plugin, or if you just want to send a suggestion or request to our team, you can use the <a href="http://wordpress.org/support/plugin/wp-auto-affiliate-links">support forum</a>. Make sure that you consult our <a href="http://wordpress.org/plugins/wp-auto-affiliate-links/faq/">FAQ section</a> first. </p>
	
	</div>
	
	<?php
}




?>