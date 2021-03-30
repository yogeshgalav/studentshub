import Vue from 'vue';
// import utils from '../helpers/utilities'
// Vue.prototype.$utils = utils

//Dependencies
import axios from 'axios';
import VueAxios from 'vue-axios';
import VModal from 'vue-js-modal';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Dayjs from 'vue-dayjs';
import ProfileImage from '../components/ProfileImage';

import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload);
Vue.use(Dayjs, {
	lang:'en',
	filters: {
		ago: 'ago',
	}
});

// or with options
Vue.use(VueLazyload, {
	preLoad: 1.3,
	error: 'dist/error.png',
	loading: 'dist/loading.gif',
	attempt: 1
});
Vue.use(VModal, { dynamic: true, injectModalsContainer: true, scrollable:true });
Vue.use(VueAxios, axios);
Vue.component('NotificationsDropdown', require('../components/NotificationsDropdown.vue').default);

//error tracking
import * as Sentry from '@sentry/browser';
import { Integrations } from '@sentry/tracing';
if(window.App.mode==='production'){
	Sentry.init({
		Vue,
		dsn: 'https://82c7fe80c97f4826818ae008c4d22c7d@o499194.ingest.sentry.io/5577443',
		autoSessionTracking: true,
		integrations: [
			new Integrations.BrowserTracing(),
		],

		// We recommend adjusting this value in production, or using tracesSampler
		// for finer control
		tracesSampleRate: 1.0,
	});
	Vue.config.devtools = false;
	Vue.config.debug = false;
	Vue.config.silent = true;
}
Vue.mixin({
	components:{
		Loading,
		ProfileImage
	},
	computed: {
		baseUrl() {
			return window.App.baseUrl;
		},
		fileUrl() {
			return window.App.fileUrl;
		},
		signedIn(){
			return window.App.signedIn;
		},
		AuthUser(){
			return window.App.AuthUser;
		},
		AuthStudent(){
			return window.App.AuthStudent;
		},
		AuthTeacher(){
			return window.App.AuthTeacher;
		},
		csrfToken() {
			return window.App.csrfToken;
		},
		accessToken() {
			return localStorage.getItem('access_token');
		},
		catchResponse(err){
			switch (err.response.status) {
			case 401:
				this.redirect('/login');
				break;
			case 422:
				let fieldErrors = [];
				for (let [index, field] of Object.entries(err.response.data.errors)) {
					fieldErrors = field.map(msg => {
						return { 'field': index, msg };
					});
					field = this.$validator.fields.find({ name: index });
					fieldErrors.forEach(error => {
						error.id = field.id;
						this.errors.add(error);
					});
					field.setFlags({
						valid: !!fieldErrors.length,
						dirty: true
					});
				};
				break;
			default:
				console.error('Error code:' + err.response.status); // eslint-disable-line no-console
				console.error(err.response.data); // eslint-disable-line no-console
				break;
			}
			return true;
		},
		letters() {
			let letters = [];
			for (let i = 'A'.charCodeAt(0); i <= 'Z'.charCodeAt(0); i++) {
				letters.push(String.fromCharCode([i]));
			}
			return letters;
		},
	},
	mounted(){
		window.axios.defaults.headers.common = {
			'X-CSRF-TOKEN': this.csrfToken,
			'X-Requested-With': 'XMLHttpRequest'
		};
		var prevScrollpos = window.pageYOffset;
		window.onscroll = function() {
			let headerMobile = document.getElementById('header_mobile');
			if (headerMobile){
				var currentScrollPos = window.pageYOffset;
				if (prevScrollpos > currentScrollPos) {
					headerMobile.style.top = '0';
				} else {
					headerMobile.style.top = '-50px';
				}
				prevScrollpos = currentScrollPos;
			}
		};
		document.addEventListener('click', this.closeSidebar);
	},
	methods: {
		'$trans':function(file,string,defaultString){
			return window.lang[file][string] ? window.lang[file][string] : (defaultString ? defaultString : string);
		},
		redirectPostView(post){
			document.title = post.heading;
		},
		toggleSidebar(e){
			e.preventDefault();
			document.documentElement.classList.toggle('openNav');
		},
		closeSidebar(e){
			//e.preventDefault();
			var container = document.getElementById('sidebarContainer');
			var container2 = document.getElementById('nav-toggle');
			if(!container || !container2){
				return false;
			}
			if (!container.contains(e.target) && !container2.contains(e.target) && document.documentElement.classList.contains('openNav')) {
				document.documentElement.classList.remove('openNav');
			}
		}
	}
});

export default Vue;
