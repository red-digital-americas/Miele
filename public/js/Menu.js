
define(['jquery', 'exceptions'], function($, e) {
    var Menu = function() {
        var urlBase = document.location.origin;
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
                var li = buildList(this);
                ul.append(li);
            });

            div.append(ul);
            options.pageWrapper.append(div);
        };

        var buildList = function(option) {
            var li = $('<li>').append('<a href="#">' + option.title + '</a>');
            
            if (option.onclick !== undefined)
                li.click(function() {
                    onclick(option.onclick);
                });

            return li;
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

        var onclick = function(option) {
            if(typeof option === "function")
                return option();
            
            if (option.ajax === undefined)
                return 0;

            var ajax = option.ajax;
            if (ajax.method === undefined)
                ajax.method = "POST";
            if (ajax.type === undefined)
                ajax.type = true;
            if (ajax.cache === undefined)
                ajax.cache = false;
            if (ajax.params === undefined)
                ajax.params = {};
            
            $.ajax({
                method: ajax.method,
                async: ajax.type,
                cache: ajax.cache,
                data: ajax.params,
                url: getUrl(ajax.url)+"?"+$.param(ajax.params),
//                contents: "json",
                success: function(response, textStatus, jqXHR) {
                    if (typeof ajax.success === "function")
                        return ajax.success(response, textStatus, jqXHR);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (typeof ajax.error === 'function')
                        return ajax.error(jqXHR, textStatus, errorThrown);

                    e.error(jqXHR.statusText+" - "+jqXHR.status, jqXHR.responseText);
                }
            });
        };

        var getUrl = function(url) {
            if (url === undefined)
                return "";
            
            return  (url.charAt(0) === "/")?  (urlBase + url):  urlBase + "/" + url;
        };
    };

    return new Menu();
});