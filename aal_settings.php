<?php

//Change General setings through ajax 
function aalChangeOptions(){	
		//Input check
		$aal_showhome = filter_input(INPUT_POST, 'aal_showhome', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_notimes = filter_input(INPUT_POST, 'aal_notimes', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_exclude = filter_input(INPUT_POST, 'aal_exclude', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_iscloacked = filter_input(INPUT_POST, 'aal_iscloacked', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_targeto = filter_input(INPUT_POST, 'aal_target', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_relationo = filter_input(INPUT_POST, 'aal_relation', FILTER_SANITIZE_SPECIAL_CHARS);
		
		//Delete the settings and re-add them		
                delete_option('aal_iscloacked'); add_option( 'aal_iscloacked', $aal_iscloacked);		
		delete_option('aal_showhome'); add_option( 'aal_showhome', $aal_showhome);		
		delete_option('aal_notimes'); add_option( 'aal_notimes', $aal_notimes);				
		delete_option('aal_exclude'); add_option( 'aal_exclude', $aal_exclude);		
		delete_option('aal_target'); add_option( 'aal_target', $aal_targeto);
		delete_option('aal_relation'); add_option( 'aal_relation', $aal_relationo);
                
           die();
}


function wpaal_general_settings() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";	
	

        
        $iscloacked = get_option('aal_iscloacked');
	if($iscloacked=='true') $isc = 'checked'; else $isc = '';
        
	$showhome = get_option('aal_showhome');
        if($showhome=='true') $shse = 'checked'; else $shsel = '';
        
	$notimes = get_option('aal_notimes');
        
	$targeto = get_option('aal_target');
	if($targeto=="_blank") $tsc1 = 'checked'; else $tsc2 = 'checked';
	
        
        $relationo = get_option('aal_relation');
	if($relationo=="nofollow") $rsc1 = 'checked'; else $rsc2 = 'checked';	
	
	?>
	
	
<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>General Settings</h2>
                <div class="aal_general_settings">
                <form name="aal_settings" id="aal_changeOptions" method="post">
                    <span class="aal_label">Cloak links:</span> <input type="checkbox" name="aal_iscloacked" id="aal_iscloacked"  <?php echo $isc;?> /> (Disable this if the cloaked links are not working for you)<br /><br />
                    
                    <span class="aal_label">Add links on homepage:</span> <input type="checkbox" name="showhome" id="aal_showhome" <?php echo $shse;?> /> <br /><br />
                    
                    <span class="aal_label">Target:</span> <input type="radio" name="aal_target" value="_blank" <?php echo $tsc1;?> /> New window <input type="radio" name="aal_target" value="_self" <?php echo $tsc2 ;?>/> Same Window <br /><br />
                    
                    <span class="aal_label">Link Frequency:</span> <select name="notimes" id="aal_notimes" value="<?php echo $notimes ;?>" size="1" />
                    	<option value="1" <?php if($notimes=="1") echo "SELECTED"; ?> >Very Low</option>
						<option value="2" <?php if($notimes=="2") echo "SELECTED"; ?> >Low</option>
						<option value="3" <?php if($notimes=="3") echo "SELECTED"; ?> >Average</option>
						<option value="4" <?php if($notimes=="4") echo "SELECTED"; ?> >High</option>
						<option value="5" <?php if($notimes=="5") echo "SELECTED"; ?> >Very High</option>
					</select>                    
                    <br /><br />
                    <?php //echo $relationo; ?>
                    <span class="aal_label">Relation:</span> <input type="radio" name="aal_relation" value="nofollow" <?php echo $rsc1; ?> /> Nofollow <input type="radio" name="aal_relation" value="dofollow" <?php echo $rsc2 ;?>/> Dofollow <br /><br /><br />
                   
                   
                   <p class="submit"> <input type="submit" class="button-primary"  value="Save Changes" /> </p>
                </form>
                <span class="aal_add_link_status"> </span>	
				</div>
	
	</div>
	
	<?php
}




?>