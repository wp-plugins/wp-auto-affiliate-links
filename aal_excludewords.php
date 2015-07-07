<?php


add_action('admin_init', 'aal_exclude_words_actions');



 function aal_exclude_words_actions() {
	global $wpdb;
	
		if($_POST['aal_add_exclude_word_check']=='ok') {
			

			$word = filter_input(INPUT_POST, 'aal_add_exclude_word', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['id'];


			if(get_option('aal_excludewords')) {
				$old = get_option('aal_excludewords');
				update_option('aal_excludewords',$old . ',' . $word);
			}
			else {
				add_option('aal_excludewords', $word);
			} 
		//	wp_redirect("admin.php?page=aal_topmenu");
	
			
	}
	
	
	
} 



function wpaal_exclude_words() {
	global $wpdb;


?>

<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
 
        
        
                <h2>Exclude Words</h2>
                <br /><br /><br />
                

<h3>Manually exclude words</h3>                
                
                 <form name="aal_add_exclude_words_form" id="aal_add_exclude_words_form" method="post">
                    <b>Enter keywords to exclude </b>:
                    <input type="text" name="aal_add_exclude_word" id="aal_add_exclude_word"  size="20" />
                    <input type="hidden" name="aal_add_exclude_word_check" value="ok" />
                    <input  class="button-primary"  type="submit" value="Exclude Word"/>
                </form>
                Please note that this is case sensitive, so you must add the word in the exact match
                
                
               <br />
               <br /
     <h4>Excluded words:</h4><br /><br />
     <?php 
     	$words = get_option('aal_excludewords'); 
     	$words = explode(',', $words);
     	
     	foreach ($words as $word) {
     		
     		echo $word .'<br />';	
     		
     	}
     
     
     
     
     ?>
                
 
                
                
    <br />
    <br /><br />
    <hr />
  <p>If you have problems or questions about the plugin, or if you just want to send a suggestion or request to our team, you can use the <a href="http://wordpress.org/support/plugin/wp-auto-affiliate-links">support forum</a>. Make sure that you consult our <a href="http://wordpress.org/plugins/wp-auto-affiliate-links/faq/">FAQ section</a> first. </p>
  
  </div>













<?php



}