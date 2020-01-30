
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

Vue.component('SidebarComponent', require('../../components/SidebarComponent').default);

//Dependencies
import StudentStore from '../../store/student';
import StudentRoutes from './routes';
import Vuex from 'vuex';
import VueRouter from 'vue-router';
Vue.use(Vuex);

Vue.use(VueRouter);
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
