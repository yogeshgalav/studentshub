
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./../bootstrap');
require('../../atlantis/js/core/jquery.3.2.1.min');
require( '../../atlantis/js/plugin/jquery-scrollbar/jquery.scrollbar.min' );
require( '../../atlantis/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min' );
require('../../atlantis/js/atlantis');

// window.Vue = require('vue').default;
import Vue from 'vue';
Vue.component('StudentRegister', require('./student-register').default);

//Dependencies
import axios from 'axios'
import VueAxios from 'vue-axios'
Vue.mixin({
    methods: {
        '$trans':function(file,string,defaultString){
            return window.lang[file][string] ? window.lang[file][string] : (defaultString ? defaultString : string);
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

//Vue App Initialisation
const app = new Vue({
    el: '#studentRegisterApp',
});
