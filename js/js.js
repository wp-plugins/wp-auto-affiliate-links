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
                        
                    jQuery(".aal_links").append('<li>Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="aal_link" value="'+aal_link+'" />\
                                                  Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="aal_keywords" value="'+aal_keywords+'" /> \
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
            var aal_samekeyword= jQuery("#aal_samekeyword").val();
            var aal_display= jQuery("#aal_display").val();
            var aal_cssclass= jQuery("#aal_cssclass").val();
            var aal_target= jQuery('#aal_changeOptions input[type=radio][name=aal_target]:checked').val();
            var aal_relation= jQuery('#aal_changeOptions input[type=radio][name=aal_relation]:checked').val();
            
            //console.log(aal_target);
            
            var data = {
                        action: 'aal_change_options',
                        aal_iscloacked: aal_iscloacked,
                        aal_langsupport: aal_langsupport,
                        aal_showhome:aal_showhome,
                        aal_notimes:aal_notimes,
                        aal_samekeyword:aal_samekeyword,
                        aal_target:aal_target,
                        aal_relation:aal_relation,
                        aal_display:aal_display,
                        aal_cssclass:aal_cssclass
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
                     jQuery(".aal_exclude_posts").append('<span>Post ID :'+id+'   ' + response + '<a href="javascript:;" id="'+id+'" class="aal_delete_exclude_link"><img src="'+ajax_script.aal_plugin_url+'images/delete.png"/></a></span><br/>');
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
        var linkContainer = jQuery(this).parent();
        linkContainer.slideUp('slow', function() {jQuery(this).remove();
            
});
        
        var removeItem=jQuery(this).closest('span').find('.all_exclude_post_item').val();
        //console.log(test);
        
        var posts=new Array();
        
        jQuery(".all_exclude_post_item").each(function(){
            posts.push(jQuery(this).val());
        });
        
        posts=jQuery.grep(posts,function(value){
            return value!=removeItem;
        });
        
        
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


});
