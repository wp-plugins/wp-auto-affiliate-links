<?php

// Classes

global $aalModules; $aalModules = array();
$aalFiles = scandir(plugin_dir_path(__FILE__) . 'modules');
$aalModuleFiles = array();
foreach($aalFiles as $aalFile) {
	 if(substr($aalFile, -4)=='.php') { 
	 	$aalModuleFiles[] = $aalFile;  
		 include(plugin_dir_path(__FILE__) . 'modules/' . $aalFile); 
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
                
	To add modules, copy and paste the module file into /modules/ subdirectory in wp-auto-affiliate-links plugin folder. 
	<br /><br />
	Modules functionality to be added soon. You will be able to install modules to do different tasks. Modules are files built especially for this plugin, that can be added here. 

	Meanwhile, you can check <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Wp Auto Affiliate Links PRO</a> which is full featured and have all the modules already installed. 
 
	
	<?php
}


?>