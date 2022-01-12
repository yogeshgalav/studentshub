require('./bootstrap');

import Vue from 'vue';
import Vuex from 'vuex';
import { createInertiaApp } from '@inertiajs/inertia-vue';

import AuthStore from './store/auth';
import GuestStore from './store/guest';
import CommonStore from './store/common-store';

Vue.use(Vuex);
const store = new Vuex.Store({
	modules: {
		auth: AuthStore,
		guest:GuestStore,
		common: CommonStore,
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

//error tracking
// import * as Sentry from '@sentry/browser';
// import { Integrations } from '@sentry/tracing';
if(process.env.NODE_ENV === 'production'){
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

	const { Inertia } = require('@inertiajs/inertia');
	const { gtag, install } = require('ga-gtag');
	install('G-W2Z76KH2R6');
	Inertia.on('navigate', (event) => {
		gtag('event', 'page_view', {
			'page_location': event.detail.page.url
		});
	});
}

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
