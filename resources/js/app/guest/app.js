
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

// window.Vue = require('vue').default;
import Vue from '../app';

//Dependencies
import router from './router';
import Vuex from 'vuex';
import AuthStore from '../../store/auth';
import GuestStore from '../../store/guest';
import CommonStore from '../../store/common-store';

Vue.use(Vuex);
const store = new Vuex.Store({
	modules: {
		auth: AuthStore,
		guest:GuestStore,
		common: CommonStore,
	}
});
import VueGtag from 'vue-gtag';
if(window.App.mode==='production'){
	Vue.use(VueGtag, {
		config: { id: 'UA-1234567-1' }
	});
}
Vue.component('ResetPasswordComponent', require('../../views/auth/reset-password.vue').default);
// Vue.component('FeedbackComponent', require('../../views/user/feedback.vue').default);
// Vue.component('contactusComponent', require('../../views/user/contactus.vue').default);
Vue.component('FeedbackComponent', require('../../views/guest/feedback.vue').default);
Vue.component('ContactusComponent', require('../../views/guest/Contactus.vue').default);
Vue.component('FaqComponent', require('../../views/guest/Faq.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
	el: '#app',
	store,
	router,
});
