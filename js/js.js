jQuery(document).ready(function() { 


    function isValidURL(url){
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }

    }

//Delete Link called through AJAX
jQuery(".aalDeleteLink").live('click',function() {
              
    var answer = confirm("Are you sure you want to delete this automated link?");
    
        if (answer){
        
        var linkContainer = jQuery(this).parent();
        var id = jQuery(this).attr("id");
        var data = {action: 'aal_delete_link',id: id};
        
            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){
                    linkContainer.slideUp('slow', function() {jQuery(this).remove();});
                                        }
                });
        }

                return false;
        }); 

// Add Link (Called through AJAX)

    jQuery("#aal_add_new_link_form").submit(function() {
        
        var aal_keywords = jQuery("#aal_formkeywords").val();
        var aal_link = jQuery("#aal_formlink").val();
        
        if(isValidURL(aal_link)){
        
        if(aal_keywords!=''){
        
            jQuery("#aal_formlink").val("http://");
            jQuery("#aal_formkeywords").val("");

            var data = {
                        action: 'aal_add_link',
                        aal_link: aal_link,
                        aal_keywords:aal_keywords
                       };

            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    dataType: "json",
                    cache: false,
                    success: function(data){
                        
                    jQuery(".aal_links").append('<li class="aal_links_box">Link: <input style="margin: 5px 10px;width: 37%;" type="text" name="aal_link" value="'+aal_link+'" />\
                                                  Keywords: <input style="margin: 5px 10px;width: 20%;" type="text" name="aal_keywords" value="'+aal_keywords+'" /> \
                                                  <a href="#" id="'+data['aal_delete_id']+'" class="aalDeleteLink"><img src="'+ajax_script.aal_plugin_url+'images/delete.png"/></a>\
                                                </li>');

                    }

               });
            
            }else alert('Keyword must not be empty');
       
        }else alert('Link entered is not valid, it should contain http://');
    
        return false;
     }); 
     
//General Options CHANGE

jQuery("#aal_changeOptions").submit(function() {
        
      
        
            var aal_iscloacked = jQuery("#aal_iscloacked").is(":checked");
            var aal_langsupport = jQuery("#aal_langsupport").is(":checked");
            var aal_showhome= jQuery("#aal_showhome").is(":checked");
            var aal_notimes= jQuery("#aal_notimes").val();
            var aal_notimescustom= jQuery("#aal_notimescustom").val();
            var aal_samekeyword= jQuery("#aal_samekeyword").val();
            var aal_display= jQuery("#aal_display").val();
            var aal_cssclass= jQuery("#aal_cssclass").val();
            var aal_target= jQuery('#aal_changeOptions input[type=radio][name=aal_target]:checked').val();
            var aal_relation= jQuery('#aal_changeOptions input[type=radio][name=aal_relation]:checked').val();
            
            
            var aal_displayca = [];
            
            
           jQuery("#aal_changeOptions input#aal_displayc:checkbox:checked").each(function(){
    			 aal_displayca.push(jQuery(this).val());
    			//return aal_displayca;
  			  });
  			  
  			 var aal_displayc = JSON.stringify(aal_displayca);
            
           // console.log(aal_displayc);
            //return false;
            
            var data = {
                        action: 'aal_change_options',
                        aal_iscloacked: aal_iscloacked,
                        aal_langsupport: aal_langsupport,
                        aal_showhome:aal_showhome,
                        aal_notimes:aal_notimes,
                        aal_notimescustom:aal_notimescustom,
                        aal_samekeyword:aal_samekeyword,
                        aal_target:aal_target,
                        aal_relation:aal_relation,
                        aal_display:aal_display,
                        aal_cssclass:aal_cssclass,
                        aal_displayc:aal_displayc
                       };

            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){

                     //jQuery(".aal_add_link_status").text('Options Saved');
							alert("Settings saved");
	
                    }

               });
            
       
    
        return false;
     }); 
 
 
 jQuery("#aal_add_exclude_posts_form").submit(function() {
            
            
            var id = jQuery("#aal_add_exclude_post_id").val();
            
            var data = {
                        action: 'aal_add_exclude_posts',
                        aal_post: id,

                       };

            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(response){
                    	
 							if(response=='nopost') { 
 									alert('The post ID does not correspond with any post or page'); 
 							}
 							else if(response=='duplicate') { 
 									alert('A posts with the same ID is already excluded'); 
 							}
 							else { 	
                     jQuery(".aal_exclude_posts").append('<div class="aal_excludeditem"><div class="aal_excludedcol">'+id+'</div>   ' + response + '<div class="aal_excludedcol"><a href="javascript:;" id="'+id+'" class="aal_delete_exclude_link"><img src="'+ajax_script.aal_plugin_url+'images/delete.png"/></a></div><br/></div><div style="clear: both;"></div>');
                     jQuery(".aal_exclude_status").append('<p><i>Exclude ID added!</i></p>');
                     
                  }
                     
                    }

               });
            
       
    
        return false;
     }); 


