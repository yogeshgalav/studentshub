import DashboardComponent from '../../views/common/dashboard.vue';
import ViewPost from '../../views/common/student-post-view.vue';
import ExploreComponent from '../../views/explore/explore.vue';
import NotificationsComponent from '../../views/common/notifications.vue';

const StudentRoutes = [
	{
		path: '/',
		component: DashboardComponent,
	},
	{ path: '/notifications', component: NotificationsComponent },
	{ path: '*', redirect: '/' },
	//Post Routes
	{
		path: '/post/:id',
		component: ViewPost,
		name: 'ViewPost',
		meta: {
			title: 'Post',
		}
	},
];

export default StudentRoutes;