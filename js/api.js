

function aal_retrievelinks(aalapidata,aal_divnumber,aal_target,aal_relation) {
	
	//alert('aaa');
	//alert(aalapidata);

//var aalapidata = {action: 'aal_update_exclude_posts',aal_exclude_posts:'aaa'};
 jQuery.ajax({
                    type: "POST",
                    url: "http://autoaffiliatelinks.com/api/pro.php",
                    data: aalapidata,
                    cache: false,
                    success: function(returned){
                    //console.log('succes');   
                    
             
                   // alert(returned);
                   
                   //alert(returned);
                    
	var parray = jQuery.parseJSON(returned);
	var spydiv = document.getElementById('aalcontent_' + aal_divnumber);
	var parentdiv = spydiv.parentNode;
	if(parentdiv.innerHTML == '<div id="aalcontent_' + aal_divnumber + '></div>') parentdiv = parentdiv.parentNode;
	var acontent = parentdiv.innerHTML;
	
	//alert(acontent);
	
	parray.forEach(function(entry) {
		
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
