<?php
/*
Plugin Name: WP Auto Affiliate Links
Plugin URI: http://autoaffiliatelinks.com
Description: Auto add affiliate links to your blog content
Author: Lucian Apostol
Version: 3.6
Author URI: http://autoaffiliatelinks.com
*/



// Classes

global $aalModules; $aalModules = array();
$aalFiles = scandir(plugin_dir_path(__FILE__) . 'modules');
$aalModuleFiles = array();
foreach($aalFiles as $aalFile) { if(substr($aalFile, -4)=='.php') { $aalModuleFiles[] = $aalFile;  include(plugin_dir_path(__FILE__) . 'modules/' . $aalFile); } }


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



//functions used in plugin



//Load css stylesheets
function aal_load_css() {
	
        //load css styles
        wp_register_style( 'tabs', plugins_url('css/tabs.css', __FILE__) );
        wp_enqueue_style('tabs');


}

//load javascript files
function aal_load_js() {
	
        // load our jquery file that sends the $.post request
	wp_enqueue_script( "js", plugin_dir_url( __FILE__ ) . 'js/js.js', array( 'jquery' ) );
	//wp_enqueue_script( "tabs", plugin_dir_url( __FILE__ ) . 'js/jquery.tools.min.js', array( 'jquery' ) );
        
        $aal_plugin_url=plugin_dir_url(__FILE__);
        
        // make the ajaxurl var available to the above script
	wp_localize_script( 'js', 'ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php'),'aal_plugin_url' =>$aal_plugin_url  ) );	
        
}

//Delete link button (called by ajax)
function aalDeleteLink(){
    
            if(isset($_POST['id'])){
                global $wpdb;
                $table_name = $wpdb->prefix . "automated_links";
                
                //Security check and input sanitize
		$id = intval(filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS)); // $_GET['id'];
		
		//Add to database and redirect to the plugin default page
		$wpdb->query("DELETE FROM ". $table_name ." WHERE id = '". $id ."' LIMIT 1");
                
                die();
            }
}

