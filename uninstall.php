<?php 
	 global $wpdb;
	 $table_name = $wpdb->prefix . "automated_links";
	 
	 delete_option('aal_showhome');
	 delete_option('aal_exclude');
	 delete_option('aal_notimes');
	 delete_option('aal_iscloacked');
	 delete_option('aal_target');
	 delete_option('aal_relation');
	
	$wpdb->query('DROP TABLE '.  $table_name .'');
	
?>