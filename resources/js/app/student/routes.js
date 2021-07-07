import DashboardComponent from '../../views/common/dashboard.vue';
import ViewPost from '../../views/common/student-post-view.vue';
import EditPost from '../../views/create-post/edit-post.vue';
import DoubtList from '../../views/doubt/doubt-list.vue';
import DoubtAnswer from '../../views/doubt/doubt-answers.vue';
import ExploreComponent from '../../views/explore/explore.vue';
const StudentRoutes = [
	{
		path: '/',
		component: DashboardComponent,
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
      
];

export default StudentRoutes;