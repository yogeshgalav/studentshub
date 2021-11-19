import DashboardComponent from '../../views/common/dashboard.vue';
import ViewPost from '../../views/common/student-post-view.vue';
import NotificationsComponent from '../../views/common/notifications.vue';
import DoubtList from '../../views/doubt/doubt-list.vue';
import DoubtAnswer from '../../views/doubt/doubt-answers.vue';

const StudentRoutes = [
	{
		path: '/',
		component: DashboardComponent,
	},
	{ 
		path: '/notifications', 
		component: NotificationsComponent 
	},
	//Post Routes
	{
		path: '/post/:id',
		component: ViewPost,
		name: 'ViewPost',
	},
	//Doubt Routes
	{
		path: '/doubts',
		component: DoubtList,
	},
	{
		path: '/doubt/:doubtId',
		component: DoubtAnswer,
		name: 'DoubtAnswer',
	},
];

export default StudentRoutes;