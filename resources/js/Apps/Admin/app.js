/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import axios from "axios";

require('../../bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('standard-button', require('../../Components/Buttons/StandardButton').default);
// Vue.component('danger-button', require('./components/Buttons/DangerButton.vue').default);

import router from "./router/router";
import store from "./Store";
import http from "./http";

http.interceptors.request.use((config) => {
    config.headers.common['Authorization'] = `Bearer ${store.getters.access_token}`;
    return config;
});

http.interceptors.response.use((response) => {
    return response;
}, (error) => {
    return error;
})

// store.dispatch('refresh')
//     .then(response => {
//         store.dispatch('checkRoles');
//     })
//     .catch((error) => {
//         router.replace('/manage/login')
//     }) ;
const App = require("./pages/App").default;
const app = new window.Vue({
    el: '#app',
    router,
    store: store,
    components: {
        App: App
    }
});
