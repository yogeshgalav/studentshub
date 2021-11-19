import DashboardComponent from '../../views/common/dashboard.vue';
import MyCourse from '../../views/common/my-course.vue';
import MoreAppComponent from '../../views/common/more-app.vue';

const StudentRoutes = [
	{
		path: '/',
		component: DashboardComponent,
	},
	{
		path: '/my-course',
		component: MyCourse,
	},
	{ path: '/more-apps', component: MoreAppComponent },

];

export default StudentRoutes;