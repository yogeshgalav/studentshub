
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

//Dependencies
import StudentPanelRoutes from './routes';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
//Vue Router Initialisation
const router = new VueRouter({
    routes:StudentPanelRoutes,
    mode:'history'
});


import StudentPanelStore from '../../store/student-panel';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        studentPanel: StudentPanelStore,
      }
});
//Vue App Initialisation
const app = new Vue({
    el: '#studentPanelApp',
    store,
    router,
});
