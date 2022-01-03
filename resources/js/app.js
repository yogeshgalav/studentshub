import Vue from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue';

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

//Dependencies
import axios from 'axios';
import VueAxios from 'vue-axios';

import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import Dayjs from 'vue-dayjs';
import ProfileImage from '../components/ProfileImage';
import NotificationsDropdown from '../components/NotificationsDropdown.vue';
import VueLazyload from 'vue-lazyload';
var relativeTime = require('dayjs/plugin/relativeTime');

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

	const { Inertia } = require('@inertiajs/inertia');
	const { gtag, install } = require('@ga-gtag');
	install('UA-#########-#');
	Inertia.on('navigate', (event) => {
		gtag('event', 'page_view', {
			'page_location': event.detail.page.url
		});
	});
}

import GlobalMixin from './global-mixin.js';
Vue.mixin(GlobalMixin);

import AuthLayout from './Layouts/AuthLayout';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
createInertiaApp({
	resolve: name => {
		const page = require(`./Pages/${name}`).default;
		page.layout = page.layout || AuthLayout;
		return page;
	},
	title: title => `${title} - Student's Hub`,
	setup({ el, App, props }) {
	  new Vue({
			store,
			router,
			render: h => h(App, props),
	  }).$mount(el);
	},
});
