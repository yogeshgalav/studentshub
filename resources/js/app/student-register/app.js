
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';
Vue.component('CheckIn', require('../../views/student-register/checkin').default);
Vue.component('EducationDetail', require('../../views/student-register/education-detail').default);

//Vue App Initialisation
const app = new Vue({
	el: '#app',
});