jQuery(".aal_delete_exclude_link").live('click',function() {
        
    var answer = confirm("Are you sure you want to delete this exclude link?");
    
        if (answer){
        
        //delete selected exclude id box from the form 
        var linkContainer = jQuery(this).parent().parent();
        linkContainer.slideUp('slow', function() {jQuery(this).remove();
            
});
        
        var removeItem=jQuery(this).parent().parent().children(".aal_excludedcol:first-child").text();
        //console.log(removeItem);
        
        var posts=new Array();
        
        
        jQuery(".aal_excludeditem").each(function(){
			//console.log(jQuery(this).children(".aal_excludedcol:first-child").text());
        	
            posts.push(jQuery(this).children(".aal_excludedcol:first-child").text());
        });
        
        //console.log(posts);
        
        posts=jQuery.grep(posts,function(value){
            return value!=removeItem;
        });
        
       //console.log(posts);
        
        
        var data = {action: 'aal_update_exclude_posts',aal_exclude_posts:posts};
            
            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){
                    //console.log('succes');                    
                    }
                });
            }

                return false;
        }); 







}); 

function aal_masscomplete() {

		var checkboxes = document.getElementsByName('aal_massids[]');
		var vals = "";
		for (var i=0, n=checkboxes.length;i<n;i++) {
		  if (checkboxes[i].checked) 
		  {
		  vals += ","+checkboxes[i].value;
		  }
		}
		if (vals) vals = vals.substring(1);
	
	//alert(vals);
		document.getElementById('aal_massstring').value = vals;

		return confirm('Are you sure you want to delete all selected links ?');
		return true;
}

jQuery( document ).ready(function() {
 jQuery('#aal_selectall').click( function () {
    jQuery('#aal_panel3 :checkbox').each(function() {
          this.checked = true;
      });
  });

	return false;
});



//Frequency selector, display custom value
function aalFrequencySelector() {
	
	var es = document.getElementById('aal_notimes');
	//alert(es.options[es.selectedIndex].value);

	if(es.options[es.selectedIndex].value == 'custom') { 
	
		document.getElementById('aal_custom_frequency').style.display = 'block';
		
	}
	else {
		document.getElementById('aal_custom_frequency').style.display = 'none';
	}
	

}



//show custom links

