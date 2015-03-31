<?php


$aalAmazon = new aalModule('amazon','Amazon Links',3);
$aalModules[] = $aalAmazon;

$aalAmazon->aalModuleHook('content','aalAmazonDisplay');


add_action( 'admin_init', 'aal_amazon_register_settings' );


function aal_amazon_register_settings() { 
   register_setting( 'aal_amazon_settings', 'aal_amazonid' );
   register_setting( 'aal_amazon_settings', 'aal_amazonapikey' );
   register_setting( 'aal_amazon_settings', 'aal_amazonsecret' );
   register_setting( 'aal_amazon_settings', 'aal_amazoncat' );
   register_setting( 'aal_amazon_settings', 'aal_amazonactive' );
   register_setting( 'aal_amazon_settings', 'aal_amazonlocal' );
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
		<option value="Appliances">Appliances</option>
		<option value="ArtsAndCrafts">Arts, Crafts & Sewing</option>
		<option value="Automotive">Automotive</option>
		<option value="Baby">Baby</option>
		<option value="Beauty">Beauty</option>
		<option value="Books">Books</option>
		<option value="Classical">Classical</option>
		<option value="Collectibles">Collectibles & Fine Art</option>
		<option value="DigitalMusic">Digital Music</option>
		<option value="Grocery">Grocery & Gourmet Food</option>
		<option value="DVD">Movies &amp; TV</option>
		<option value="Electronics">Electronics</option>
		<option value="HealthPersonalCare">Health & Personal Care</option>
		<option value="HomeGarden">Home & Garden</option>
		<option value="Industrial">Industrial & Scientific</option>
		<option value="Jewelry">Jewelry</option>
		<option value="KindleStore">Kindle Store</option>
		<option value="Kitchen">Home & Kitchen</option>
		<option value="LawnGarden">Lawn & Garden</option>
		<option value="Magazines">Magazine Subscriptions</option>		
		<option value="Marketplace">Marketplace</option>
		<option value="Merchants">Merchants</option>
		<option value="Miscellaneous">Miscellaneous</option>
		<option value="MobileApps">Android apps</option>
		<option value="MP3Downloads">MP3Downloads</option>
		<option value="Music">Music</option>
		<option value="MusicalInstruments">Musical Instruments</option>	
		<option value="MusicTracks">Music Tracks</option>
		<option value="OfficeProducts">Office Products</option>		
		<option value="OutdoorLiving">OutdoorLiving</option>
		<option value="PCHardware">PCHardware</option>
		<option value="PetSupplies">PetSupplies</option>
		<option value="Photo">Photo</option>
		<option value="Shoes">Shoes</option>
		<option value="Software">Software</option>
		<option value="SportingGoods">Sports & Outdoors</option>
		<option value="Tools">Home Improvement</option>		
		<option value="Toys">Toys and Games</option>
		<option value="UnboxVideo">UnboxVideo</option>
		<option value="VHS">VHS</option>
		<option value="Video">Video</option>
		<option value="VideoGames">Video Games</option>	
		<option value="Watches">Watches</option>
		<option value="Wireless">Cell Phones</option>		
		<option value="WirelessAccessories">Cell Phones & Accessories</option>		
		<option value="All">All Categories</option>
	</select>
	<br />
	<span class="aal_label">Localization: </span><select id="aal_amazonlocal"  name="aal_amazonlocal" >
		<option value="com" <?php if(get_option('aal_amazonlocal')=='com') echo "selected"; ?> >COM</option>
		<option value="ca" <?php if(get_option('aal_amazonlocal')=='ca') echo "selected"; ?>>CA</option>
		<option value="cn" <?php if(get_option('aal_amazonlocal')=='cn') echo "selected"; ?>>CN</option>
		<option value="de" <?php if(get_option('aal_amazonlocal')=='de') echo "selected"; ?>>DE</option>
		<option value="es" <?php if(get_option('aal_amazonlocal')=='es') echo "selected"; ?>>ES</option>
		<option value="fr" <?php if(get_option('aal_amazonlocal')=='fr') echo "selected"; ?>>FR</option>
		<option value="in" <?php if(get_option('aal_amazonlocal')=='in') echo "selected"; ?>>IN</option>
		<option value="it" <?php if(get_option('aal_amazonlocal')=='it') echo "selected"; ?>>IT</option>
		<option value="jp" <?php if(get_option('aal_amazonlocal')=='co.jp') echo "selected"; ?>>JP</option>
		<option value="uk" <?php if(get_option('aal_amazonlocal')=='co.uk') echo "selected"; ?>>UK</option>
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