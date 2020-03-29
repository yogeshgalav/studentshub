
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
import VueRouter from 'vue-router';
import StudentRoutes from './routes';
Vue.use(VueRouter);

//Vue Router Initialisation
const router = new VueRouter({
    routes:StudentRoutes,
    mode:'history'
});

import SeekerStore from '../../store/seeker';
import CommonStore from '../../store/common-store';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        seeker: SeekerStore,
        common: CommonStore,
      }
});

//Vue App Initialisation
const app = new Vue({
    el: '#seekerApp',
    store,
    router,
});
