<?php

// Contribution of Jos Steenbergen
// Rewrite engine for links

function wpaal_rewrite_rules() {
		add_rewrite_tag('%goto%','([^&]+)');
                add_rewrite_rule( 'goto/?([^/]*)', 'index.php?goto=$matches[1]', 'top');
       }
       
function wpaal_add_query_var($vars)  { 
       $vars[] = 'goto';
       return $vars;
       }
       
       
       

function wpaal_generateSlug($phrase)
{
       $maxLength = 45;
       $result = strtolower($phrase);

       $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
       $result = trim(preg_replace("/[\s-]+/", " ", $result));
       $result = trim(substr($result, 0, $maxLength));
       $result = preg_replace("/\s/", "-", $result);

       return $result;
}


function wpaal_check_for_goto() { 
       global $wpdb;
       global $wp_query;

	    
	   //echo $wp_query->query_vars['goto'];
       if(isset($wp_query->query_vars['goto'])) {
       //echo $wp_query->query_vars['goto'];
       //echo 'having goto';
	  // die();


       $table_name = $wpdb->prefix . "automated_links";
              // $myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );

 			
				global $wp_rewrite;// echo $wp_rewrite->permalink_structure;
				// echo $wp_query->query_vars['goto']; die();
				if($wp_query->query_vars['goto'] && is_numeric($wp_query->query_vars['goto'])) { 

					$rerow = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name ." WHERE id='". $wp_query->query_vars['goto'] ."'  ");
					//print_r($rerow);
					if($rerow[0]->link) wp_redirect( $rerow[0]->link, 302 );
					 
				}

               //print_r($patterns);
               //print_r($redirect_link);

               //die();
               }
       //print_r($array = $GLOBALS['wp_query']->query_vars);


}

?>