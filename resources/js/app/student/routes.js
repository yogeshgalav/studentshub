import DashboardComponent from '../../views/common/dashboard.vue';
import EditPost from '../../views/create-post/edit-post.vue';
import DoubtList from '../../views/doubt/doubt-list.vue';
import DoubtAnswer from '../../views/doubt/doubt-answers.vue';
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
	//Doubt Routes
	{
		path: '/doubts',
		component: DoubtList,
	},
	{
		path: '/doubt/:doubtId',
		component: DoubtAnswer,
		name: 'DoubtAnswer',
		meta: {
			title: 'Doubt',
		}
	},
	{ path: '/edit-post', name:'EditPost', component: EditPost },
	{ path: '/more-apps', component: MoreAppComponent },

];

export default StudentRoutes;