
define(['jquery', 'menu'], function($, menu) {
    $(document).ready(function() {
        menu.init({
            buttonSelector: "menu-toggle",
            pageWrapper: "pageWrapper",
            brandTitle: "Miele",
            options: [
                {
                    title: "Home"
                },
                {
                    title: "Cerrar Sesión"
                }
            ]
        });
    });

    var Home = function() {
        this.init = function(token) {
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

    };

    return new Home();
});