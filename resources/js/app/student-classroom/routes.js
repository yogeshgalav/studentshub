import ClassroomComponent from '../../views/classroom/student/menu.vue';
import ClassroomResourceComponent from '../../views/classroom/resources.vue';
import ClassroomMessageComponent from '../../views/classroom/messages.vue';
import DailyAssignmentComponent from '../../views/classroom/student/daily-assignment.vue';
import ClassroomReportComponent from '../../views/classroom/report.vue';
import ClassroomAttendanceComponent from '../../views/classroom/student/attendance.vue';
import ClassmatesComponent from '../../views/classroom/student/classmates.vue';
import Homework from '../../views/classroom/student/homework.vue';

const StudentClassroomRoutes = [
	{
		path: '/classroom/:classroomId',
		component: ClassroomComponent,
	},
	{
		path: '/classroom/:classroomId/daily-assignment',
		component: DailyAssignmentComponent,
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
		path: '/classroom/:classroomId/homeworks',
		component: Homework,
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
		path: '/messages',
		component: ClassroomMessageComponent,
	},
	{
		path: '/classmates',
		component: ClassmatesComponent,
	},
];

export default StudentClassroomRoutes;