
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./../bootstrap');
<<<<<<< HEAD
=======
// require('../../atlantis/js/slick');
require('../../atlantis/js/slick.min');
require('../../atlantis/js/core/jquery.3.2.1.min');
>>>>>>> 75927919d6348c0ac26c47b4f93a3be14b98b508

// window.Vue = require('vue').default;
import Vue from 'vue';

//Dependencies
import store from './store'
import axios from 'axios'
import VueAxios from 'vue-axios'
import VModal from 'vue-js-modal'
import router from './router';
import VueLazyload from 'vue-lazyload'
 
Vue.use(VueLazyload)

// or with options
Vue.use(VueLazyload, {
  preLoad: 1.3,
  error: 'dist/error.png',
  loading: 'dist/loading.gif',
  attempt: 1
})
Vue.use(VModal, { dynamic: true, injectModalsContainer: true })
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
        redirectPostView(post_id){
            this.$router.push({path:'/post/'+post_id})
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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router,
});
