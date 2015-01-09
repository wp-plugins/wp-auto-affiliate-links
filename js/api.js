jQuery(document).ready(function() { 

		//if(document.getElementById('aal_api_data')) { 
		
		jQuery("div[id*='aal_api_data']").each(function() { //console.log(this.getAttribute('data-divnumber'));
			//datadiv = document.getElementById('aal_api_data');		
			datadiv = this;
			aal_divnumber = datadiv.getAttribute('data-divnumber');
			aal_target = datadiv.getAttribute('data-target');
			aal_relation = datadiv.getAttribute('data-relation');
			aal_postid = datadiv.getAttribute('data-postid');
			aal_apikey = datadiv.getAttribute('data-apikey');
			aal_clickbankid = datadiv.getAttribute('data-clickbankid');
			aal_clickbankgravity = datadiv.getAttribute('data-clickbankgravity');
			aal_notimes = datadiv.getAttribute('data-notimes');
			aal_clickbankcat = datadiv.getAttribute('data-clickbankcat');
			aal_amazonlocal = datadiv.getAttribute('data-amazonlocal');
			aal_amazonid = datadiv.getAttribute('data-amazonid');
			aal_amazoncat = datadiv.getAttribute('data-amazoncat');
			aal_amazonactive = datadiv.getAttribute('data-amazonactive');
			aal_clickbankactive = datadiv.getAttribute('data-clickbankactive');
			aal_shareasaleid = datadiv.getAttribute('data-shareasaleid');
			aal_shareasaleactive = datadiv.getAttribute('data-shareasaleactive');
			aal_cjactive = datadiv.getAttribute('data-cjactive');
			aal_ebayactive = datadiv.getAttribute('data-ebayactive');
			aal_ebayid = datadiv.getAttribute('data-ebayid');
			aal_bestbuyactive = datadiv.getAttribute('data-bestbuyactive');
			aal_bestbuyid = datadiv.getAttribute('data-bestbuyid');
			aal_walmartactive = datadiv.getAttribute('data-walmartactive');
			aal_walmartid = datadiv.getAttribute('data-walmartid');
			aal_envatoid = datadiv.getAttribute('data-envatoid');
			aal_envatosite = datadiv.getAttribute('data-envatosite');
			aal_envatoactive = datadiv.getAttribute('data-envatoactive');
			aal_aurl = datadiv.getAttribute('data-aurl');
			// aal_content = datadiv.getAttribute('data-content');
			aal_content = encodeURIComponent(document.getElementById('aalcontent_' + aal_divnumber).parentNode.innerHTML);
			//aalapidata = datadiv.getAttribute('data-apidata');		
			
			//console.log(aal_divnumber);
			//console.log(aal_content);
			
			
			aalapidata = {content: aal_content, apikey: aal_apikey, clickbankid: aal_clickbankid, clickbankcat: aal_clickbankcat,  clickbankgravity: aal_clickbankgravity, amazonid: aal_amazonid, amazoncat: aal_amazoncat, amazonlocal: aal_amazonlocal, amazonactive: aal_amazonactive, clickbankactive: aal_clickbankactive, shareasaleactive: aal_shareasaleactive, shareasaleid: aal_shareasaleid, cjactive: aal_cjactive, ebayactive: aal_ebayactive, ebayid: aal_ebayid, bestbuyactive: aal_bestbuyactive, bestbuyid: aal_bestbuyid, walmartactive: aal_walmartactive, walmartid: aal_walmartid, envatoid: aal_envatoid, envatosite: aal_envatosite, envatoactive: aal_envatoactive, aurl: aal_aurl, notimes: aal_notimes};
			//alert(aalapidata);

		
			aal_retrievelinks(aalapidata,aal_divnumber,aal_target,aal_relation);
		
	//}
		});
		 });




function aal_retrievelinks(aalapidata,aal_divnumber,aal_target,aal_relation) {
	
	//console.log(aalapidata);

	//aalapidata = {action: 'aal_update_exclude_posts',aal_exclude_posts:'aaa'};
 jQuery.ajax({
                    type: "POST",
                    url: "http://autoaffiliatelinks.com/api/pro.php",
                    data: aalapidata,
                    cache: false,
                    success: function(returned){
                    //console.log('succes');   
                    
             
                   
                   
                  //console.log(returned);
                    
	var parray = jQuery.parseJSON(returned);
	var spydiv = document.getElementById('aalcontent_' + aal_divnumber);
	var parentdiv = spydiv.parentNode;
	if(parentdiv.innerHTML == '<div id="aalcontent_' + aal_divnumber + '></div>') parentdiv = parentdiv.parentNode;
	var acontent = parentdiv.innerHTML;
	
	//alert(acontent);
	
	parray.forEach(function(entry) {
		
	var re2 = new RegExp("(?!(?:[^<\\[]+[>\\]]|[^>\\]]+<\/a>))\\b("+ entry.key +")\\b","i");
	var re = new RegExp("(?!(?:[^<\\[]+[>\\]]|[^>\\]]+<\/a>))(?!(?:[^<\\[]+[>\\]]|[^>\\]]+<\/h.>))\\b("+ entry.key +")\\b","i");
	acontent = acontent.replace(re, '<a title="$1" class="aal" target="' + aal_target + '" ' + aal_relation + ' href="'+ entry.url +'">$1</a>');	    
	    
	    
	    
	    
	});
	
	//console.log(parray[0]);



	var reg = '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
	var rep = '<a title="$1" class="aal" target="$targeto" relation="$relo" href="$url">$1</a>';


	parentdiv.innerHTML = acontent;


                    
     }
     
   });
   
   
}
