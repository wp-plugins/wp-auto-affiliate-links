<?php
//functions used in plugin



//Load css stylesheets
function load_css() {
	
        //load css styles
        wp_register_style( 'tabs', plugins_url('css/tabs.css', __FILE__) );
        wp_enqueue_style('tabs');


}

//load javascript files
function load_js() {
	
        // load our jquery file that sends the $.post request
	wp_enqueue_script( "js", plugin_dir_url( __FILE__ ) . 'js/js.js', array( 'jquery' ) );
	wp_enqueue_script( "tabs", plugin_dir_url( __FILE__ ) . 'js/jquery.tools.min.js', array( 'jquery' ) );
        
        // make the ajaxurl var available to the above script
	wp_localize_script( 'js', 'ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );	
        
}

//Delete link button (called by ajax)
function DeleteLink(){
    
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

//Add link form (called by ajax)
function AddLink(){
    
            	global $wpdb;
                $table_name = $wpdb->prefix . "automated_links";
     	
		// Security check and sanitize	
		$link = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['link'];
		$keywords = filter_input(INPUT_POST, 'keywords', FILTER_SANITIZE_SPECIAL_CHARS); // $_POST['keywords'];
		
		// Add to database 
		$rows_affected = $wpdb->insert( $table_name, array( 'link' => $link, 'keywords' => $keywords ) );
}

//Get list of link showed on Add Affiliate Links tab

function getLinks($myrows){
         foreach($myrows as $row) {

                                    $id = $row->id;
                                    $link = $row->link;
                                    $keywords = $row->keywords;

                                    $deletelink = '?page=WP-auto-affiliate-links.php&aal_action=delete&id='. $id;
                                    $deletelink = ( function_exists('wp_nonce_url') ) ? wp_nonce_url($deletelink, 'WP-auto-affiliate-links_delete_link') : $deletelink;

                                    ?>
                                        <form name="edit-link-<?php echo $id; ?>" method="post">

                                        <?php
                                        if ( function_exists('wp_nonce_field') )
                                                wp_nonce_field('WP-auto-affiliate-links_edit_link');
                                        ?>
                                            <li style="" class="box">
                                                Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="link" value="<?php echo $link; ?>" />
                                                Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="keywords" value="<?php echo $keywords; ?>" />
                                                <input style="margin: 5px 2px;" type="submit" name="ed" value="Edit" />
                                                <input value="<?php echo $id; ?>" name="edit_id" type="hidden" />
                                                <input type="hidden" name="aal_edit" value="ok" />
                                                <a href="#" id="<?php echo $id; ?>" class="delete"><img src="<?php echo plugin_dir_url(__FILE__);?>images/delete.png"/></a>
                                            </li>    
                                        </form>

                                            
                          <?php } 
}

//Get keyoword sugestions for Add Afiliates Link Tab

function getSugestions(){
    
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

        //Taking only the most used 20 keywords and displaying them
        $final = array_slice($final, 0, 19);
        foreach($final as $fin) {
                if($fin!='' && $fin!=' ' && $fin!= '   ') {
                        echo '<a href="javascript:;" onclick="document.getElementById(\'formkeywords\').value=\''. $fin .'\'">'. $fin .'</a>&nbsp;';
                }

        }
}

//Installation of plugin
function aal_install() {
	global $wpdb; 
	$table_name = $wpdb->prefix . "automated_links";
	
	delete_option('aal_target'); add_option( 'aal_target', '_blank');
	delete_option('aal_relation'); add_option( 'aal_relation', 'nofollow');

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

?>
