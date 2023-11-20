
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
window.Vue = require('vue');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

/*Vue.component('autocomplete', function (resolve, reject) {
    setTimeout(function () {
        // Pass the component definition to the resolve callback
        console.log("todo chido")
        resolve({
            template: '<div>I am async!</div>'

        })
    }, 1000)
})*/
/*
Vue.component('autocomplete_riesgo',require('./components/Autocomplete.vue'));
const app = new Vue({
    el: '#app'
});
*/
