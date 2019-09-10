
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('../../atlantis/js/core/jquery.3.2.1.min');
require( '../../atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min' );
require( '../../atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min' );
require('../../atlantis/js/atlantis');

// window.Vue = require('vue').default;
import Vue from 'vue';

Vue.component('SidebarComponent', require('./../components/SidebarComponent').default);

//Dependencies
import axios from 'axios'
import VueAxios from 'vue-axios'
import VModal from 'vue-js-modal'
import StudentStore from './store/index';
import StudentRoutes from './routes';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

Vue.use(Vuex);
Vue.use(VModal, { dynamic: true, injectModalsContainer: true })
Vue.use(VueAxios, axios);
Vue.use(VueRouter);


Vue.mixin({
    methods: {
        '$trans':function(file,string,defaultString){
            return window.lang[file][string] ? window.lang[file][string] : (defaultString ? defaultString : string);
        },
        getIdFromUrl(){
            let url = window.location.href;
            let url_segments=url.split('/');
            let id=url_segments[url_segments.length-1].split('?')[0];
            return Number(id);
        },
        redirect(url){
            window.location.href=url;
        },
        getUrlParameters(){
            return decodeURI(window.location.search)
            .replace('?', '')
            .split('&')
            .map(param => param.split('='))
            .reduce((values, [ key, value ]) => {
                values[ key ] = value
                return values
            }, {});
        },
        catchResponse(err){
            switch(err.response.status){
                case 401:
                    localStorage.removeItem('access_token');
                    this.redirect('/login');
                break;
                case 422:
                    this.form_errors=err.response.data.errors;
                break;
                default:
                    console.log("Error code:"+err.response.status);
                    console.log(err.response.data);
                break;
            }
        },
    },
    computed: {
        baseUrl() {
            return window.App.baseUrl;
        },
        fileUrl() {
            return window.App.fileUrl;
        },
        signedIn(){
            return window.App.signedIn;
        },
        AuthUser(){
            return window.App.AuthUser;
        },
        AuthUserType(){
            return window.App.AuthUserType;
        },
        csrfToken() {
            return window.App.csrfToken;
        },
        accessToken() {
            return localStorage.getItem('access_token');
        },
    },
    mounted(){
        window.axios.defaults.headers.common = {
            'X-CSRF-TOKEN': this.csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Authorization' : "Bearer "+this.accessToken,
        };
    }
});

//Vue Router Initialisation
const router = new VueRouter({
    routes:StudentRoutes,
    mode:'history'
});

//Vue Router Initialisation
const store = new Vuex.Store(StudentStore);

//Vue App Initialisation
const app = new Vue({
    el: '#studentApp',
    store,
    router,
});
