require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';
import { createInertiaApp } from '@inertiajs/inertia-vue';

import AuthStore from './store/auth';
import ClassroomStore from './store/classroom';
import GuestStore from './store/guest';
import CommonStore from './store/common-store';
import PostStore from './store/create-post';

Vue.use(Vuex);
const store = new Vuex.Store({
	modules: {
		auth: AuthStore,
		classroom: ClassroomStore,
		guest:GuestStore,
		common: CommonStore,
		post: PostStore,
	}
});

//Dependencies
import axios from 'axios';
import VueAxios from 'vue-axios';

import Dayjs from 'vue-dayjs';
import VueLazyload from 'vue-lazyload';

Vue.use(VueLazyload);
Vue.use(Dayjs, {
	lang:'en',
	filters: {
		ago: 'ago',
	}
});
// or with options
// Vue.use(VueLazyload, {
// 	preLoad: 1.3,
// 	error: 'dist/error.png',
// 	loading: 'dist/loading.gif',
// 	attempt: 1
// });
Vue.use(VueAxios, axios);
const { Inertia } = require('@inertiajs/inertia');
const { gtag, install } = require('ga-gtag');

if(process.env.NODE_ENV === 'production'){
	Vue.config.devtools = false;
	Vue.config.debug = false;
	Vue.config.silent = true;
	install('G-W2Z76KH2R6');
}

Inertia.on('navigate', (event) => {
	gtag('event', 'page_view', {
		'page_location': event.detail.page.url
	});
});

Object.defineProperty(Vue.prototype, '$gtag', {
	value: gtag,
});
import VueLoading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(VueLoading);
	
import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init();
InertiaProgress.init({
	// The delay after which the progress bar will
	// appear during navigation, in milliseconds.
	delay: 250,
  
	// The color of the progress bar.
	color: '#10069f',
  
	// Whether to include the default NProgress styles.
	includeCSS: true,
  
	// Whether the NProgress spinner will be shown.
	showSpinner: true,
  });
  
import Layout from '@/Layouts/SidebarLayout.vue';
import GlobalMixin from '@/global-mixin.js';
Vue.mixin(GlobalMixin);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
createInertiaApp({
	resolve: name => import(`./Pages/${name}`).then(module=>{
		if(!module.default.layout){
			module.default.layout = Layout;
		}
		return module.default;
	}),
	setup({ el, App, props }) {
	  new Vue({
			store,
			render: h => h(App, props),
	  }).$mount(el);
	},
});
