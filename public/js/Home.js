
define(['jquery', 'menu'], function($, menu) {
    var Home = function() {
        var token = null;

        this.init = function(token_) {
            setToken(token_);
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

        var setToken = function(token_) {
            token = token_;
        };

        var buildMenu = function() {
            $(document).ready(function() {
                menu.init({
                    buttonSelector: "menu-toggle",
                    pageWrapper: "pageWrapper",
                    brandTitle: "Miele",
                    options: [
                        {
                            title: "Cerrar Sesión",

                            onclick: {
                                ajax: {
                                    url: "/auth/invalidate",
                                    params: {token: token},
                                    method: "POST",
                                    async: false,
                                    suceess: function(response, textStatus, jqXHR) {
                                        console.log("success");
                                        console.log(response);
                                        console.log(textStatus);
                                        console.log(jqXHR);
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.log("error");
                                        console.log(jqXHR);
                                        console.log(textStatus);
                                        console.log(errorThrown);
                                    }
                                }
                            }
                        }
                    ]
                });
            });
        };

    };

    return new Home();
});