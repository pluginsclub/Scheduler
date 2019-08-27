(function( $ ) {
 
    "use strict";

 $(document).ready(function(){
    $("#reply-title").click(function(){
      $("#commentform").slideToggle("slow");
    });
  });

})(jQuery);