import ProfileImage from './components/ProfileImage';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
var relativeTime = require('dayjs/plugin/relativeTime');
import { Link as RouterLink } from '@inertiajs/inertia-vue';
import { gtag } from 'ga-gtag';

export default {
	components:{
		ProfileImage,
		Loading,
		RouterLink
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
		$route() {
			const current_url = new URL(document.location);
			const params = current_url.toString().match(/^\d+|\d+\b|\d+(?=\w)/g)
				.map(function (v) {return +v;});
			if(process.env.NODE_ENV === 'local'){
				params.shift();
			}
			const query = Object.fromEntries(current_url.searchParams);
			return {
				'params':params,
				'query' :query,
			};
		},
		baseUrl() {
			return this.$page.props.baseUrl;
		},
		fileUrl() {
			return this.$page.props.fileUrl;
		},
		AuthUser(){
			return this.$page.props.AuthUser;
		},
		AuthStudent(){
			return this.$page.props.AuthStudent;
		},
		AuthTeacher(){
			return this.$page.props.AuthTeacher;
		},
		csrfToken() {
			return this.$page.props.csrfToken;
		},
		accessToken() {
			return localStorage.getItem('access_token');
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
		this.axios.defaults.headers.common = {
			'X-CSRF-TOKEN': this.csrfToken,
			'X-Requested-With': 'XMLHttpRequest'
		};
		this.$dayjs.extend(relativeTime);
		document.addEventListener('click', this.closeSidebar);
	},
	methods: {
		'$trans':function(file,string,defaultString){
			return window.lang[file][string] ? window.lang[file][string] : (defaultString ? defaultString : string);
		},
		toggleSidebar(e){
			e.preventDefault();
			var sidebar_section = document.getElementById('sidebar-section');
			if(!sidebar_section){
				window.location.href='/';
			}
			sidebar_section.classList.toggle('sidebar-section-active');
			// document.documentElement.classList.toggle('openNav');
			// var menu = document.querySelector('.nav-toggle'); // Using a class instead, see note below.
			// menu.classList.toggle('active');
		},
		closeSidebar(e){
			var container = document.getElementById('sidebar-section');
			var container2 = document.getElementById('nav-toggle');
			if(!container || !container2){
				return false;
			}
			if (!container.contains(e.target) && !container2.contains(e.target) && container.classList.contains('sidebar-section-active')) {
				e.preventDefault();
				container.classList.remove('sidebar-section-active');
				return false;
			}
		},
		goBack(){
			window.history.back();
		}
	}
};