<?php

// Classes

global $aalModules; $aalModules = array();
$moduledir = plugin_dir_path(__FILE__) . 'modules';
$aalFiles = scandir($moduledir);
$aalModuleFiles = array();
foreach($aalFiles as $aalFile) {
	 if(substr($aalFile, -4)=='.php') { 
	 	$aalModuleFiles[] = $aalFile;  
		 include($moduledir .'/'. $aalFile); 
	 }
	 elseif (is_dir($moduledir . '/' . $aalFile) && $aalFile != '.' && $aalFile != '..') {   
	 	
	 	$subfiles = scandir($moduledir . '/' . $aalFile);
	 		if(file_exists($moduledir . '/' . $aalFile .'/' . $aalFile .'.php')) include($moduledir . '/' . $aalFile .'/' . $aalFile .'.php'); 
	 		elseif(file_exists($moduledir . '/' . $aalFile .'/index.php')) include($moduledir . '/' . $aalFile .'/index.php'); 
	 	
	 }
 }


//print_r($aalModuleFiles);


class aalModule
{
    var $shortname;
    var $nicename;
    var $hooks = array();


	function aalModule($shortname,$nicename) {
		
		$this->shortname = $shortname;
		$this->nicename = $nicename;

	}

	function aalModuleHook($hook,$fname) {
		
		$this->hooks[$hook] = $fname;
		
	}


}



function wpaal_modules() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";	
	

	
	?>
	
	
<div class="wrap">  
        <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Modules</h2>
                <br /><br /><br />
                
	To add modules, upload the module files into /modules/ subdirectory in wp-auto-affiliate-links/ plugin folder. Once they are uploaded, every module will create a link into the Wp Auto Affiliate Links top menu. 
	<br /><br />
	You can get more modules from <a href="http://autoaffiliatelinks.com">Auto Affiliate Links Modules</a>
	<br /><br />
	<h3>Active modules</h3>

	If a module is causing your problems, just delete the files trough ftp. 
 
	
	<?php
}


?>