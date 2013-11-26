<?php


// The function that will actually add links when the post content is rendered
function wpaal_add_affiliate_links($content) {
		global $wpdb;
		
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";
		
		//Getting the keywords and options
		$showhome = get_option('aal_showhome');
		$notimes = get_option('aal_notimes'); if(!$notimes) $notimes = -1;
		$aal_exclude = get_option('aal_exclude');
		$iscloacked = get_option('aal_iscloacked');
		//$iscloacked = 0;
		
		$targeto = get_option('aal_target');
		$relationo = get_option('aal_relation');
		$excludearray = explode(',',$aal_exclude);
		$table_name = $wpdb->prefix . "automated_links";
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
		
		if($relationo=='nofollow') $relo = ' rel="nofollow" ';
		else $relo = '';

		$patterns = array();

		//If no keywords are set, exit the function
		if(is_null($myrows)) return $content;
		
		else foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
 						if($key) if(!in_array('/'. $key .'/', $patterns)) { 

							//regular expression setup
							$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	
							$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
							$strpos_fnc		=	 'stripos';
								
								
							$redid = $row->id;
							if($iscloacked=='true')  {
								
							global $wp_rewrite; // echo $wp_rewrite->permalink_structure;
							if($wp_rewrite->permalink_structure) $link = get_option( 'home' ) . "/goto/" . $redid . "/" . wpaal_generateSlug($key);
							else $link = get_option( 'home' ) . "/?goto=" . $redid;	
								
								
								} //$link = get_option( 'home' ) . "/goto/" . wpaal_generateSlug($key);
							$url = $link;
							$name = $key;
							
							$keys2[] = $name;
							$replace[] = "<a title=\"$1\" class=\"aal\" target=\"". $targeto ."\" ". $relo ." href=\"$url\">$1</a>";
							$regexp[] = str_replace('$name', $name, $reg);	


						}
					}
				}
		}
		
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";

		global $post;

		//Check if the post is set for exclusion and do nothing
		if(in_array($post->ID, $excludearray)) { }
		else {
			//Check to see if it is the homepage
			if(is_array($regexp)) { if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index.php') $ishome = 1; else $ishome=0;
			
				if(!$ishome || $showhome=='true') {
					
					
										
					
					
					
			
			
			
				//if(!$ishome && $regexp[0]) $content = preg_replace($regexp, $replace, $content,1,$count);	
				//	else if($showhome=='true') if($regexp[0]) $content = preg_replace($regexp, $replace, $content,1);
				
					$sofar = 0;
					foreach($regexp as $regnumber => $reg1) {
						
						$count = 0;
						if(stripos($content, $keys2[$regnumber]) !== false) $content = preg_replace($reg1, $replace[$regnumber], $content,1,$count);
						if($count>0) $sofar++;
						if($sofar >= $notimes) continue;
						
					
					}				
				
				
					
				
				}
				
				
				
			}
		}
		
		
		
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";		
						
		return $content;


}  // add_affiliate_links end




?>