jQuery(document).ready(function() { 


			datadiv = document.getElementById('aal_api_data');		
			aal_divnumber = datadiv.getAttribute('data-divnumber');
			aal_target = datadiv.getAttribute('data-target');
			aal_relation = datadiv.getAttribute('data-relation');
			aal_postid = datadiv.getAttribute('data-postid');
			aal_apikey = datadiv.getAttribute('data-apikey');
			aal_clickbankid = datadiv.getAttribute('data-clickbankid');
			aal_clickbankgravity = datadiv.getAttribute('data-clickbankgravity');
			aal_notimes = datadiv.getAttribute('data-notimes');
			aal_clickbankcat = datadiv.getAttribute('data-clickbankcat');
			aal_aurl = datadiv.getAttribute('data-aurl');
			// aal_content = datadiv.getAttribute('data-content');
			aal_content = encodeURIComponent(document.getElementById('aalcontent_' + aal_divnumber).parentNode.innerHTML);
			//aalapidata = datadiv.getAttribute('data-apidata');		
			
			//console.log(aal_divnumber);
			//console.log(aal_content);
			
			
			aalapidata = {content: aal_content, apikey: aal_apikey, clickbankid: aal_clickbankid, clickbankcat: aal_clickbankcat,  clickbankgravity: aal_clickbankgravity, aurl: aal_aurl, notimes: aal_notimes};
			//alert(aalapidata);

		
			aal_retrievelinks(aalapidata,aal_divnumber,aal_target,aal_relation);
		
		
		 });




function aal_retrievelinks(aalapidata,aal_divnumber,aal_target,aal_relation) {
	
	//alert('aaa');
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
	var re = new RegExp("(?!(?:[^<\\[]+[>\\]]|[^>\\]]+<\/a>))\\b("+ entry.key +")\\b","i");
	acontent = acontent.replace(re, '<a title="$1" class="aal" target="' + aal_target + '" ' + aal_relation + ' href="'+ entry.url +'">$1</a>');	    
	    
	    
	    
	    
	});
	
	//console.log(parray[0]);



	var reg = '/(?!(?:[^<\[]+[>\]]|[^>\]]+<\/a>))\b($name)\b/imsU';
	var rep = '<a title="$1" class="aal" target="$targeto" relation="$relo" href="$url">$1</a>';

	


	//alert(bcontent);

	parentdiv.innerHTML = acontent;


                    
     }
     
   });
   
   
}
