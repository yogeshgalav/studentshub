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
	//Post Routes
	{
		path: '/post/:id',
		component: ViewPost,
		name: 'ViewPost',
	},
];

export default StudentRoutes;