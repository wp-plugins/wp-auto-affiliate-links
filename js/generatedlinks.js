jQuery(document).ready(function() { 


	var apikey = document.getElementById('aal_apikey').getAttribute('data-apikey');
	//alert(apikey);


	var table = document.getElementById("aal_gltable");
	
	aalapidata = { apikey: apikey };
  jQuery.ajax({
                    type: "GET",
                    url: "http://autoaffiliatelinks.com/api/getlinks.php",
                    data: aalapidata,
                    cache: false,
                    success: function(returned){
                    //console.log('succes');   
                    
             
                   
                   
                  console.log(returned);
                    
						var larray = jQuery.parseJSON(returned);

	

	
						larray.links.forEach(function(entry) {
							
							var kwlist = '';
					if (typeof entry.keywords !== 'undefined') {
   
					var keywords = jQuery.parseJSON(entry.keywords);
							if(keywords.constructor === Array) 
								keywords.forEach(function(keyword) {
								
								//console.log('aaa');
								
								kwlist = kwlist + '<a href="' + keyword.url + '">'+ keyword.key +'</a>,&nbsp;';
							
							
							});
							
						}
						if(kwlist=='') kwlist = 'No links displayed for thsi post';

	    
					var tr = document.createElement('tr');
					var td1 = document.createElement('td'); td1.innerHTML = '<a href="' + entry.url + '">' + entry.url + '</a>'; tr.appendChild(td1);	
					var td2 = document.createElement('td'); td2.innerHTML = kwlist; tr.appendChild(td2);
					var td3 = document.createElement('td'); td3.innerHTML = ''; tr.appendChild(td3);

	
					
					
					table.appendChild(tr);	    
	    
	    
	    
	    
						});
	


                    
     }
     
   });



});