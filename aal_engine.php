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
		$notimescustom = trim(get_option('aal_notimescustom'));
		if($notimes=='custom') if(is_numeric($notimescustom) && $notimescustom>0) $notimes = $notimescustom; else $notimes = 3;
		//echo $notimes;
		$aal_exclude = get_option('aal_exclude');
		$iscloacked = get_option('aal_iscloacked');
		$cssclass = get_option('aal_cssclass');
		if($cssclass) $lclass = $cssclass;
		else $lclass = 'aal';
		$displayo = get_option('aal_display');
		//$iscloacked = 0;
		
		
		$samekeyword = get_option('aal_samekeyword'); if(!$samekeyword) $samekeyword = 1;
		$targeto = get_option('aal_target');
		$relationo = get_option('aal_relation');
		$langsupport = get_option('aal_langsupport');
		if($langsupport=='true') $langsupport = 'u'; else $langsupport = '';
		$excludearray = explode(',',$aal_exclude);
		$table_name = $wpdb->prefix . "automated_links";
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
		
		$clickbankid = get_option('aal_clickbankid');
		$clickbankcat = get_option('aal_clickbankcat');
		$clickbankgravity = get_option('aal_clickbankgravity');
		$clickbankactive = get_option('aal_clickbankactive');
		$amazonlocal = get_option('aal_amazonlocal');
		
		$amazonid = get_option('aal_amazonid');
		$amazonapikey = get_option('aal_amazonapikey'); 
		$amazonsecret = get_option('aal_amazonsecret'); 
		$amazoncat = get_option('aal_amazoncat');
		$amazonactive = get_option('aal_amazonactive');
		
		$shareasaleid = get_option('aal_shareasaleid');
		$shareasaleactive = get_option('aal_shareasaleactive');

		$cjactive = get_option('aal_cjactive');
		
		$ebayactive = get_option('aal_ebayactive');
		$ebayid = get_option('aal_ebayid');
		
		$bestbuyactive = get_option('aal_bestbuyactive');
		$bestbuyid = get_option('aal_bestbuyid');
		
		$walmartactive = get_option('aal_walmartactive');
		$walmartid = get_option('aal_walmartid');
		
		
		$apikey = trim(get_option('aal_apikey'));
		
		if($relationo=='nofollow') $relo = ' rel="nofollow" ';
		else $relo = '';
		
		//regular expression setup
		$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/ims'. $langsupport .'U';	
		$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))(?!(?:[^<\[]+[>\]]|[^>\]]+<\/h.>))\b($name)\b/ims'. $langsupport .'U';
		$strpos_fnc		=	 'stripos';		
		global $wp_rewrite; 
		global $post;


		$patterns = array();
		
		//If the post is set for exclusion, exit
		if(in_array($post->ID, $excludearray)) return $content;
				
		
		//Check the display settings
		if($post->post_type != 'post' && $post->post_type != 'page') return $content;
		if($displayo && $post->post_type!=$displayo) return $content;
		
		//Adjust the number of links added based on the post content length
		if(strlen($post->post_content)>8000) $notimes = $notimes * 4;
		else if(strlen($post->post_content)>4000) $notimes = $notimes * 3;
		else if(strlen($post->post_content)>2000) $notimes = $notimes * 2;		
		
		//echo $notimes;
		
			//Check to see if it is the homepage
			if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index.php') $ishome = 1; else $ishome=0;	
			//If it is home and ishome is set do none, then exit the function
			if($ishome && $showhome!='true') return $content;
		


		//If no keywords are set, exit the function
		if(!is_null($myrows)) {
		
		foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;
				
				
				if($link == get_permalink($post->ID) ) continue;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
						
					  if(stripos($content, $key) !== false) {	
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
							$replace[] = "<a title=\"$1\" class=\"". $lclass ."\" target=\"". $targeto ."\" ". $relo ." href=\"$url\">$1</a>";
							$regexp[] = str_replace('$name', $name, $reg);	


						}
					  }
						
						
					}
				}
		} //endforeach
		
		} //endif
		
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";

	//print_r($regexp);
			
				if(is_array($regexp)) { 
					
				
					$sofar = 0;
					foreach($regexp as $regnumber => $reg1) {
						
						$count = 0;
						if(stripos($content, $keys2[$regnumber]) !== false) { $content = preg_replace($reg1, $replace[$regnumber], $content,$samekeyword,$count);  }
						if($count>0) $sofar = $sofar + $count;
						if($sofar >= $notimes) break;
						
					
					}				
				
				}
				
	
		$timecounter = microtime(true);
		//echo $timecounter . "<br/>";	
				
				
				
				global $aal_apirequestno;
				if(!$aal_apirequestno) $aal_apirequestno = 0;
				//If the manual replacement did not found enough links
				if($aal_apirequestno < 3 ) if($sofar<$notimes && ($clickbankactive || $amazonactive || $shareasaleactive || $cjactive || $ebayactive || $bestbuyactive || $walmartactive )) {
					
					$aal_apirequestno = $aal_apirequestno + 1;
					
					if(!$clickbankactive) { $clickbankid = ''; }
					if(!$amazonactive) { $amazonid = ''; }
					if(!$shareasaleactive) { $shareasaleid = ''; }
					if(!$ebayactive) { $ebayid = ''; }
					if(!$bestbuyactive) { $bestbuyid = ''; }
					if(!$walmartactive) { $walmartid = ''; }

					
		$aaldivnumber = rand(1,10000);			
		
		// data-relation="'. $relo .'"
					
		$left = $notimes - $sofar;		

		
$aurl = get_permalink($post->ID);
		
$content = $content .= ' 
		
		<div id="aal_api_data" data-divnumber="'. $aaldivnumber .'" data-target="'. $targeto .'"  data-postid="post-'. $post->ID .'" data-apikey="'. $apikey .'" data-clickbankid="'. $clickbankid .'" data-clickbankcat="'. $clickbankcat .'" data-clickbankgravity="'. $clickbankgravity .'"  data-amazonid="'. $amazonid .'" data-amazoncat="'. $amazoncat .'" data-amazonlocal="'. $amazonlocal .'" data-amazonactive="'. $amazonactive .'" data-clickbankactive="'. $clickbankactive .'"  data-shareasaleid="'. $shareasaleid .'"   data-shareasaleactive="'. $shareasaleactive .'" data-cjactive="'. $cjactive .'"  data-ebayactive="'. $ebayactive .'"  data-ebayid="'. $ebayid .'"   data-bestbuyactive="'. $bestbuyactive .'"  data-bestbuyid="'. $bestbuyid .'" data-walmartactive="'. $walmartactive .'"  data-walmartid="'. $walmartid .'" data-aurl="'. $aurl .'" data-notimes="'. $left .'" data-apidata=\'{content:"'. urlencode($content) .'",apikey: "'. $apikey .'", clickbankid: "'. $clickbankid .'", clickbankcat: "'. $clickbankcat .'", clickbankgravity: "'. $clickbankgravity .'", amazonid: "'. $amazonid .'", amazoncat: "'. $amazoncat .'", amazonlocal: "'. $amazonlocal .'", amazonactive: "'. $amazonactive .'", clickbankactive: "'. $clickbankactive .'", shareasaleid: "'. $shareasaleid .'", shareasaleactive: "'. $shareasaleactive .'", cjactive: "'. $cjactive .'", ebayactive: "'. $ebayactive .'", ebayid: "'. $ebayid .'", bestbuyactive: "'. $bestbuyactive .'", bestbuyid: "'. $bestbuyid .'", walmartactive: "'. $walmartactive .'", walmartid: "'. $walmartid .'", aurl: "'. $aurl .'", notimes: "'. $left .'"}\' ></div>

		
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