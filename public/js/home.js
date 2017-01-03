
define(['jquery', 'menu', 'exceptions'], function($, menu, e) {
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
        
        /**
         * Obtiene un parámetro específico de la url actual
         * @param {type} sParam
         * @returns {HomeL#2.Home.getUrlParameter.sParameterName|Boolean}
         */
        var getUrlParameter = function(sParam) {
            var pageUrl = decodeURIComponent(window.location.search.substring(1)), sURLVariables = pageUrl.split('&'), sParameterName, i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
        
        var setToken = function() {
            token = getUrlParameter("token");
        };        
    };

    return new Home();
});