jQuery(document).ready(function() {
      canvas = document.getElementById('aalshowcustomlinks');
      if(canvas) { 
      	apikey = canvas.getAttribute('data-apikey');
      	network = canvas.getAttribute('data-network');
      
		apidata = { network: network, apikey: apikey };

	jQuery.ajax({
         type: "GET",
         url: "http://autoaffiliatelinks.com/api/getcustomlinks.php",
         data: apidata,
         cache: false,
         success: function(returned){
         	
         	//console.log('succes');   
         	//console.log(returned); 
         	
         	
         	canvas = document.getElementById('aalshowcustomlinks');
         	
         	
         	if(!returned || returned == 'there was an error' ) {
					canvas.innerHTML = 'No shareasale links added yet';	         		
         		return false;
				}	                    
                  
				var farray = jQuery.parseJSON(returned);
				//console.log(farray.list.q);
				//console.log(farray);

				if(!farray.number) {
					canvas.innerHTML = 'Sorry, no results matched your search query';	         		
         		return false;			
				}

					
					while (canvas.firstChild) {
					    canvas.removeChild(canvas.firstChild);
					}
					
					
					 var div = document.createElement('div');
					div.className = "aalcustomlinkdeleteall";
					var htmltext = '<span class=""><a href="" onclick="aalCustomLinkDeleteAll();" >Delete All Links</a></span><div style="clear: both;"></div>';
					div.innerHTML = htmltext;

	    			canvas.appendChild(div);


				farray.links.forEach(function(entry) {
	    
					//console.log(entry.title + entry.link);	 
					
					var deletelink = '';   
					
					 var div = document.createElement('div');
					div.className = "aalcustomlink_item";
					var htmltext = '<span class="aalcustomlink_url"><a href="' + entry.link +'">Link</a>&nbsp;&nbsp;&nbsp;</span><span class="aalcustomlink_url" ><a onclick="return aalCustomLinkDelete('+ entry.id +');" style="color: #ff0000;" href="' + deletelink +'">Delete</a>&nbsp;&nbsp;&nbsp;</span><span class="aalcustomlink_title">' + entry.title + '</span><span class="aalcustomlink_merchant">' + entry.merchant +'      </span><div style="clear: both;"></div>';
					div.innerHTML = htmltext;

	    			canvas.appendChild(div);
	    			
				});
	
                   
     		}
     
   });      
      
      
      
      } 
      else {  }
});



function aalCustomLinkDelete(linkid) {
	var answer = confirm("Are you sure you want to delete this link  ?")
	if (answer){
		
		
      var canvas = document.getElementById('aalshowcustomlinks');
      if(canvas) { 
      	apikey = canvas.getAttribute('data-apikey');
      	network = canvas.getAttribute('data-network');
		
		var apidata = { network: network, apikey: apikey, linkid: linkid };

	jQuery.ajax({
         type: "GET",
         url: "http://autoaffiliatelinks.com/api/deletecustomlinks.php",
         data: apidata,
         cache: false,
         success: function(returned){
         	
         	//console.log('succes');   
         	console.log(returned); 
         	
         	
         	var canvas = document.getElementById('aalshowcustomlinks');
         	
         	
         	if(!returned || returned == 'there was an error' ) {
					alert("There was a problem completing your action, please refresh the page and try again");	         		
         		return false;
				}	                    
                  
				//var farray = jQuery.parseJSON(returned);


					
					while (canvas.firstChild) {
					    canvas.removeChild(canvas.firstChild);
					}
	
                   
     		}
     
   });     		
		
		
		
	}	
	
	//return false;
		
	}
	else{
		return false;
	}
	
	//return false;
}





function aalCustomLinkDeleteAll() {

var answer = confirm("Are you sure you want to delete all the links below  ?")
	if (answer){
		
		
      var canvas = document.getElementById('aalshowcustomlinks');
      if(canvas) { 
      	apikey = canvas.getAttribute('data-apikey');
      	network = canvas.getAttribute('data-network');
		
		var apidata = { network: network, apikey: apikey, massdelete: 'all' };

	jQuery.ajax({
         type: "GET",
         url: "http://autoaffiliatelinks.com/api/deletecustomlinks.php",
         data: apidata,
         cache: false,
         success: function(returned){
         	
         	//console.log('succes');   
         	console.log(returned); 
         	
         	
         	var canvas = document.getElementById('aalshowcustomlinks');
         	
         	
         	if(!returned || returned == 'there was an error' ) {
					alert("There was a problem completing your action, please refresh the page and try again");	         		
         		return false;
				}	                    
                  
				//var farray = jQuery.parseJSON(returned);


					
					while (canvas.firstChild) {
					    canvas.removeChild(canvas.firstChild);
					}
	
                   
     		}
     
   });     		
		
		
		
	}	
	
	//return false;
		
	}
	else{
		return false;
	}




//return false;
}




//AAL javascript code for keyword suggestions

jQuery(document).ready(function() {
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

});



//Aal notice dismiss function
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