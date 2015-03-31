<?php

function wpaal_generatedlinks() {
	global $wpdb; 
	
	




		//$data = file_get_contents('http://autoaffiliatelinks.com/api/getlinks.php?apikey='. get_option('aal_apikey') );
		//echo $data;
		$data = json_decode($data);


		$links = $data->links;
		$number = $data->number;
		$exposts = get_option('aal_exclude');
		$exarray = explode(',',$exposts);
		
	
		wp_enqueue_script( "generatedlinksjs", plugin_dir_url( __FILE__ ) . 'js/generatedlinks.js' );

?>

					<div id="aal_apikey" data-apikey="<?php echo get_option('aal_apikey'); ?>" ></div>               
                
                
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
<table id="aal_gltable" class="widefat fixed" >
	<thead>
		<tr>

		<th>
			Post link
		</th>
		<th>
			Keywords
		</th>
		<th>
			Exclusion
		</th>
		</tr>
	</thead>
	
	<tfoot>
		<tr>

		<th>
			Post link
		</th>
		<th>
			Keywords
		</th>
		<th>
			Exclusion
		</th>
		</tr>
	</tfoot>
	
	<tbody>
	
	
<?php 

//if(!$data) echo '<p style="font-weight: bold; color: #ff0000;">A server configuration prevents data to be loaded here. Your links are probably appearing on the site but we cannot fetch it here. We are working for a soltuion to this problem</p>';

$alternate = 0;
$postsadd = array();
if(is_array($links)) foreach($links as $link) { 

		$keywords = json_decode($link->keywords);
		//print_r($keys);
		$kwlist = '';
		foreach($keywords as $keyword) {
			
			$kwlist .= '<a href="'. $keyword->url .'">'. $keyword->key .'</a> ';		
		
		}
		
		$exclude = '';
		$exclude = url_to_postid( $link->url );

		if(!in_array($exclude,$postsadd)) { 		
		
		if(in_array($exclude,$exarray)) {
			
			$extext = "In this post links are not shown";		
		
		}
		else {
		
			$extext = "This posts show links";		
			
		}
		$postsadd[] = $exclude;

?>

	
	<tr class="<?php if($alternate % 2 == 0) echo 'alternate'; ?>" >
		<td>
			<a href="<?php echo $link->url; ?>"><?php echo $link->url; ?></a>
		</td>
		<td>
			<?php if(!$kwlist) echo 'No links generated for this post'; else echo $kwlist; ?>
		</td>
		<td>
			<?php echo $extext; ?><!-- <a href="javascript:;" onclick="return forceExclude(<?php echo $exclude; ?>)" >Exclude this post</a> -->
		</td>
	</tr>
<?php 
	$alternate++;
	}

} ?>             
             
                
     </tbody>
 </table>








	
<?php
}










?>