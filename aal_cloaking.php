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
       
       if(isset($wp_query->query_vars['goto'])) {


       $table_name = $wpdb->prefix . "automated_links";
              // $myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
 			
				global $wp_rewrite;
				if($wp_query->query_vars['goto'] && is_numeric($wp_query->query_vars['goto'])) { 

					$rerow = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name ." WHERE id='". $wp_query->query_vars['goto'] ."'  ");
					if($rerow[0]->link) wp_redirect( $rerow[0]->link, 302 );
					 
				}

               }


}

?>