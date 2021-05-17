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
import NotificationsDropdown from '../components/NotificationsDropdown.vue';

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

//error tracking
// import * as Sentry from '@sentry/browser';
// import { Integrations } from '@sentry/tracing';
if(window.App.mode==='production'){
	// Sentry.init({
	// 	Vue,
	// 	dsn: 'https://82c7fe80c97f4826818ae008c4d22c7d@o499194.ingest.sentry.io/5577443',
	// 	autoSessionTracking: true,
	// 	integrations: [
	// 		new Integrations.BrowserTracing(),
	// 	],

	// 	// We recommend adjusting this value in production, or using tracesSampler
	// 	// for finer control
	// 	tracesSampleRate: 1.0,
	// });
	Vue.config.devtools = false;
	Vue.config.debug = false;
	Vue.config.silent = true;
}
Vue.mixin({
	components:{
		NotificationsDropdown,
		ProfileImage,
		Loading
	},
	data(){
		return {
			showMobileLogoBar:true,
			reportColorCodes: ['#10069F', '#963CBD', '#00C1D5', '#F39C12', '#1D7BB9', '#95A5A6', '#EABD0A'],
			reportColorClasses: [
				'text-blue',
				'text-accent',
				'text-dark-cyan',
				'text-dark-yellow',
				'text-nice-blue',
				'text-metal',
				'text-light-yellow',
			],
		};
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
		window.addEventListener('scroll', ()=>{
			let headerMobile = document.getElementById('header_mobile');
			if (headerMobile){
				var currentScrollPos = window.pageYOffset;
				if (prevScrollpos > currentScrollPos) {
					this.showMobileLogoBar = true;
				} else {
					this.showMobileLogoBar = false;
				}
				prevScrollpos = currentScrollPos;
			}
		});
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
			var menu = document.querySelector('.nav-toggle'); // Using a class instead, see note below.
			menu.classList.toggle('active');
		},
		closeSidebar(e){
			var container = document.getElementById('sidebarContainer');
			var container2 = document.getElementById('nav-toggle');
			if(!container || !container2){
				return false;
			}
			if (!container.contains(e.target) && !container2.contains(e.target) && document.documentElement.classList.contains('openNav')) {
				document.documentElement.classList.remove('openNav');
				e.preventDefault();
				return false;
			}
		},
		divideArrayIntoSubgroups(array,label){
			return array.map(node=>{
				new_node=[];
				let label_index = new_node.findIndex(node2=>node2[label]===node[label]);
				if(label_index > -1){
					new_node[label_index]['subgroup'] = [];
					new_node[label_index]['subgroup'].push(node);
				}else{
					let subgroup = [];
					subgroup.push(node);
					new_node.push({
						'key':node[label],
						'subgroup':subgroup,
					});
				}
				return new_node;
			});
		}
	}
});

export default Vue;
