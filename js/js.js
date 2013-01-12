jQuery(document).ready(function() { 

    // setup ul.tabs to work as tabs for each div directly under div.panes
    jQuery("ul.tabs").tabs("div.panes > div");
 

    function isValidURL(url){
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }

    }

//Delete Link called through AJAX

    jQuery(".aal_delete_link").click(function() {
        
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
        
        var keywords = jQuery("#formkeywords").val();
        var link = jQuery("#formlink").val();
        
        if(isValidURL(link)){
        
        if(keywords!=''){
        
            jQuery("#formlink").val("");
            jQuery("#formkeywords").val("");

            var data = {
                        action: 'aal_add_link',
                        link: link,
                        keywords:keywords
                       };

            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){

                    jQuery(".links").append('<li>Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="link" value="'+link+'" />Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="keywords" value="'+keywords+'" /></li>');

                    }

               });
            
            }else alert('Keyword must not be empty');
       
        }else alert('URL incorect');
    
        return false;
     }); 
     
//General Options CHANGE

jQuery("#changeOptions").submit(function() {
        
        var keyword = jQuery("#formkeywords").val();
        var link = jQuery("#formlink").val();
        
        
            var aal_iscloacked = jQuery("#aal_iscloacked").is(":checked");
            var aal_showhome= jQuery("#showhome").is(":checked");
            var aal_notimes= jQuery("#notimes").val();
            var aal_target= $('#changeOptions input[type=radio][name=aal_target]:checked').val();
            var aal_relation= $('input[name=aal_relation]:checked', '#changeOptions').val();
            
            //console.log(aal_target);
            
            var data = {
                        action: 'aal_change_options',
                        aal_iscloacked: aal_iscloacked,
                        aal_showhome:aal_showhome,
                        aal_notimes:aal_notimes,
                        aal_target:aal_target,
                        aal_relation:aal_relation
                       };

            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){

                     jQuery(".aal_add_link_status").text('Options Saved');

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
                    success: function(){
                     
                     jQuery(".aal_exclude_posts").append('<span>Post ID :<input type="text" value="'+id+'"/></span>');
                     jQuery(".aal_exclude_status").text('Exclude ID added');

                    }

               });
            
       
    
        return false;
     }); 


jQuery(".aal_delete_exclude_link").click(function() {
        
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
                    console.log('succes');                    
                    }
                });
            }

                return false;
        }); 



}); 

