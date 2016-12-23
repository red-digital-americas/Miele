
define(['jquery'], function($) {
    var Menu = function() {
        var options = {};
        /**
         * 
         * @param {Object} config  
         *      buttonSelector
         * @returns {undefined}
         */

        this.init = function(config) {
            options = config;
            options.pageWrapper = $('#' + config.pageWrapper);
            options.togleButton = $('#' + config.buttonSelector);

            options.pageWrapper.addClass('menu-wrapper');
            buildContainers();
            setOptions();
            setButtonAction();
        };

        var setButtonAction = function() {
            options.togleButton.click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(".menu-wrapper").toggleClass("toggled");
            });
        };

        var buildContainers = function() {
            options.pageContentWrapper = $('<div>').addClass('page-content-wrapper');
            options.pageContentWrapper.append(options.pageWrapper);
            $('body').append(options.pageContentWrapper);
        };


        var setOptions = function() {
            var div = $('<div>', {id: "sidebar-wrapper"});
            var ul = buildRoot();

            $(options.options).each(function() {
                var li = $('<li>').append('<a href="#">' + this.title + '</a>');
                ul.append(li);
            });

            div.append(ul);
            options.pageWrapper.append(div);
        };

        var buildRoot = function() {
            var ul = $('<ul>', {class: "sidebar-nav"});
            setBrand(ul);
            return ul;
        };

        var setBrand = function(ul) {
            var brand = $('<li>', {class: "sidebar-brand"}).append('<a href="#">' + options.brandTitle + '</a>');
            return ul.append(brand);
        };
    };

    return new Menu();
});