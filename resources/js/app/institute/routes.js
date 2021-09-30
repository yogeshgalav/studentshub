
import InstituteComponent from '../../views/institute/institute';
import IndexStudentComponent from '../../views/institute/index-students';
import ShowStudentComponent from '../../views/institute/show-student';
const InstituteRoutes = [
	{
		path: '/institute',
		component: InstituteComponent,
	},
	{
		path: '/students',
		component: IndexStudentComponent,
	},
	{
		path: '/student/:id',
		component: ShowStudentComponent,
	},
];

export default InstituteRoutes;