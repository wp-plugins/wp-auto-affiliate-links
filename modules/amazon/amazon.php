<?php


$aalAmazon = new aalModule('amazon','Amazon Links');
$aalModules[] = $aalAmazon;

$aalAmazon->aalModuleHook('content','aalAmazonDisplay');


add_action( 'admin_init', 'aal_amazon_register_settings' );


function aal_amazon_register_settings() { 
   register_setting( 'aal_amazon_settings', 'aal_amazonid' );
   register_setting( 'aal_amazon_settings', 'aal_amazonapikey' );
   register_setting( 'aal_amazon_settings', 'aal_amazonsecret' );
   register_setting( 'aal_amazon_settings', 'aal_amazoncat' );
   register_setting( 'aal_amazon_settings', 'aal_amazonactive' );
}




function aalAmazonDisplay() {
	
	$amazoncat = get_option('aal_amazoncat');

	?>

<script type="text/javascript">

function aal_amazon_validate() {
	
		if(!document.aal_amazonform.aal_amazoncat.value) { alert("Please select a category"); return false; }
		if(!document.aal_amazonform.aal_amazonid.value) { alert("Please add your amazon ID"); return false; }
				
	}

jQuery(document).ready(function() {
      jQuery("#aal_amazoncat").val("<? echo $amazoncat; ?>");	
}); 

	
	</script>
	
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Amazon Links</h2>
                <br /><br />
                
                
<div class="updated"><br />How would you rate your experience with Wp Auto Affiliate Links ? Please send your feedback using the  <a href="http://autoaffiliatelinks.com/support-help/support-contact/">contact form on our website</a>. If you have problems you can open a ticket at  <a href="http://wordpress.org/support/plugin/wp-auto-affiliate-links">wordpress support forums</a>. If you like the plugin and it works fine for you then please leave us a <a href="http://wordpress.org/support/view/plugin-reviews/wp-auto-affiliate-links?filter=5#postform">rating and a review</a>. <br /><br /></div>                
                
                
                Once you add your affiliate ID and activate amazon links, they will start to appear on your website. The manual links that you add will have priority.<br />
                This feature will only work if you have set the API Key in the "API Key" menu.
                <br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_amazonform" onsubmit="return aal_amazon_validate();"> 
<?php
		settings_fields( 'aal_amazon_settings' );
		do_settings_sections('aal_amazon_settings_display');
		
?>
		<span class="aal_label">Amazon Affiliate ID:</span> <input type="text" name="aal_amazonid" value="<?php echo get_option('aal_amazonid'); ?>" /><br />
	<span class="aal_label">Category: </span><select id="aal_amazoncat"  name="aal_amazoncat" ><option value="">-Select a cateogry-	</option>
		<option value="Apparel">Apparel & Accessories</option>
		<option value="Software">Appstore for Android</option>
		<option value="HomeGarden">Arts, Crafts & Sewing</option>
		<option value="Automotive">Automotive</option>
		<option value="Baby">Baby</option>
		<option value="Beauty">Beauty</option>
		<option value="Books">Books</option>
		<option value="Electronics">Car Toys</option>
		<option value="Wireless">Cell Phones & Accessories</option>
		<option value="VideoGames">Computer & Video Games</option>
		<option value="Electronics">Electronics</option>
		<option value="HomeGarden">Gifts & Wish Lists</option>
		<option value="Grocery">Grocery & Gourmet Food</option>
		<option value="HealthPersonalCare">Health & Personal Care</option>
		<option value="Kitchen">Home & Kitchen</option>
		<option value="Tools">Home Improvement</option>
		<option value="Industrial">Industrial & Scientific</option>
		<option value="Jewelry">Jewelry</option>
		<option value="KindleStore">Kindle Store</option>
		<option value="Kitchen">Kitchen & Housewares</option>
		<option value="Magazines">Magazine Subscriptions</option>
		<option value="DVD">Movies &amp; TV</option>
		<option value="Music">Music</option>
		<option value="MusicalInstruments">Musical Instruments</option>
		<option value="OfficeProducts">Office Products</option>
		<option value="HomeGarden">Outlet</option>
		<option value="PetSupplies">Pet Supplies</option>
		<option value="Shoes">Shoes</option>
		<option value="Software">Software</option>
		<option value="Software">Sports & Outdoors</option>
		<option value="Tools">Tools & Hardware</option>
		<option value="Toys">Toys and Games</option>
		<option value="Books">Travel</option>
		<option value="All">All Categories</option>
	</select>
	<br />
		<span class="aal_label">Status: </span><select name="aal_amazonactive">
			<option value="0" <?php if(get_option('aal_amazonactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_amazonactive')=='1') echo "selected"; ?> >Active</option>
		</select><br />




<?php
	submit_button('Save');
	echo '</form></div>';
	echo '</div>';

}




?>