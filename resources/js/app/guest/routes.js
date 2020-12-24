import WelcomeComponent from '../../views/guest/welcome';
import ExploreComponent from '../../views/explore/explore.vue';
import LoginComponent from '../../views/auth/login.vue';
import RegisterComponent from '../../views/auth/register.vue';
import ViewPost from '../../views/guest/guest-post-view.vue';
import MembershipComponent from '../../views/guest/MembershipComponent.vue';
import ForgotPasswordComponent from '../../views/auth/forgot-password.vue';

const routes = [
	{ 
		path: '/', name:'welcome', 
		component: WelcomeComponent, 
		meta: {
			title: 'Student\'sHUB',
		}
	},
	{ path: '/explore/:subject', component: ExploreComponent },
	{ path: '/explore', component: ExploreComponent },
	{ path: '/login', name:'login', component: LoginComponent },
	{ path: '/get-started', name:'register', component: RegisterComponent },
	{ path: '/membership-plan', name:'membership', component: MembershipComponent },
	{ path: '/forgot-password', name:'forgot-password', component: ForgotPasswordComponent },
	{
		path: '/auth/:provider/callback',
		component: {
			template: '<div class="auth-component"></div>'
		}
	},
	{
		path: '/post/:id',
		component: ViewPost,
		name: 'ViewPost',
	}
];

export default routes;