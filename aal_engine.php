<?php


// The function that will actually add links when the post content is rendered
function wpaal_add_affiliate_links($content) {
		global $wpdb;
		if(!is_main_query()) return $content;
		
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
		
		$clickbankid = get_option('aal_clickbankid');
		$clickbankcat = get_option('aal_clickbankcat');
		$clickbankgravity = get_option('aal_clickbankgravity');
		$clickbankactive = get_option('aal_clickbankactive');
		
		
		$apikey = get_option('aal_apikey');
		
		if($relationo=='nofollow') $relo = ' rel="nofollow" ';
		else $relo = '';
		
		//regular expression setup
		$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	
		$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
		$strpos_fnc		=	 'stripos';		
		global $wp_rewrite; 
		global $post;


		$patterns = array();
		
		//If the post is set for exclusion, exit
		if(in_array($post->ID, $excludearray)) return $content;
		
		
			//Check to see if it is the homepage
			if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index.php') $ishome = 1; else $ishome=0;	
			//If it is home and ishome is set do none, then exit the function
			if($ishome && $showhome!='true') return $content;
		


		//If no keywords are set, exit the function
		if(!is_null($myrows)) {
		
		foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
 						if($key) if(!in_array('/'. $key .'/', $patterns)) { 
								
							$redid = $row->id;
							if($iscloacked=='true')  {
								
							// echo $wp_rewrite->permalink_structure;
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
		} //endforeach
		
		} //endif
		
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";

		


			
				if(is_array($regexp)) { 
					
				
					$sofar = 0;
					foreach($regexp as $regnumber => $reg1) {
						
						$count = 0;
						if(stripos($content, $keys2[$regnumber]) !== false) $content = preg_replace($reg1, $replace[$regnumber], $content,1,$count);
						if($count>0) $sofar++;
						if($sofar >= $notimes) continue;
						
					
					}				
				
				}
				
				
				//If the manual replacement did not found enough links
				if($sofar<$notimes && $clickbankactive) {
					
		$aaldivnumber = rand(1,10000);			
					
		$left = $notimes - $sofar;		
		$content = $content .= ' 

		<script type="text/javascript" src="'. plugin_dir_url( __FILE__ ) . 'js/api.js "></script>
		<script type="text/javascript">
		jQuery(document).ready(function() { 
		
			aal_divnumber = "'. $aaldivnumber .'";
			aal_target = "'. $targeto .'";
			aal_relation = \''. $relo .'\';
			aal_postid = "post-'. $post->ID .'"; // urlencode($content)
			aalapidata = {content:"'. urlencode($content) .'",apikey: "'. $apikey .'", clickbankid: "'. $clickbankid .'", clickbankcat: "'. $clickbankcat .'", clickbankgravity: "'. $clickbankgravity .'", notimes: "'. $left .'"};		

		
			aal_retrievelinks(aalapidata,aal_divnumber,aal_target,aal_relation);
		
		
		 });
		
		</script>		
		
		';
		
		$content = $content .'<div id="aalcontent_'. $aaldivnumber .'"></div>';
						
					
				/* $getcontent = 'content='. urlencode($content) .'&clickbankid='. $clickbankid;	
				$products = aal_post($getcontent,'http://autoaffiliatelinks.com/api/pro.php');
				$products = json_decode($products);
				
				
				
				//print_r($products);
				//echo $products;

					foreach($products as $product) {
						
						$name = $product->key;
						$url = $product->url;

						$replacesingle = "<a title=\"$1\" class=\"aal\" target=\"". $targeto ."\" ". $relo ." href=\"$url\">$1</a>";
						$regexpsingle = str_replace('$name', $name, $reg);						

						//$content = preg_replace($regexpsingle, $replacesingle, $content,1,$count);
						//if($count>0) $sofar++;

					
					
					
					}  */



					
				}
				
		

		
		
		
		
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";		
						
		return $content; 


}  // add_affiliate_links end


function aal_post($requestJson,$postUrl) {


    //Get length of post
    $postlength = strlen($requestJson);

    //open connection
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL,$postUrl);
    curl_setopt($ch,CURLOPT_POST,$postlength);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$requestJson);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    //close connection
    curl_close($ch);

    return $response;
}




?>