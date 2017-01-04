
define(['jquery', 'menu', 'exceptions', 'system'], function($, menu, e, system) {
    var Home = function() {
        var token = null;

        this.init = function() {
            setToken();
            buildMenu();
            $(window).on('orientationchange', resizeWrapper);

            $('.container').css({width: $(window).width()});
            $('.productos-content').height($(window).height());
            $('.encuestas-content').height($(window).height());

            $('.option').click(function(e) {
                e.preventDefault();
                window.location.href = document.location.origin + "/" + $(this).attr('option') + "/?token=" + token;
            });
        };

        var resizeWrapper = function() {
            $('.container').css({width: $(window).width()});
            $('.productos-content').height($(window).height());
            $('.encuestas-content').height($(window).height());
        };
        
        /**
         * Construye el menú de la interfaz actual
         * @returns {undefined}
         */
        var buildMenu = function() {
            $(document).ready(function() {
                menu.init({
                    buttonSelector: "menu-toggle",
                    pageWrapper: "pageWrapper",
                    brandTitle: "Miele",
                    options: [
                        closeSessionOption()
                    ]
                });
            });
        };
        
        /**
         * Cierra sesión
         * @returns {HomeL#2.Home.closeSessionOption.HomeAnonym$4}
         */
        var closeSessionOption = function() {
            return {
                title: "Cerrar Sesión",
                onclick: {
                    ajax: {
                        url: "/api/v1/auth/invalidate",
                        params: {"token": token},
                        method: "POST",
                        async: false,
                        success: function(response, textStatus, jqXHR) {
                            if(typeof response !== "object")
                                e.error(response);
                            
                            if(response.status)
                                window.location.href = document.location.origin+"/login/";
                            else
                                e.error("Error", response.message);
                        }
                    }
                }
            };
        };        
        
        var setToken = function() {
            token = system.getUrlParameter("token");
        };        
    };

    return new Home();
});