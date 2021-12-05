import DashboardComponent from '../../views/common/dashboard.vue';
import MyCourse from '../../views/common/my-course.vue';
import MyInstitute from '../../views/common/my-institute.vue';
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
	{
		path: '/my-institute',
		component: MyInstitute,
	},
	{ path: '/more-apps', component: MoreAppComponent },

];

export default StudentRoutes;