//Change General setings through ajax 
function aalChangeOptions(){	
		//Input check
		$aal_showhome = filter_input(INPUT_POST, 'aal_showhome', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_notimes = filter_input(INPUT_POST, 'aal_notimes', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_exclude = filter_input(INPUT_POST, 'aal_exclude', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_iscloacked = filter_input(INPUT_POST, 'aal_iscloacked', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_targeto = filter_input(INPUT_POST, 'aal_target', FILTER_SANITIZE_SPECIAL_CHARS);
		$aal_relationo = filter_input(INPUT_POST, 'aal_relation', FILTER_SANITIZE_SPECIAL_CHARS);
		
		//Delete the settings and re-add them		
                delete_option('aal_iscloacked'); add_option( 'aal_iscloacked', $aal_iscloacked);		
		delete_option('aal_showhome'); add_option( 'aal_showhome', $aal_showhome);		
		delete_option('aal_notimes'); add_option( 'aal_notimes', $aal_notimes);				
		delete_option('aal_exclude'); add_option( 'aal_exclude', $aal_exclude);		
		delete_option('aal_target'); add_option( 'aal_target', $aal_targeto);
		delete_option('aal_relation'); add_option( 'aal_relation', $aal_relationo);
                
           die();
}

function aalUpdateExcludePosts(){
            
    //$update_exclude_posts= filter_input(INPUT_POST, 'aal_exclude_posts', FILTER_SANITIZE_SPECIAL_CHARS);
    $update_exclude_posts=  $_POST['aal_exclude_posts'];
    $update_exclude_posts=  implode(',', $update_exclude_posts);
    $update_exclude_posts=mysql_real_escape_string(htmlentities($update_exclude_posts));
    delete_option('aal_exclude');add_option( 'aal_exclude', $update_exclude_posts);

    
    die();
}

function aalAddExcludePost(){
            
                $aal_exclude_id= filter_input(INPUT_POST, 'aal_post', FILTER_SANITIZE_SPECIAL_CHARS);
                $aal_posts =get_option('aal_exclude');
                
                $post = get_post($aal_exclude_id);
                $data['post_title'] = $post->post_title;
                if(!$post->ID) {
                die('nopost');
					}
               
                
                if($aal_posts=='')$aal_exclude=$aal_exclude_id;
                    else $aal_exclude=$aal_posts.",".$aal_exclude_id;
                    
                 
                delete_option('aal_exclude');add_option( 'aal_exclude', $aal_exclude);
                echo " <a href='".get_permalink($post->ID)."'>".get_the_title($post->ID)."</a>  -  ". get_post_status($post->ID) ."                            ";
                
                 
                die();
}


//Add link form (called by ajax)
function aalAddLink(){
    
            	global $wpdb;
                $table_name = $wpdb->prefix . "automated_links";
     	
		// Security check and sanitize	
		$aal_link = filter_input(INPUT_POST, 'aal_link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
		$aal_keywords = filter_input(INPUT_POST, 'aal_keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];
		
		$check = $wpdb->get_results( "SELECT * FROM ". $table_name ." WHERE link = '". $aal_link ."' " );		
		
		// Add to database 
		if($check) { 
				$wpdb->update( $table_name, array( 'keywords' => $check[0]->keywords .','. $aal_keywords), array( 'link' => $aal_link ) );
				$aal_delete_id=$check[0]->id;
			}
		else {
			$rows_affected = $wpdb->insert( $table_name, array( 'link' => $aal_link, 'keywords' => $aal_keywords ) );
			$aal_delete_id=$wpdb->insert_id;
		}
        
                
                
                $aal_json=array('aal_delete_id'=>$aal_delete_id);
                
                echo json_encode($aal_json);
                
                die();
}

//Get list of link showed on Add Affiliate Links tab

function aalGetLinks($myrows){
         foreach($myrows as $row) {

                                    $aal_id = $row->id;
                                    $aal_link = $row->link;
                                    $aal_keywords = $row->keywords;

                                    ?>
                                        <form name="edit-link-<?php echo $id; ?>" method="post">
                                        <input value="<?php echo $id; ?>" name="edit_id" type="hidden" />
                                        <input type="hidden" name="aal_edit" value="ok" />
                                                
                                        <?php
                                        if ( function_exists('wp_nonce_field') )
                                                wp_nonce_field('WP-auto-affiliate-links_edit_link');
                                        ?>
                                            <li style="" class="aal_links_box">
                                                Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="aal_link" value="<?php echo $aal_link; ?>" />
                                                Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="aal_keywords" value="<?php echo $aal_keywords; ?>" />
                                                <input style="margin: 5px 2px;" type="submit" name="ed" value="Edit" />
                                                <a href="#" id="<?php echo $aal_id; ?>" class="aalDeleteLink"><img src="<?php echo plugin_dir_url(__FILE__);?>images/delete.png"/></a>
                                            </li>    
                                        </form>

                                            
                          <?php } 
}

//Get keyoword sugestions for Add Afiliates Link Tab

function aalGetSugestions($myrows){
	
		$alllinks = array();
		foreach($myrows as $row) { 
			$keys = explode(',',$row->keywords);
			foreach($keys as $key) {
			
				$alllinks[] = trim($key);	
				
			}
			
		
		}
		
		//print_r($alllinks);
    
        //Search trough your post to generate reccomend most used keywords
        $searchposts  = get_posts(array('numberposts' => 5,  'post_type'  => 'post'));
        foreach($searchposts as $spost) {
                $wholestring .=  ' '. $spost->post_content;
        }

        $wholestring = strip_tags($wholestring);
        $wholestring = ereg_replace("[^A-Za-z0-9]", " ", $wholestring );

        //Common words to exclude 
        $commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');

        //Do the replace
        $wholestring = preg_replace('/\b('.implode('|',$commonWords).')\b/','',strtolower($wholestring));

        //Turning the string into an array
        $karray = explode(" ",strtolower($wholestring));

        //Coountin how many times each keyword appear
        $final=array(); $times=array();
        foreach($karray as $kws) {

                if(!in_array($kws,$final)) if(!in_array($kws,$alllinks)) { 
                        $final[] = $kws;
                        $times[]=1;
                }
                else{
                        foreach($final as $in => $test) {
                                if($test==$kws) $times[$in]++;
                        }
                }

        }	

        //Sorting the array
        $length = count($final);
        $sw=1;
        while($sw!=0) {
                $sw=0;
                for($i=0;$i<$length-1;$i++) {
                        if($times[$i]<$times[$i+1]) {
                                $aux = $final[$i];
                                $final[$i] = $final[$i+1];
                                $final[$i+1] = $aux;
                                $aux = $times[$i];
                                $times[$i] = $times[$i+1];
                                $times[$i+1] = $aux;
                                $sw=1;

                        }
                }
        }
		$extended = array_slice($final, 0, 100);
        //Taking only the most used 20 keywords and displaying them
        $final = array_slice($final, 0, 19);
       /*  foreach($final as $fin) {
                if($fin!='' && $fin!=' ' && $fin!= '   ') {
                        echo '<a href="javascript:;" onclick="document.getElementById(\'aal_formkeywords\').value=\''. $fin .'\'">'. $fin .'</a>&nbsp;';
                }

        } */
        echo '   <a href="javascript:;" id="aal_moresug" >Show suggestions >></a>
        <div id="aal_extended" style="padding: 20px;">';
        	
         foreach($extended as $fin) {
                if($fin!='' && $fin!=' ' && $fin!= '   ') {
                        echo $fin .'&nbsp;&nbsp;&nbsp;<span><a class="aal_sugkey" href="javascript:;"  title="'. $fin .'">Add >> </a></span><br />';
                }
                
             }       
        	
        
        echo '
        </div>
        
<script type="text/javascript">


jQuery(".aal_sugkey").click(function() { 
 		if(jQuery("#aal_formkeywords").val())  {
 				jQuery("#aal_formkeywords").val(jQuery("#aal_formkeywords").val() + ", " + jQuery(this).attr("title"));
 			}
 			else { 
 				jQuery("#aal_formkeywords").val(jQuery(this).attr("title"));
 		}
 		jQuery(this).hide();
});


jQuery("#aal_moresug").click(function() {
 		jQuery("#aal_extended").toggle();
});


</script>        
        
        
        
        ';        
        
        
        
        
}

//Installation of plugin
function aal_install() {
	global $wpdb; 
	$table_name = $wpdb->prefix . "automated_links";
	

	//if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {

	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  link text NOT NULL,
	  keywords text,
	  meta text,
	  medium varchar(255),
	  grup int(5),
	  grup_desc varchar(255),
	  UNIQUE KEY id (id)
	);";
    
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
	
}






//require "aal_functions.php";

add_action('admin_init', 'wpaal_actions');
add_action('admin_menu', 'wpaal_create_menu');
add_filter('the_content', 'wpaal_add_affiliate_links');
add_action('init', 'wpaal_rewrite_rules');
add_action('query_vars', 'wpaal_add_query_var');
add_action('wp','wpaal_check_for_goto');
add_action('wp_print_scripts', 'aal_load_css');
add_action('wp_print_scripts', 'aal_load_js');
add_action('wp_ajax_aal_delete_link', 'aalDeleteLink');
add_action('wp_ajax_aal_add_link', 'aalAddLink');
add_action('wp_ajax_aal_change_options', 'aalChangeOptions');
add_action('wp_ajax_aal_add_exclude_posts', 'aalAddExcludePost');
add_action('wp_ajax_aal_update_exclude_posts', 'aalUpdateExcludePosts');

//add_action('wp_ajax_exclude_posts', 'aalExcludePosts');





// Add Wp Auto Affiliate Links to Wordpress Admnistration panel menu
function wpaal_create_menu() {

add_menu_page( 'Auto Affiliate Links', 'Wp Auto Affiliate Links', 'publish_pages', 'aal_topmenu', 'wpaal_manage_affiliates', $icon_url, $position );	
add_submenu_page( 'aal_topmenu', 'General Settings', 'General Settings', 'publish_pages', 'aal_general_settings', 'wpaal_general_settings' );

}

function wpaal_actions() {
    
        global $wpdb;
        $table_name = $wpdb->prefix . "automated_links";
                

	//Check if a keyword was edited
	if($_POST['aal_edit']=='ok') {
			
		//Security and input check
		check_admin_referer('WP-auto-affiliate-links_edit_link');		
		$id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['id'];
		$link = filter_input(INPUT_POST, 'aal_link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
		$keywords = filter_input(INPUT_POST, 'aal_keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];

		//Update the database and redirect
		$rows_affected = $wpdb->update( $table_name, array( 'link' => $link, 'keywords' => $keywords ), array( 'id' => $id ));
		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");

			
	}
	
	

	
	
	
	if($_POST['aal_export_check']) {				
		
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
		$separator = $_POST['aal_export_separator'];
		if($separator=='tab') $separator = "\t";
		if(!$separator) $separator = "|";
		//$separator = "|";
		
		$File = 'aal_export.txt';
header("Content-Disposition: attachment; filename=\"" . basename($File) . "\"");
header('Content-type: text/plain');
header("Connection: close");
		
foreach($myrows as $row) {

	echo $row->keywords . $separator . $row->link . "\n";

}
		
		die();
		
		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");	
	}
	
	

}  // wpaal_actions end


function wpaal_general_settings() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";	
	

        
        $iscloacked = get_option('aal_iscloacked');
	if($iscloacked=='true') $isc = 'checked'; else $isc = '';
        
	$showhome = get_option('aal_showhome');
        if($showhome=='true') $shse = 'checked'; else $shsel = '';
        
	$notimes = get_option('aal_notimes');
        
	$targeto = get_option('aal_target');
	if($targeto=="_blank") $tsc1 = 'checked'; else $tsc2 = 'checked';
	
        
        $relationo = get_option('aal_relation');
	if($relationo=="nofollow") $rsc1 = 'checked'; else $rsc2 = 'checked';	
	
	?>
	
                <h1>General Settings</h1>
                <div>
                <form name="aal_settings" id="aal_changeOptions" method="post">
                    <b>Cloak links:</b> <input type="checkbox" name="aal_iscloacked" id="aal_iscloacked"  <?php echo $isc;?> /> (Disable this if the cloaked links are not working for you)<br /><br />
                    
                    <b>Add links on homepage:</b> <input type="checkbox" name="showhome" id="aal_showhome" <?php echo $shse;?> /> <br /><br />
                    
                    <b>Target:</b> <input type="radio" name="aal_target" value="_blank" <?php echo $tsc1;?> /> New window <input type="radio" name="aal_target" value="_self" <?php echo $tsc2 ;?>/> Same Window <br /><br />
                    
                    <b>How many times every keyword should appear on a post ( max ):</b> <input type="text" name="notimes" id="aal_notimes" value="<?php echo $notimes ;?>" size="1" /><br /><br />
                    <?php //echo $relationo; ?>
                    <b>Relation:</b> <input type="radio" name="aal_relation" value="nofollow" <?php echo $rsc1; ?> /> Nofollow <input type="radio" name="aal_relation" value="dofollow" <?php echo $rsc2 ;?>/> Dofollow <br /><br /><br />
                    <input type="submit" value="Save" />
                </form>
                <span class="aal_add_link_status"> </span>	
				</div>
	
	
	<?php
}




//Function that will render the administration page
function wpaal_manage_affiliates() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";


	//Load the keywords and options
	$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
	
        
        $excludeposts = get_option('aal_exclude');
        
	
	//Render the page
        ?>
        <h1>Manage Affiliate Links</h1>
	<br /><br />
	<div class="updated" style="text-align:center;padding: 10px;"><a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Wp Auto Affiliate Links PRO 2.0 </a> has been released. The PRO version will automatically display links from amazon, clickbank, shareasale and comission junction. Yout only have to setup and activate your prefered networks and links will be extracted automatically. <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Find out more</a>.</div>
	<br /><br />
	<!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="RGNWD2T23VX2J">
	<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>
	<br /><br /> -->
        

<script type="text/javascript">
function hideAllTabs(panelName) {

	 jQuery('.aal_panes').children().hide();
	 jQuery("div#" + panelName).show();
	document.location.hash = '#' + panelName;


}
</script>
        	
        <ul class="aal_tabs" id="aal_tabs">
   <li><a href="javascript:;" title="Add Affiliate Links" onclick="hideAllTabs('aal_panel3');" >Add Affiliate Links</a></li>
               <!-- <li><a href="javascript:;" title="General Settings" onclick="hideAllTabs('aal_panel1');  ">General Settings</a></li> -->
                <li><a href="javascript:;" title="Exclude posts" onclick="hideAllTabs('aal_panel2');" >Exclude posts</a></li>
 		 <li><a href="javascript:;" title="Modules" onclick="hideAllTabs('aal_panel31');" >Modules</a></li>
                
		<li><a href="javascript:;" title="Import" onclick="hideAllTabs('aal_panel4');" >Import</a></li>
		<li><a href="javascript:;" title="Export" onclick="hideAllTabs('aal_panel5');" >Export</a></li>
		<?php global $aalModules;
		foreach($aalModules as $aalMod) {
		
			?>
				<li><a href="javascript:;" title="<?php echo $aalMod->nicename; ?>" onclick="hideAllTabs('<?php echo $aalMod->shortname; ?>Tab');" ><?php echo $aalMod->nicename; ?></a></li>


			<?
		

		}

		?>
                                            
        </ul>

        <!-- tab "panes" -->
        <div class="aal_panes">



		<?php global $aalModules;
		foreach($aalModules as $aalMod) {
		
			?>

			<div id="<?php echo $aalMod->shortname; ?>Tab">
				<br />
                <h3><?php echo $aalMod->nicename; ?></h3>
				<br />
				<br />
				<? echo call_user_func($aalMod->hooks['content']); ?>



			</div>

			<?
		

		}

		?>






            <div id="aal_panel1">

            </div>
            
            <div id="aal_panel2">
                
                <h3>Exclude posts</h3>
                <form name="aal_add_exclude_posts_form" id="aal_add_exclude_posts_form" method="post">
                    <b>Enter post ID </b>:
                    <input type="text" name="aal_exclude_post_id" id="aal_add_exclude_post_id"  size="10" />
                    <input type="submit" value="Exclude Post"/>
                </form>
                
                <p>Excluded Posts ID's</p>
                <form class="aal_exclude_posts">
                <?php 
                $aal_exclude_posts=get_option('aal_exclude');
                $aal_exclude_posts_array=explode(',', $aal_exclude_posts);
                
                foreach ($aal_exclude_posts_array as $aal_exclude_post_id)
                  if($aal_exclude_post_id!='') { 
						$exclude_title = get_the_title($aal_exclude_post_id);
						if(!$exclude_title) $status = 'post with the given id does not exist';
							else $status = get_post_status($aal_exclude_post_id);
						
				  
                    echo "<span>
                            Post ID: <input type='text' name='aal_exclude_posts' class='all_exclude_post_item' value='".$aal_exclude_post_id."'/> <a href='".get_permalink($aal_exclude_post_id)."'>".get_the_title($aal_exclude_post_id)."</a>  -  ". $status ."                            <a href='javascript:' id='".$aal_exclude_post_id."' class='aal_delete_exclude_link'><img src='".plugin_dir_url(__FILE__)."images/delete.png'/></a><br/>
                          </span>";
					
				}
               
                
                ?>
                </form>
                
                <span class="aal_exclude_status"> </span>
            </div>
            
            <div id="aal_panel3">
                    <p>After you add the affiliate links, make sure you write keywords in the respective field, separated by comma. If you don\'t enter any keyword, that link won\'t be displayed.</p>
                    <p>After you hit save, all keywords entered found in the content will be replaced with the links to the affiliate page</p>


                    <form name="add-link" method="post" action="<?php echo admin_url( "admin-ajax.php");?>" id="aal_add_new_link_form">
                        <input type="hidden" name="action" value="add_link" />
                        Affiliate link: <input type="text" name="link" value="http://" id="aal_formlink" />
                        Keywords: <input type="text" name="aal_keywords" id="aal_formkeywords" />
                        <input type="submit" name="Save" />
                    </form>
                    
                    <br/>Here is a list with most used keywords in all your blog. Click on each and it will be added in the form above so you can assign a link for it.<br />
                                <?php aalGetSugestions($myrows);?>
                    
                    <h3>Affiliate Links:</h3>

                    <ul class="aal_links">

                         <?php aalGetLinks($myrows); // Showing existent affiliate links with edit and delete options ?>


                    </ul>
            </div>

	 <div id="aal_panel31">


	<h3>Modules</h3>
	<br />
	<br />
	To add modules, copy and paste the module file into /modules/ subdirectory in wp-auto-affiliate-links plugin folder. 
	<br /><br />
	Modules functionality to be added soon. You will be able to install modules to do different tasks. Modules are files built especially for this plugin, that can be added here. 

	Meanwhile, you can check <a href="http://autoaffiliatelinks.com/wp-auto-affiliate-links-pro/">Wp Auto Affiliate Links PRO</a> which is full featured and have all the modules already installed. 



	</div>
			
			
			<div id="aal_panel4">
				<br />
				<h3>Import Links</h3>
				<br />
				<br />
				Upload your datafeed. The format should be keyword,url. The separator is the character who separate the columns, it can be a comma ( , ), a vertical bar ( | ) or a tab ( exactly 4 spaces ). For tab, just write "tab" in the text field. If you don't know, open the feed file in notepad or any other simple text editor. You can edit your datafeed in Microsoft Excell or Libre Office Calc. Make sure you save the file in csv format ( not in xls or odt ). Upon saving, you can select the separator. All the links inside the datafeed will be added to your affiliate links. 
				<br />
				<br />
				
				
			<form name="aal_import_form" method="post" enctype="multipart/form-data" onsubmit="">
			Upload the file here:    <input name="aal_import_file" type="file" /><br />
			Separator: <select name="aal_import_separator" onchange="if(document.aal_import_form.aal_import_separator.options[document.aal_import_form.aal_import_separator.selectedIndex].value == 'other') document.aal_import_form.aal_import_other.style.display = 'block'; else document.aal_import_form.aal_import_other.style.display = 'none';">
			<option value="|">| ( vertical line )</option>
			<option value="tab">Tab</option>
			<option value=",">, ( comma )</option>
			<option value=";">; ( semicolon )</option>
			<option value=".">. ( dot )</option>
			<option value="other">other ( specify below )</option>
			</select>
			<br /><input type="text" name="aal_import_other" value="|" style="display: none;"/>
			<br />
			<input type="submit" value="Import" /><input type="hidden" name="MAX_FILE_SIZE" value="10000000" /><input type="hidden" name="aal_import_check" value="1" />
			</form>
				
				
				
			</div>
			
			
			
			
			<div id="aal_panel5">
				<br />
				<h3>Export Links</h3>
				<br />
				<br />
				Here you can export your links so you can import to another blog or to make a backup. You can import this file later using the "Import" tab.
				<br />
				<br />
				
				
			<form name="aal_export_form" method="post" enctype="multipart/form-data" onsubmit="">
			Separator: <select name="aal_export_separator">
			<option value="|">| ( vertical line )</option>
			<option value="tab">Tab</option>
			<option value=",">, ( comma )</option>
			<option value=";">; ( semicolon )</option>
			<option value=".">. ( dot )</option>
			</select>
			<input type="submit" value="Click here to export your links" /><input type="hidden" name="aal_export_check" value="1" />
			</form>
				
				
				
			</div>
            
     </div>
        


 <?php  }  // manage_affliates end

// The function that will actually add links when the post content is rendered
function wpaal_add_affiliate_links($content) {
		global $wpdb;
		
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
		
		if($relationo=='nofollow') $relo = ' rel="nofollow" ';
		else $relo = '';

		$patterns = array();

		//If no keywords are set, exit the function
		if(is_null($myrows)) return $content;
		
		else foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
 						if($key) if(!in_array('/'. $key .'/', $patterns)) { 

							//regular expression setup
							$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	
							$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
							$strpos_fnc		=	 'stripos';
								
								
							$redid = $row->id;
							if($iscloacked=='true')  {
								
							global $wp_rewrite; // echo $wp_rewrite->permalink_structure;
							if($wp_rewrite->permalink_structure) $link = get_option( 'home' ) . "/goto/" . $redid . "/" . wpaal_generateSlug($key);
							else $link = get_option( 'home' ) . "/?goto=" . $redid;	
								
								
								} //$link = get_option( 'home' ) . "/goto/" . wpaal_generateSlug($key);
							$url = $link;
							$name = $key;
							
							
							$replace[] = "<a title=\"$1\" class=\"aal\" target=\"". $targeto ."\" ". $relo ." href=\"$url\">$1</a>";
							$regexp[] = str_replace('$name', $name, $reg);	


						}
					}
				}
		}

		global $post;

		//Check if the post is set for exclusion and do nothing
		if(in_array($post->ID, $excludearray)) { }
		else {
			//Check to see if it is the homepage
			if(is_array($regexp)) { if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index.php') $ishome = 1; else $ishome=0;
			
			if(!$ishome) $content = preg_replace($regexp, $replace, $content,$notimes);	
				else if($showhome=='true') if($regexp[0]) $content = preg_replace($regexp, $replace, $content,$notimes);	 }
		}				
		return $content;


}  // add_affiliate_links end

// Contribution of Jos Steenbergen
// Rewrite engine for links

function wpaal_rewrite_rules() {
		add_rewrite_tag('%goto%','([^&]+)');
                add_rewrite_rule( 'goto/?([^/]*)', 'index.php?goto=$matches[1]', 'top');
       }
       
function wpaal_add_query_var($vars)  { 
       $vars[] = 'goto';
       return $vars;
       }
       
       
       

function wpaal_generateSlug($phrase)
{
       $maxLength = 45;
       $result = strtolower($phrase);

       $result = preg_replace("/[^a-z0-9\s-]/", "", $result);
       $result = trim(preg_replace("/[\s-]+/", " ", $result));
       $result = trim(substr($result, 0, $maxLength));
       $result = preg_replace("/\s/", "-", $result);

       return $result;
}


function wpaal_check_for_goto() { 
       global $wpdb;
       global $wp_query;

	   
	   //echo $wp_query->query_vars['goto'];
       if(isset($wp_query->query_vars['goto'])) {
       //echo $wp_query->query_vars['goto'];
       //echo 'having goto';
	  // die();


       $table_name = $wpdb->prefix . "automated_links";
              // $myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );

 			
				global $wp_rewrite;// echo $wp_rewrite->permalink_structure;
				// echo $wp_query->query_vars['goto']; die();
				if($wp_query->query_vars['goto'] && is_numeric($wp_query->query_vars['goto'])) { 

					$rerow = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name ." WHERE id='". $wp_query->query_vars['goto'] ."'  ");
					//print_r($rerow);
					if($rerow[0]->link) wp_redirect( $rerow[0]->link, 302 );
					 
				}

               //print_r($patterns);
               //print_r($redirect_link);

               //die();
               }
       //print_r($array = $GLOBALS['wp_query']->query_vars);


}


function aal_admin_notice() {
	
	$aal_notice_dismissed = get_option('aal_option_dismissed'); 
	if(!$aal_notice_dismissed)
	{
    ?>
    <div id="aal_notice_div" class="updated">
        <p align="center"><?php _e( '<a href="http://autoaffiliatelinks.com/our-products/wp-auto-affiliate-links-pro/">Wo Auto Affiliate Links PRO 2.0</a> has been released. Affiliate Links can be automatically extracted from Amazon, Clickbank, Shareasale, commission junction and to be automatically displayed in your content. Check it out <a href="http://autoaffiliatelinks.com/our-products/wp-auto-affiliate-links-pro/"> here</a>. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="return aalDismiss();" >Dismiss this notice</a>', 'wp-auto-affiliate-links' ); ?></p>
    </div>
    
<script type="text/javascript">
	function aalDismiss() {


        var data = {action: 'aal_dismiss_notice'};
        
            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){
                    jQuery("#aal_notice_div").slideUp('slow', function() {jQuery("#aal_notice_div").remove();});
                                        }
                });
        	
		
		
	}

</script>    
    
    
    <?php
	}
	
}


function aalDismissNotice() {

		add_option('aal_option_dismissed',true);
	
	
}


add_action( 'admin_notices', 'aal_admin_notice' );
add_action('wp_ajax_aal_dismiss_notice', 'aalDismissNotice');




// Installation

register_activation_hook(__FILE__,'aal_install');

?>
