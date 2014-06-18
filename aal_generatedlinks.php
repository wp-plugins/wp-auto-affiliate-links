<?php


function wpaal_generatedlinks() {
	global $wpdb; 
	
	




		$data = file_get_contents('http://autoaffiliatelinks.com/api/getlinks.php?apikey='. get_option('aal_apikey') );
		$data = json_decode($data);


		$links = $data->links;
		$number = $data->number;
		$exposts = get_option('aal_exclude');
		$exarray = explode(',',$exposts);
		
	
	
	
	
?>

                
                <script type="text/javascript">
						function forceExclude(postid) { 
						
							//document.aal_add_exclude_posts_form.aal_exclude_post_id.value = postid;
						
						
						}               
                
                </script>


<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Generated Links</h2>
                <br /><br />
             <p>Links here will not appear right away. Someone has to access a post first before he gets linked. Then the links will be shown here too. This requires you to activate PRO features.</p>
             <br /><br />
             
             
<br />
<div class="aal_link_list">
	<div class="aal_link_item">

		<div class="aal_post_link">
			Post link
		</div>
		<div class="aal_key_link">
			Keywords
		</div>
		<div class="aal_exclude_link">
			Exclusion
		</div>
	</div>	
<?php foreach($links as $link) { 

		$keywords = json_decode($link->keywords);
		//print_r($keys);
		$kwlist = '';
		foreach($keywords as $keyword) {
			
			$kwlist .= '<a href="'. $keyword->url .'">'. $keyword->key .'</a> ';		
		
		}
		
		$exclude = '';
		$exclude = url_to_postid( $link->url );
		if(in_array($exclude,$exarray)) {
			
			$extext = "In this post links are not shown";		
		
		}
		else {
		
			$extext = "This posts show links";		
			
		}

?>

	<div style="clear: both; "></div>
	
	<div class="aal_link_item">
		<div class="aal_post_link">
			<a href="<?php echo $link->url; ?>"><?php echo $link->url; ?></a>
		</div>
		<div class="aal_key_link">
			<?php echo $kwlist; ?>
		</div>
		<div class="aal_exclude_link">
			<?php echo $extext; ?><!-- <a href="javascript:;" onclick="return forceExclude(<?php echo $exclude; ?>)" >Exclude this post</a> -->
		</div>
	</div>
	<div style="clear: both; "></div>
<?php } ?>             
             
                
                
 </div>








	
<?php
}










?>