
define(['jquery', 'system', 'menu'], function($, system, menu) {
    var Survey = function() {
        var token = null;
        this.init = function() {
            setTokenValue();
            resizeContent();
            console.log("token");
            console.log(token);
        };
        
        var resizeContent = function(){
            $('#boxContent').height($(window).height() - 80);
            buildMenu();
        };
        
        var buildMenu = function() {
                menu.init({
                    buttonSelector: "menu-toggle",
                    pageWrapper: "pageWrapper",
                    brandTitle: "Miele",
                    options: [
//                        closeSessionOption()
                    ]
                });
        };
        
        var setTokenValue = function(){
            token = system.getUrlParameter("token");
        };
        
        var getToken = function(){
            return token;
        };
    };

    return new Survey();
});