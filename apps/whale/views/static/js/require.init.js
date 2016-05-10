requirejs.config({
    urlArgs: '_version=3',
    baseUrl: '/whale/static/js/',
    paths: {
        jquery: 'jquery.min',
        bootstrap: 'bootstrap.min',
        bsDatetimepicker: 'bootstrap-datepicker.min',
        bsDatetimepickerLocal: 'bootstrap-datepicker.zh-CN.min',
        metisMenu: 'jquery.metisMenu',
        sbadmin: 'sb-admin',
        jqueryui: 'jquery-ui-1.9.2.custom.min',
        jqueryuiLocal: 'jquery-ui-localize',
        jqueryform: 'jquery.form.min',
        whale: 'modules/whale'
    },
    shim: {
        bootstrap: {
            deps: ['jquery']
        },
        bsDatetimepicker: {
            deps: ['bootstrap']
        },
        bsDatetimepickerLocal: {
            deps: ['jquery', 'bootstrap', 'bsDatetimepicker']
        },
        metisMenu: {
            deps: ['jquery']
        },
        sbadmin: {
            deps: ['bootstrap']
        },
        jqueryui: {
            deps: ['jquery']
        },
        jqueryuiLocal: {
            deps: ['jqueryui']
        },
        jqueryform: {
            deps: ['jquery']
        },
        whale: {
            deps: ['jquery', 'bootstrap']
        }
    }
});
require(['jquery', 'bootstrap', 'metisMenu', 'sbadmin', 'jqueryui', 'whale']);
