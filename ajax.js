jQuery(document).ready(function() { 
   
    jQuery(".delete").click(function() {
        var linkContainer = jQuery(this).parent();
        var id = jQuery(this).attr("id");
        var data = {action: 'delete_link',id: id};
        
            jQuery.ajax({
                    type: "POST",
                    url: ajax_script.ajaxurl,
                    data: data,
                    cache: false,
                    success: function(){
                    linkContainer.slideUp('slow', function() {jQuery(this).remove();});
                                        }
                });

                return false;
        }); // Delete Link 


    jQuery("#add_link").submit(function() {
        
        var keyword = jQuery("#formkeywords").val();
        var link = jQuery("#formlink").val();
        
        jQuery("#formlink").val("");
        jQuery("#formkeywords").val("");
        
        var data = {
		    action: 'add_link',
                    link: link,
                    keyword:keyword
                   };
               
        jQuery.ajax({
        type: "POST",
        url: ajax_script.ajaxurl,
        data: data,
        cache: false,
        success: function(){
        
        jQuery(".links").append('<li>Link: <input style="margin: 5px 10px;width: 250px;" type="text" name="link" value="'+link+'" />Keywords: <input style="margin: 5px 10px;width: 110px;" type="text" name="keywords" value="'+keyword+'" /></li>');

        }
        
        });
        
        return false;
     }); 
     
    //Add new link

}); 
