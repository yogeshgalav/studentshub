
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

//Dependencies
import ProfileRoutes from './routes';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
//Vue Router Initialisation
const router = new VueRouter({
    routes:ProfileRoutes,
    mode:'history'
});


import ProfileStore from '../../store/seeker';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        common: ProfileStore,
      }
});
//Vue App Initialisation
const app = new Vue({
    el: '#profileApp',
    store,
    router,
});
