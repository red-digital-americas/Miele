
define(['jquery'], function($) {
    var index = function() {
        this.init = function() {
            $(document).ready(function() {
                setTimeout(function() {
                    window.location.href = document.location.origin + "/login";
                }, 2000);
            });

        };
    };

    return new index();
});