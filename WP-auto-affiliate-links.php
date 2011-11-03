<?php
/*
Plugin Name: WP Auto Affiliate Links
Plugin URI: http://www.flamescorpion.com/wp-auto-affiliate-links/
Description: Auto add affiliate links to your blog content
Author: Lucian Apostol
Version: 2.1.1
Author URI: http://www.flamescorpion.com
*/

add_action('admin_init', 'wpaal_actions');
add_action('admin_menu', 'create_menu');
add_filter('the_content', 'add_affiliate_links');


function wpaal_actions() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";

	if($_GET['aal_action']=='delete') {

		check_admin_referer('WP-auto-affiliate-links_delete_link');

		$id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)); // $_GET['id'];

		$wpdb->query("DELETE FROM ". $table_name ." WHERE id = '". $id ."' LIMIT 1");

		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");


	}


	if($_POST['aal_sent']=='ok') {
			
			check_admin_referer('WP-auto-affiliate-links_add_link');

			
			$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
			$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];


		$rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords ) );

		

		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");

			
	}



	if($_POST['aal_edit']=='ok') {
			
			check_admin_referer('WP-auto-affiliate-links_edit_link');
			
			$id = filter_input(INPUT_POST, 'edit_id', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['id'];
			$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
			$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];


		// $rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords ) );

		$rows_affected = $wpdb->update( $table_name, array( 'link' => $link, 'keywords' => $keywords ), array( 'id' => $id ));

		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");

			
	}
	
	
	if($_POST['aal_settings_submit']) { 
	
		$showhome = filter_input(INPUT_POST, 'showhome', FILTER_SANITIZE_SPECIAL_CHARS);
		
		delete_option('aal_showhome');
		add_option( 'aal_showhome', $showhome);
	
		wp_redirect("options-general.php?page=WP-auto-affiliate-links.php");
	
	}




}



function create_menu() {

			add_options_page(__('Manage Affiliate Links', 'automated_affiliate_links'), __('Manage Affiliate Links', 'automated_affiliate_links')	, 10, basename(__FILE__), 'manage_affiliates' );

}


function manage_affiliates() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";



	$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );
	$showhome = get_option('aal_showhome');
	if($showhome) $shsel = 'checked'; else $shsel2 = 'checked';

	echo '<h1>Manage Affiliate Links</h1>
	<br /><br />
	<span style="color: red;">If you like this plugin, please donate to support the continued development. There are many features that are awaiting on line.</span>
	<br /><br />
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="RGNWD2T23VX2J">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

<br /><br />
<h3>General Options</h3>
<form name="aal_settings" id="" method="post">
Add links on homepage: <input type="radio" name="showhome" value="1" '. $shsel .'/> Yes <input type="radio" name="showhome" value="0" '. $shsel2 .'/> No <br />
<input type="hidden" name="aal_settings_submit" value="1" />
<input type="submit" value="Save" />
</form>
<br /><br />

	<br /><br />
	<p>After you add the affiliate links, make sure you write keywords in the respective field, separated by comma. If you don\'t enter any keyword, that link won\'t be displayed.</p>
	<p>After you hit save, all keywords entered found in the content will be replaced with the links to the affiliate page</p>
	<br /><br />

	<form name="add-link" method="post">';


