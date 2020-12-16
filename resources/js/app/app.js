import Vue from 'vue';
// import utils from '../helpers/utilities'
// Vue.prototype.$utils = utils

//Dependencies
import axios from 'axios';
import VueAxios from 'vue-axios';
import VModal from 'vue-js-modal';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

import VueSlimScroll from 'vue-slimscroll';
import VueLazyload from 'vue-lazyload';
Vue.use(VueLazyload);
Vue.use(VueSlimScroll);
// or with options
Vue.use(VueLazyload, {
	preLoad: 1.3,
	error: 'dist/error.png',
	loading: 'dist/loading.gif',
	attempt: 1
});
Vue.use(VModal, { dynamic: true, injectModalsContainer: true, scrollable:true });
Vue.use(VueAxios, axios);

Vue.mixin({
	components:{
		Loading
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
		bottomVisible() {
			const scrollY = window.scrollY;
			const visible = document.documentElement.clientHeight;
			const pageHeight = document.documentElement.scrollHeight;
			const bottomOfPage = visible + scrollY >= pageHeight;
			return bottomOfPage || pageHeight < visible;
		},
	}
});

export default Vue;
