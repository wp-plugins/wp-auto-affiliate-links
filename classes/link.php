<?php


class AalLink
{
	var $id;
    var $link;
    var $keywords;
    var $medium;
    var $hooks = array();


	function AalLink($id = '',$link,$keywords,$medium) {
		
		$this->id = $id;
		$this->link = $link;
		$this->keywords = $keywords;
		$this->medium = $medium;

	}
	
	function showAll($medium = '') {
			global $wpdb;
			$table_name = $wpdb->prefix . "automated_links";	
			$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name );

        	 foreach($myrows as $row) {

				$link = new AalLink($row->id,$row->link,$row->keywords,$row->medium);
				$link->display();
            
             } 	
		
	}	
	
	

	function display() {
		
 		?>
            <form name="edit-link-<?php echo $this->id; ?>" method="post">
                  <input value="<?php echo $this->id; ?>" name="edit_id" type="hidden" />
                  <input type="hidden" name="aal_edit" value="ok" />
                                                
                  <?php
                  if (function_exists('wp_nonce_field')) wp_nonce_field('WP-auto-affiliate-links_edit_link');
                  ?>
                  <li style="" class="aal_links_box">
                       Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="aal_link" value="<?php echo $this->link; ?>" />
                       Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="aal_keywords" value="<?php echo $this->keywords; ?>" />
                       <input style="margin: 5px 2px;" type="submit" name="ed" value="Edit" />
                        <a href="#" id="<?php echo $this->id; ?>" class="aalDeleteLink"><img src="<?php echo plugin_dir_url(__FILE__);?>../images/delete.png"/></a>
                  </li>    
</form>

                                            
         <?php		
		
		
	}

}


function aalGetLink($id) {
	
		if(!$id) return false;	
		global $wpdb;
		$table_name = $wpdb->prefix . "automated_links";	
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name ." WHERE id='". $id ."' ");
		
		$link = AalLink($id,$link,$keyword,$medium);
	
	
}

function aalGetLinkByUrl($url) {
		
		if(!$url) return false;
		global $wpdb;
		$table_name = $wpdb->prefix . "automated_links";	
		$myrows = $wpdb->get_results( "SELECT * FROM ". $table_name ." WHERE link='". $url ."' ");
		
		$link = AalLink($id,$link,$keyword,$medium);
	
	
}


?>