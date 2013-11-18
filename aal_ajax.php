<?php



//Delete link button (called by ajax)
function aalDeleteLink(){
    
            if(isset($_POST['id'])){
                global $wpdb;
                $table_name = $wpdb->prefix . "automated_links";
                
                //Security check and input sanitize
		$id = intval(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS)); // $_GET['id'];
		
		//Add to database and redirect to the plugin default page
		$wpdb->query("DELETE FROM ". $table_name ." WHERE id = '". $id ."' LIMIT 1");
                
                die();
            }
}



function aalUpdateExcludePosts(){
            
    //$update_exclude_posts= filter_input(INPUT_POST, 'aal_exclude_posts', FILTER_SANITIZE_SPECIAL_CHARS);
    $update_exclude_posts=  $_POST['aal_exclude_posts'];
    $update_exclude_posts=  implode(',', $update_exclude_posts);
    $update_exclude_posts=mysql_real_escape_string(htmlentities($update_exclude_posts));
    delete_option('aal_exclude');add_option( 'aal_exclude', $update_exclude_posts);

    
    die();
}

function aalAddExcludePost(){
            
                $aal_exclude_id= filter_input(INPUT_POST, 'aal_post', FILTER_SANITIZE_SPECIAL_CHARS);
                $aal_posts =get_option('aal_exclude');
                
                $post = get_post($aal_exclude_id);
                $data['post_title'] = $post->post_title;
                if(!$post->ID) {
                die('nopost');
					}
               
                
                if($aal_posts=='')$aal_exclude=$aal_exclude_id;
                    else $aal_exclude=$aal_posts.",".$aal_exclude_id;
                    
                 
                delete_option('aal_exclude');add_option( 'aal_exclude', $aal_exclude);
                echo " <a href='".get_permalink($post->ID)."'>".get_the_title($post->ID)."</a>  -  ". get_post_status($post->ID) ."                            ";
                
                 
                die();
}


//Add link form (called by ajax)
function aalAddLink(){
    
            	global $wpdb;
                $table_name = $wpdb->prefix . "automated_links";
     	
		// Security check and sanitize	
		$aal_link = filter_input(INPUT_POST, 'aal_link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
		$aal_keywords = filter_input(INPUT_POST, 'aal_keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];
		
		$check = $wpdb->get_results( "SELECT * FROM ". $table_name ." WHERE link = '". $aal_link ."' " );		
		
		// Add to database 
		if($check) { 
				$wpdb->update( $table_name, array( 'keywords' => $check[0]->keywords .','. $aal_keywords), array( 'link' => $aal_link ) );
				$aal_delete_id=$check[0]->id;
			}
		else {
			$rows_affected = $wpdb->insert( $table_name, array( 'link' => $aal_link, 'keywords' => $aal_keywords ) );
			$aal_delete_id=$wpdb->insert_id;
		}
        
                
                
                $aal_json=array('aal_delete_id'=>$aal_delete_id);
                
                echo json_encode($aal_json);
                
                die();
}






?>