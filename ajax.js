jQuery(function() {
        jQuery(".delete").click(function() {
        //$('#load').fadeIn();
        var commentContainer = jQuery(this).parent();
        var id = jQuery(this).attr("id");
        
            var data = {
			action: 'delete_link',
                        id: id
		};
       // var data= 'aal_action=delete&id='+ id ;
        
        jQuery.ajax({
        type: "POST",
        url: ajax_script.ajaxurl,
        data: data,
        cache: false,
        success: function(){
        commentContainer.slideUp('slow', function() {jQuery(this).remove();});
        //$('#load').fadeOut();
        }
        
        });
        
        return false;
        });
});
        