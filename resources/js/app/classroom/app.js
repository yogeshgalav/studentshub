
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

Vue.component('ClassroomComponent', require('../../views/classroom/classroom.vue').default);
Vue.component('ClassroomListComponent', require('../../views/classroom/classroom-list.vue').default);

import ClassroomStore from '../../store/classroom';
import Vuex from 'vuex';
Vue.use(Vuex);
//Vue Router Initialisation
const store = new Vuex.Store({
    modules: {
        classroom: ClassroomStore,
      }
});
//Vue App Initialisation
const app = new Vue({
    el: '#classroomApp',
    store,
});
