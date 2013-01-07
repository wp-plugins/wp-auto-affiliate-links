jQuery(document).ready(function() { 

    // setup ul.tabs to work as tabs for each div directly under div.panes
    $("ul.tabs").tabs("div.panes > div");
 

    function isValidURL(url){
    var RegExp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

    if(RegExp.test(url)){
        return true;
    }else{
        return false;
    }

    }

    jQuery(".delete").click(function() {
        
    var answer = confirm("Are you sure you want to delete this automated link?");
    
        if (answer){
        
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
        }

                return false;
        }); // Delete Link 


    jQuery("#add_link").submit(function() {
        
        var keyword = jQuery("#formkeywords").val();
        var link = jQuery("#formlink").val();
        
        if(isValidURL(link)){
        
        if(keyword!=''){
        
            jQuery("#formlink").val("");
            jQuery("#formkeywords").val("");

            var data = {
                        action: 'add_link',
                        link: link,
                        keywords:keyword
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
            
            }else alert('Keyword must not be empty');
       
        }else alert('URL incorect');
    
        return false;
     }); 
     
    //Add new link

}); 

