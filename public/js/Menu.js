
define(['jquery'], function($){
    $(document).ready(function(){
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            $("#wrapper").toggleClass("toggled");
        });
    });
    
    return true;
});