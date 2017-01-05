
define(['jquery', 'system', 'menu', 'exceptions'], function($, system, menu, e) {
    var Survey = function() {
        var token = null;
        this.init = function() {
            setTokenValue();
            resizeContent();
            buildSurveyBoxes();
        };

        var resizeContent = function() {
            $('#boxContent').height($(window).height() - 80);
            buildMenu();
        };

        var buildMenu = function() {
            menu.init({
                buttonSelector: "menu-toggle",
                pageWrapper: "pageWrapper",
                brandTitle: "Miele",
                options: [
                    system.menu.option.goToHome(token),
                    system.menu.option.closeSessionOption(token)
                ]
            });
        };

        var buildSurveyBoxes = function() {
            var surveyType = getSurveysTypes();
            $(surveyType).each(function() {
                if (typeof this.id === undefined || typeof this.name === undefined)
                    return true;    /* skip */
                $('#boxContent').append(buildBox(this));
            });
        };

        var buildBox = function(survey) {
            var type = $('<div>', {class: "survey-type-title"}).append((survey.survey_type[0] !== undefined) ? survey.survey_type[0].name: "");
            var name = $('<div>', {class: "survey-title"}).append(survey.name);
            var icon = $('<div>', {class: "surveyType-icon"}).append($('<img>', {src: (survey.survey_type[0] !== undefined) ? survey.survey_type[0].icon: ""}));
            var button = $('<div>', {class: "button-play"}).append($('<img>', {src: "/img/play-button.png"}));
            var box = $('<div>', {class: "box"}).append(type).append(icon).append(button).append(name);
            
            return $('<div>', {class: "col-sm-4"}).append(box);
        };

        /**
         * Get the list of surveys types
         * @returns {undefined}
         */
        var getSurveysTypes = function() {
            var surveys = null;
            $.ajax({
                method: "POST",
                async: false,
                cache: false,
                data: {},
                url: system.getApiPath() + "/survey/?token=" + token,
                success: function(response, textStatus, jqXHR) {
                    if (typeof response !== 'object')
                        e.error("Respuesta inesperada", response);

                    surveys = response;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    e.error(jqXHR.statusText + " - " + jqXHR.status, jqXHR.responseText);
                }
            });
            return surveys;
        };

        var setTokenValue = function() {
            token = system.getUrlParameter("token");
        };

        var getToken = function() {
            return token;
        };
    };

    return new Survey();
});