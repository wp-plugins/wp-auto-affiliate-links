<?php


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


function aalUpdateExcludePosts(){
            
    //$update_exclude_posts= filter_input(INPUT_POST, 'aal_exclude_posts', FILTER_SANITIZE_SPECIAL_CHARS);
    $update_exclude_posts=  $_POST['aal_exclude_posts'];
    $update_exclude_posts=  implode(',', $update_exclude_posts);
    $update_exclude_posts= esc_sql(htmlentities($update_exclude_posts));
    delete_option('aal_exclude');add_option( 'aal_exclude', $update_exclude_posts);

    
    die();
}

	

function wpaal_exclude_posts() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";	
	

	
	?>
	
	
<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Exclude Posts</h2>
                <br /><br /><br />
                
                 <form name="aal_add_exclude_posts_form" id="aal_add_exclude_posts_form" method="post">
                    <b>Enter post ID </b>:
                    <input type="text" name="aal_exclude_post_id" id="aal_add_exclude_post_id"  size="10" />
                    <input type="submit" value="Exclude Post"/>
                </form>
                
                <br /><br /><br />
                <h4>Excluded Posts ID's</h4>
                <form class="aal_exclude_posts">
                <?php 
                $aal_exclude_posts=get_option('aal_exclude');
                $aal_exclude_posts_array=explode(',', $aal_exclude_posts);
                
                foreach ($aal_exclude_posts_array as $aal_exclude_post_id)
                  if($aal_exclude_post_id!='') { 
						$exclude_title = get_the_title($aal_exclude_post_id);
						if(!$exclude_title) $status = 'post with the given id does not exist';
							else $status = get_post_status($aal_exclude_post_id);
						
				  
                    echo "<span>
                            Post ID: ".$aal_exclude_post_id."   <a href='".get_permalink($aal_exclude_post_id)."'>".get_the_title($aal_exclude_post_id)."</a>  -  ". $status ."                            <a href='javascript:' id='".$aal_exclude_post_id."' class='aal_delete_exclude_link'><img src='".plugin_dir_url(__FILE__)."images/delete.png'/></a><br/>
                          </span>";
					
				}
               
                
                ?>
                </form>
                
                <span class="aal_exclude_status"> </span>
 
	
	<?php
}




?>