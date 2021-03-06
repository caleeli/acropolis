import { BootstrapVue } from 'bootstrap-vue';
window._ = require('lodash');
const Vue = window.Vue = require('vue');
window.moment = require('moment');

// Vue global functions
Vue.prototype.moment = window.moment;
Vue.prototype.format_number = (number, decimals = 2, dec_point = '.', thousands_sep = ',') => {
    var n = !isFinite(+number) ? 0 : + number, 
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    toFixedFix = function (n, prec) {
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        var k = Math.pow(10, prec);
        return Math.round(n * k) / k;
    },
    s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
};

global.meses = [
    {num: 1, nombre: 'Enero'},
    {num: 2, nombre: 'Febrero'},
    {num: 3, nombre: 'Marzo'},
    {num: 4, nombre: 'Abril'},
    {num: 5, nombre: 'Mayo'},
    {num: 6, nombre: 'Junio'},
    {num: 7, nombre: 'Julio'},
    {num: 8, nombre: 'Agosto'},
    {num: 9, nombre: 'Septiembre'},
    {num: 10, nombre: 'Octubre'},
    {num: 11, nombre: 'Noviembre'},
    {num: 12, nombre: 'Diciembre'},
];

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) { }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = "/api/data/";

/**
 * Get meta tag value
 * @param {string} name
 * @returns {string}
 */
function meta(name) {
    let tag = document.head.querySelector('meta[name="' + name + '"]');
    return tag ? tag.content : null;
}

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = meta('csrf-token');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
}

window.userId = meta('user-id') * 1;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

let broadcasterHost = meta("broadcaster-host");
if (broadcasterHost) {
    window.io = require('socket.io-client');

    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: meta("broadcaster-host"),
        key: meta("broadcaster-key"),
    });
}

/**
 * Setup Vue Jdd Components
 */
const VueJddComponents = require('vue-jdd-components');
window.Vue.use(VueJddComponents.default, { jQuery: window.$ });
Vue.use(BootstrapVue);
Vue.mixin(require('./mixins/trans'));

/**
 * Config Vue-Router
 */
import VueRouter from 'vue-router';
Vue.use(VueRouter);
window.router = new VueRouter({
    routes: []
});
