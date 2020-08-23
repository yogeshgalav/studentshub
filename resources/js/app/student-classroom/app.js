
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';
Vue.component('MyPanelComponent', require('../../views/student-classroom/classroom.vue').default);
Vue.component('UnitAttemptComponent', require('../../views/student-classroom/unit-attempt/UnitAttemptWizard.vue').default);
Vue.component('DailyAttemptComponent', require('../../views/student-classroom/daily-attempt.vue').default);


//Dependencies
import StudentClassroomRoutes from './routes';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
//Vue Router Initialisation
const router = new VueRouter({
    routes:StudentClassroomRoutes,
    mode:'history'
});
import StudentClassroomStore from '../../store/student-classroom';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        classroom: StudentClassroomStore,
      }
});
//Vue App Initialisation
const app = new Vue({
    el: '#studentPanelApp',
    store,
    router
});
