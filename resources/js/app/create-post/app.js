
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

//Dependencies
import CreatePostStore from '../../store/create-post';
import CreatePostRoutes from './routes';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
Vue.use(Vuex);

Vue.use(VueRouter);
//Vue Router Initialisation
const router = new VueRouter({
    routes:CreatePostRoutes,
    mode:'history'
});

//Vue Router Initialisation
const store = new Vuex.Store(CreatePostStore);

//Vue App Initialisation
const app = new Vue({
    el: '#studentApp',
    store,
    router,
});