if ( function_exists('wp_nonce_field') )
	wp_nonce_field('WP-auto-affiliate-links_add_link');

		echo '

		Affiliate link: <input type="text" name="link" value="http://" />
		Keywords: <input type="text" name="keywords" id="formkeywords" />
		<input type="submit" name="Save" />
		<input type="hidden" name="aal_sent" value="ok" />
	</form>
	<br />
	<br />
	Suggestions:
	<br />
	Here is a list with most used keywords in all your blog. Click on each and it will be added in the form above so you can assign a link for it.
	<br />
	';
	
	$searchposts  = get_posts(array('numberposts' => 5,  'post_type'  => 'post'));
	
	// print_r($searchposts);
	
	foreach($searchposts as $spost) {
	$wholestring .=  ' '. $spost->post_content;
	}
	
	$wholestring = strip_tags($wholestring);
	$wholestring = ereg_replace("[^A-Za-z0-9]", " ", $wholestring );
	$commonWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
	$wholestring = preg_replace('/\b('.implode('|',$commonWords).')\b/','',strtolower($wholestring));
	// echo $wholestring;
	
	$karray = explode(" ",strtolower($wholestring));
	
	//print_r($karray);
	$final=array(); $times=array();
	foreach($karray as $kws) {
		
		if(!in_array($kws,$final)) { 
			$final[] = $kws;
			$times[]=1;
		}
		else{
			foreach($final as $in => $test) {
				if($test==$kws) $times[$in]++;
			}
		}
	
	}	
	
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
	
	//print_r($final);
	//print_r($times);
	
	$final = array_slice($final, 0, 9);
	
	foreach($final as $fin) {
		if($fin!='' && $fin!=' ' && $fin!= '   ') {
			echo '<a href="javascript:;" onclick="document.getElementById(\'formkeywords\').value=\''. $fin .'\'">'. $fin .'</a>&nbsp;';
		}
	
	}
	
	
	echo '
	<br />
	<br />
	<h3>Affiliate Links:</h3>
	<ul>
		';

		foreach($myrows as $row) {
				
				$id = $row->id;
				$link = $row->link;
				$keywords = $row->keywords;

				$deletelink = '?page=WP-auto-affiliate-links.php&aal_action=delete&id='. $id;
				$deletelink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($deletelink, 'WP-auto-affiliate-links_delete_link') : $deletelink;

			//	echo '<li><b>Link:</b> '. $link .'   &nbsp;&nbsp;<b>Keywords:</b> '. $keywords .'  &nbsp;&nbsp; <a href="'. $deletelink .'">Delete</a></li>';
			?>
				<li style="">
				<form name="edit-link-<?php echo $id; ?>" method="post">

				<?php
					if ( function_exists('wp_nonce_field') )
						wp_nonce_field('WP-auto-affiliate-links_edit_link');
				?>
					
					Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="link" value="<?php echo $link; ?>" />
					Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="keywords" value="<?php echo $keywords; ?>" />
					<input style="margin: 5px 2px;" type="submit" name="ed" value="Edit" />
					<input value="<?php echo $id; ?>" name="edit_id" type="hidden" />
					<input type="hidden" name="aal_edit" value="ok" />
					<?php echo '<a onclick="alert(\'Are you sure you want to delete this automated link?\');" href="'. $deletelink .'">Delete</a></li>'; ?>
				</form>

				

			<?php
		}

		echo '
	</ul>

	
	';

//	print_r($myrows);
	
}



function add_affiliate_links($content) {
		global $wpdb;
		$showhome = get_option('aal_showhome');
		$table_name = $wpdb->prefix . "automated_links";
		$myrows = $wpdb->get_results( "SELECT id,link,keywords FROM ". $table_name );

				$patterns = array();

		if(is_null($myrows)) return $content;
		else foreach($myrows as $row) {
				
				$link = $row->link;
				$keywords = $row->keywords;

				if(!is_null($keywords)) {
					$keys = explode(',',$keywords);

					foreach($keys as $key) {
		
						$key = trim($key);
 
						if(!in_array('/'. $key .'/', $patterns)) { 

							$reg_post		=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))($name)/imsU';	
							$reg			=	 '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
							$strpos_fnc		=	 'stripos';
								
							//$url = 'http://www.zipr.com';
							$url = $link;
							//$name = 'zip';
							$name = $key;
							
							$replace[] = "<a title=\"$1\" target=\"_blank\" href=\"$url\">$1</a>";
							$regexp[] = str_replace('$name', $name, $reg);	


						}

					}


				}

		}

		// print_r($patterns);




	//	$content = preg_replace($patterns, $replacements, $content);

	//	$content = preg_replace('/<a(.*?)><a(.*?)>(.*?)a>(.*?)a>/', '<a$1>$3a>' ,$content);


		//wp_reset_query();
		//print_r(is_home()); die();
		if(is_array($regexp)) { if($_SERVER['REQUEST_URI']=='/' || $_SERVER['REQUEST_URI']=='/index.php') $ishome = 1; else $ishome=0;
	if(!$ishome) $content = preg_replace($regexp, $replace, $content);	
	else if($showhome) if($regexp[0]) $content = preg_replace($regexp, $replace, $content);	 }
		
		
	//	$content = preg_replace('/<(.*?)<a(.*?)>(.*?)<(.*?)a>(.*?)>/', '<$1$3$5>' ,$content);

				

		return $content;


}







// Installation

register_activation_hook(__FILE__,'aal_install');


function aal_install() {
	global $wpdb;
	$table_name = $wpdb->prefix . "automated_links";

	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {


		$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  link text NOT NULL,
	  keywords text,
	  UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);

	}

}
