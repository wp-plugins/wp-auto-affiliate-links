<?php

function wpaal_stats() {
	global $wpdb;
	$myrows = $wpdb->get_results( "SELECT id,link,keywords,meta FROM ". $table_name );
	
	
?>

<div class="wrap" >  
    <div class="icon32" id="icon-options-general"></div>  
    <div class="aal_leftadmin">	
		<h2>Statistics</h2>
		
	</div>
</div>	
	

<?php
}
