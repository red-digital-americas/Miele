/* global require */

require.config({
    baseUrl: '../',
    paths: {
        jquery: 'apis/jquery-3.1.1.min',
        bootstrapjs: 'apis/bootstrap/js/bootstrap.min',
        login: 'js/login',
        alerts: 'js/Alerts',
        validator: 'js/Validator',
        exceptions: 'js/Exceptions'
    },
    shim: {
        jquery: {
            exports: 'jQuery'
        },
        "bootstrapjs": {"deps": ['jquery']}
    }
});