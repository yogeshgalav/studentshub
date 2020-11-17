
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';
//Dependencies
import TeacherClassroomRoutes from './routes';
import VueRouter from 'vue-router';

Vue.use(VueRouter);
//Vue Router Initialisation
const router = new VueRouter({
    routes:TeacherClassroomRoutes,
    mode:'history'
});
Vue.component('ClassroomComponent', require('../../views/teacher-classroom/classroom.vue').default);
Vue.component('ClassroomListComponent', require('../../views/teacher-classroom/classroom-list.vue').default);
Vue.component('CreateClassroomComponent', require('../../views/teacher-classroom/create-classroom.vue').default);


import TeacherClassroomStore from '../../store/teacher-classroom';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        classroom: TeacherClassroomStore,
      }
});
//Vue App Initialisation
const app = new Vue({
    el: '#classroomApp',
    store,
    router,
});
