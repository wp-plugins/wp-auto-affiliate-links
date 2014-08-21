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
<table class="widefat fixed" >
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

$postsadd = array();
foreach($links as $link) { 

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

	
	<tr>
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
	}

} ?>             
             
                
     </tbody>
 </table>








	
<?php
}










?>