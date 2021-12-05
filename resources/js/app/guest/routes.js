import WelcomeComponent from '../../views/guest/welcome';
import LoginComponent from '../../views/auth/login.vue';
import RegisterComponent from '../../views/auth/register.vue';
import ViewPost from '../../views/guest/guest-post-view.vue';
import MembershipComponent from '../../views/guest/MembershipComponent.vue';
import ForgotPasswordComponent from '../../views/auth/forgot-password.vue';
import CategoryComponent from '../../views/explore/category.vue';
import CourseComponent from '../../views/explore/course.vue';
import SubjectComponent from '../../views/explore/subject.vue';
import SearchComponent from '../../views/common/search.vue';

const routes = [
	{
		path: '/',
		name: 'welcome',
		component: WelcomeComponent,
		meta: {
			title: 'Student\'sHUB'
		}
	},
	{
		path: '/get-started',
		name: 'register',
		component: RegisterComponent,
		meta: {
			title: 'Get Started | Student\'sHUB'
		}
	},
	{
		path: '/membership-plan',
		name: 'membership',
		component: MembershipComponent,
		meta: {
			title: 'Membership | Student\'sHUB'
		}
	},
	{
		path: '/forgot-password',
		name: 'forgot-password',
		component: ForgotPasswordComponent
	},
	// {
	// 	path: '/auth/:provider/callback',
	// 	component: {
	// 		template: '<div class="auth-component"></div>'
	// 	}
	// },
	{
		path: '/post/:id',
		component: ViewPost,
		name: 'ViewPost', 
	},
	{
		path: '/category/:url',
		component: CategoryComponent
	},
	{
		path: '/course/:id',
		component: CourseComponent
	},
	{
		path: '/subject/:url',
		component: SubjectComponent
	},
	{
		path: '/search',
		component: SearchComponent
	},
];

export default routes;
