import ClassroomComponent from '../../views/classroom/student/menu.vue';
import ClassroomResourceComponent from '../../views/classroom/resources.vue';
import ClassroomMessageComponent from '../../views/classroom/messages.vue';
import ClassroomDoubtComponent from '../../views/classroom/doubts.vue';
import ClassroomOverviewComponent from '../../views/classroom/student/overview.vue';
import ClassroomReportComponent from '../../views/classroom/report.vue';
import ClassroomAttendanceComponent from '../../views/classroom/student/attendance.vue';
import ClassmatesComponent from '../../views/classroom/student/classmates.vue';

const StudentClassroomRoutes = [
	{
		path: '/classroom/:classroomId',
		component: ClassroomComponent,
	},
	{
		path: '/classroom/:classroomId/overview',
		component: ClassroomOverviewComponent,
	},
	{
		path: '/classroom/:classroomId/report',
		component: ClassroomReportComponent,
	},

	{
		path: '/classroom/:classroomId/attendance',
		component: ClassroomAttendanceComponent,
	},
	{
		path: '/classroom/:classroomId/resources',
		component: ClassroomResourceComponent,
	},
	{
		path: '/classroom/:classroomId/messages',
		component: ClassroomMessageComponent,
	},
	{
		path: '/classroom/:classroomId/doubts',
		component: ClassroomDoubtComponent,
	},
	{
		path: '/messages',
		component: ClassroomMessageComponent,
	},
	{
		path: '/classmates',
		component: ClassmatesComponent,
	},
];

export default StudentClassroomRoutes;