
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';
Vue.component('MyPanelComponent', require('../../views/student-panel/my-panel/index.vue').default);
Vue.component('DailyAssignmentComponent', require('../../views/student-panel/daily-assignment.vue').default);
Vue.component('UnitAttemptComponent', require('../../views/student-panel/unit-attempt/UnitAttemptWizard.vue').default);


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
    store
});
