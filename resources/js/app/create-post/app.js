
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
import Vuex from 'vuex';
Vue.use(Vuex);
Vue.component('SharePost', require('../../views/create-post/share-post.vue').default);

//Vue Router Initialisation
const store = new Vuex.Store(CreatePostStore);

//Vue App Initialisation
const app = new Vue({
	el: '#app',
	store,
});
