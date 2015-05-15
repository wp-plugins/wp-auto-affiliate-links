<?php


$aalClickbank = new aalModule('clickbank','Clickbank Links',4);
$aalModules[] = $aalClickbank;

$aalClickbank->aalModuleHook('content','aalClickbankDisplay');


add_action( 'admin_init', 'aal_clickbank_register_settings' );


function aal_clickbank_register_settings() { 
   register_setting( 'aal_clickbank_settings', 'aal_clickbankid' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankcat' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankgravity' );
   register_setting( 'aal_clickbank_settings', 'aal_clickbankactive' );
}




function aalClickbankDisplay() {

	?>
	
	<script type="text/javascript">


function aal_getScript(url, callback) {
   var script = document.createElement("script");
   script.type = "text/javascript";
   script.src = url;

   script.onreadystatechange = callback;
   script.onload = callback;

   document.getElementsByTagName("head")[0].appendChild(script);
}


/* aal_getScript("//autoaffiliatelinks.com/api/api.php?action=allcats", function(){
 
	var maincat = document.getElementById("aal_clickbankcat");
			number = maincats.length;
			
			var i=0;
			for(ir=1;ir<number+1;ir++) {
				ovalue = maincats[ir-1][0];
				otext = maincats[ir-1][1];
				if(maincats[ir-1][2] != 0) otext = '--- ' + otext;
				option= new Option(otext,ovalue);
				document.getElementById("aal_clickbankcat").options[ir] = option; 
				
				if("<?php echo get_option('aal_clickbankcat'); ?>" == ovalue) document.getElementById("aal_clickbankcat").selectedIndex = ir;
	
			}

}); */

jQuery( document ).ready(function() {
    document.getElementById("aal_clickbankcat").selectedIndex = <?php echo get_option('aal_clickbankcat'); ?>;
});


function aal_clickbank_validate() {
	
		if(!document.aal_clickbankform.aal_clickbankcat.value) { alert("Please select a category"); return false; }
		if(!document.aal_clickbankform.aal_clickbankid.value) { alert("Please add your clickbank ID"); return false; }
		if(!document.aal_clickbankform.aal_clickbankgravity.value) { alert("If you wish to get all the products regardless the gravity, add leave the gravity field with 0"); return false; }
				
	}



	
	</script>
	
	
	
<div class="wrap">  
    <div class="icon32" id="icon-options-general"></div>  
        
        
                <h2>Clickbank Links</h2>
                <br /><br />
                Once you add your affiliate ID and activate clickbank links, they will start to appear on your website. The manual links that you add will have priority.<br />
                This feature will only work if you have set the API Key in the respective menu.
                <br /><br />
                
<div class="aal_general_settings">
		<form method="post" action="options.php" name="aal_clickbankform" onsubmit="return aal_clickbank_validate();"> 
<?php
		settings_fields( 'aal_clickbank_settings' );
		do_settings_sections('aal_clickbank_settings_display');
		
?>
		<span class="aal_label">Affiliate ID:</span> <input type="text" name="aal_clickbankid" value="<?php echo get_option('aal_clickbankid'); ?>" /><br />
	<span class="aal_label">Category: </span><select id="aal_clickbankcat"  name="aal_clickbankcat" ><option value="">-Select a cateogry-	</option>
	<option value="1">Arts &amp; Entertainment</option><option value="2">--- Architecture</option><option value="3">--- Art</option><option value="4">--- Body Art</option><option value="5">--- Dance</option><option value="6">--- Fashion</option><option value="7">--- Film &amp; Television</option><option value="8">--- General</option><option value="9">--- Humor</option><option value="10">--- Magic Tricks</option><option value="11">--- Music</option><option value="12">--- Photography</option><option value="13">--- Radio</option><option value="14">--- Theater</option><option value="15">Betting Systems</option><option value="16">--- Casino Table Games</option><option value="17">--- Football</option><option value="18">--- General</option><option value="19">--- Horse Racing</option><option value="20">--- Lottery</option><option value="21">--- Poker</option><option value="22">--- Soccer</option><option value="23">Business / Investing</option><option value="24">--- Careers, Industries &amp; Professions</option><option value="25">--- Commodities</option><option value="26">--- Debt</option><option value="27">--- Derivatives</option><option value="28">--- Economics</option><option value="29">--- Equities &amp; Stocks</option><option value="30">--- Foreign Exchange</option><option value="31">--- General</option><option value="32">--- International Business</option><option value="33">--- Management &amp; Leadership</option><option value="34">--- Marketing &amp; Sales</option><option value="35">--- Outsourcing</option><option value="36">--- Personal Finance</option><option value="37">--- Real Estate</option><option value="38">--- Small Biz / Entrepreneurship</option><option value="39">Computers / Internet</option><option value="40">--- Databases</option><option value="41">--- Email Services</option><option value="42">--- General</option><option value="43">--- Graphics</option><option value="44">--- Hardware</option><option value="45">--- Networking</option><option value="46">--- Operating Systems</option><option value="47">--- Programming</option><option value="48">--- Software</option><option value="49">--- System Administration</option><option value="50">--- Web Hosting</option><option value="51">--- Web Site Design</option><option value="52">Cooking, Food &amp; Wine</option><option value="53">--- BBQ</option><option value="54">--- Baking</option><option value="55">--- Cooking</option><option value="56">--- Drinks &amp; Beverages</option><option value="57">--- General</option><option value="58">--- Recipes</option><option value="59">--- Regional &amp; Intl.</option><option value="60">--- Special Diet</option><option value="61">--- Special Occasions</option><option value="62">--- Vegetables / Vegetarian</option><option value="63">--- Wine Making</option><option value="64">E-business &amp; E-marketing</option><option value="65">--- Affiliate Marketing</option><option value="66">--- Article Marketing</option><option value="67">--- Auctions</option><option value="68">--- Banners</option><option value="69">--- Blog Marketing</option><option value="70">--- Classified Advertising</option><option value="71">--- Consulting</option><option value="72">--- Copywriting</option><option value="73">--- Domains</option><option value="74">--- E-commerce Operations</option><option value="75">--- E-zine Strategies</option><option value="76">--- Email Marketing</option><option value="77">--- General</option><option value="78">--- Market Research</option><option value="79">--- Marketing</option><option value="80">--- Niche Marketing</option><option value="81">--- Paid Surveys</option><option value="82">--- Pay Per Click Advertising</option><option value="83">--- Promotion</option><option value="84">--- SEM &amp; SEO</option><option value="85">--- Social Media Marketing</option><option value="86">--- Submitters</option><option value="87">--- Video Marketing</option><option value="88">Education</option><option value="89">--- Admissions</option><option value="90">--- Educational Materials</option><option value="91">--- Higher Education</option><option value="92">--- K-12</option><option value="93">--- Student Loans</option><option value="94">--- Test Prep &amp; Study Guides</option><option value="95">Employment &amp; Jobs</option><option value="96">--- Cover Letter &amp; Resume Guides</option><option value="97">--- General</option><option value="98">--- Job Listings</option><option value="99">--- Job Search Guides</option><option value="100">--- Job Skills / Training</option><option value="101">Fiction</option><option value="102">--- General</option><option value="103">Games</option><option value="104">--- Console Guides &amp; Repairs</option><option value="105">--- General</option><option value="106">--- Strategy Guides</option><option value="107">Green Products</option><option value="108">--- Alternative Energy</option><option value="109">--- Conservation &amp; Efficiency</option><option value="110">--- General</option><option value="111">Health &amp; Fitness</option><option value="112">--- Addiction</option><option value="113">--- Beauty</option><option value="114">--- Dental Health</option><option value="115">--- Diets &amp; Weight Loss</option><option value="116">--- Exercise &amp; Fitness</option><option value="117">--- General</option><option value="118">--- Meditation</option><option value="119">--- Men's Health</option><option value="120">--- Mental Health</option><option value="121">--- Nutrition</option><option value="122">--- Remedies</option><option value="123">--- Sleep and Dreams</option><option value="124">--- Spiritual Health</option><option value="125">--- Strength Training</option><option value="126">--- Women's Health</option><option value="127">--- Yoga</option><option value="128">Home &amp; Garden</option><option value="129">--- Animal Care &amp; Pets</option><option value="130">--- Crafts &amp; Hobbies</option><option value="131">--- Entertaining</option><option value="132">--- Gardening &amp; Horticulture</option><option value="133">--- General</option><option value="134">--- Homebuying</option><option value="135">--- How-to &amp; Home Improvements</option><option value="136">--- Interior Design</option><option value="137">--- Sewing</option><option value="138">--- Weddings</option><option value="139">Languages</option><option value="140">--- Arabic</option><option value="141">--- Chinese</option><option value="142">--- English</option><option value="143">--- French</option><option value="144">--- German</option><option value="145">--- Hebrew</option><option value="146">--- Italian</option><option value="147">--- Japanese</option><option value="148">--- Other</option><option value="149">--- Russian</option><option value="150">--- Sign Language</option><option value="151">--- Spanish</option><option value="152">--- Thai</option><option value="153">Mobile</option><option value="154">--- Apps</option><option value="155">--- Developer Tools</option><option value="156">--- General</option><option value="157">--- Ringtones</option><option value="158">--- Security</option><option value="159">--- Video</option><option value="160">Parenting &amp; Families</option><option value="161">--- Divorce</option><option value="162">--- Education</option><option value="163">--- Genealogy</option><option value="164">--- General</option><option value="165">--- Marriage</option><option value="166">--- Parenting</option><option value="167">--- Pregnancy &amp; Childbirth</option><option value="168">--- Special Needs</option><option value="169">Politics / Current Events</option><option value="170">--- General</option><option value="171">Reference</option><option value="172">--- Automotive</option><option value="173">--- Catalogs &amp; Directories</option><option value="174">--- Consumer Guides</option><option value="175">--- Education</option><option value="176">--- Etiquette</option><option value="177">--- Gay / Lesbian</option><option value="178">--- General</option><option value="179">--- Law &amp; Legal Issues</option><option value="180">--- The Sciences</option><option value="181">--- Writing</option><option value="182">Self-Help</option><option value="183">--- Abuse</option><option value="184">--- Dating Guides</option><option value="185">--- Eating Disorders</option><option value="186">--- General</option><option value="187">--- Marriage &amp; Relationships</option><option value="188">--- Motivational / Transformational</option><option value="189">--- Personal Finance</option><option value="190">--- Public Speaking</option><option value="191">--- Self Defense</option><option value="192">--- Self-Esteem</option><option value="193">--- Stress Management</option><option value="194">--- Success</option><option value="195">--- Time Management</option><option value="196">Software &amp; Services</option><option value="197">--- Anti Adware / Spyware</option><option value="198">--- Background Investigations</option><option value="199">--- Communications</option><option value="200">--- Dating</option><option value="201">--- Developer Tools</option><option value="202">--- Digital Photos</option><option value="203">--- Drivers</option><option value="204">--- Education</option><option value="205">--- Email</option><option value="206">--- Foreign Exchange Investing</option><option value="207">--- General</option><option value="208">--- Graphic Design</option><option value="209">--- Hosting</option><option value="210">--- Internet Tools</option><option value="211">--- MP3 &amp; Audio</option><option value="212">--- Networking</option><option value="213">--- Operating Systems</option><option value="214">--- Other Investment Software</option><option value="215">--- Personal Finance</option><option value="216">--- Productivity</option><option value="217">--- Registry Cleaners</option><option value="218">--- Reverse Phone Lookup</option><option value="219">--- Screensavers &amp; Wallpaper</option><option value="220">--- Security</option><option value="221">--- System Optimization</option><option value="222">--- Utilities</option><option value="223">--- Video</option><option value="224">--- Web Design</option><option value="225">Spirituality, New Age &amp; Alternative Beliefs</option><option value="226">--- Astrology</option><option value="227">--- General</option><option value="228">--- Hypnosis</option><option value="229">--- Magic</option><option value="230">--- Numerology</option><option value="231">--- Paranormal</option><option value="232">--- Psychics</option><option value="233">--- Religion</option><option value="234">--- Tarot</option><option value="235">--- Witchcraft</option><option value="236">Sports</option><option value="237">--- Automotive</option><option value="238">--- Baseball</option><option value="239">--- Basketball</option><option value="240">--- Coaching</option><option value="241">--- Cycling</option><option value="242">--- Extreme Sports</option><option value="243">--- Football</option><option value="244">--- General</option><option value="245">--- Golf</option><option value="246">--- Hockey</option><option value="247">--- Individual Sports</option><option value="248">--- Martial Arts</option><option value="249">--- Mountaineering</option><option value="250">--- Other Team Sports</option><option value="251">--- Outdoors &amp; Nature</option><option value="252">--- Racket Sports</option><option value="253">--- Running</option><option value="254">--- Soccer</option><option value="255">--- Softball</option><option value="256">--- Training</option><option value="257">--- Volleyball</option><option value="258">--- Water Sports</option><option value="259">--- Winter Sports</option><option value="260">Travel</option><option value="261">--- Africa</option><option value="262">--- Asia</option><option value="263">--- Canada</option><option value="264">--- Caribbean</option><option value="265">--- Europe</option><option value="266">--- General</option><option value="267">--- Latin America</option><option value="268">--- Middle East</option><option value="269">--- Specialty Travel</option><option value="270">--- United States</option>
	</select>
	<br />
		<span class="aal_label">Minimum gravity: </span><input type="text" name="aal_clickbankgravity" value="<?php echo get_option('aal_clickbankgravity'); ?>" /><br />
		<span class="aal_label">Status: </span><select name="aal_clickbankactive">
			<option value="0" <?php if(get_option('aal_clickbankactive')=='0') echo "selected"; ?> > Inactive</option>
			<option value="1" <?php if(get_option('aal_clickbankactive')=='1') echo "selected"; ?> >Active</option>
		</select><br />




<?php
	submit_button('Save');
	echo '</form></div>';
	echo '</div>';

		

?>


</div>




<?php 
	

} ?>