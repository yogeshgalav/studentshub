
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

//Dependencies
import InstituteRoutes from './routes';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
//Vue Router Initialisation
const router = new VueRouter({
    routes:InstituteRoutes,
    mode:'history'
});


import InstituteStore from '../../store/seeker';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        common: InstituteStore,
      }
});
//Vue App Initialisation
const app = new Vue({
    el: '#instituteApp',
    store,
    router,
});
