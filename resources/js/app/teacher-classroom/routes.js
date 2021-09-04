import ClassroomComponent from '../../views/classroom/teacher/menu.vue';
import ClassroomOverviewComponent from '../../views/classroom/teacher/overview.vue';
import ClassroomSetupComponent from '../../views/classroom/teacher/unit-plan.vue';
import ClassroomDailyAssignmentComponent from '../../views/classroom/teacher/daily-assignment.vue';
import ClassroomResourceComponent from '../../views/classroom/resources.vue';
import ClassroomMessageComponent from '../../views/classroom/messages.vue';
import ClassroomReportComponent from '../../views/classroom/report.vue';
import ClassroomStudentPanelComponent from '../../views/classroom/teacher/student-panel.vue';
import ClassroomAttendanceComponent from '../../views/classroom/teacher/attendance.vue';
import StudentsComponent from '../../views/common/students.vue';
import Homework from '../../views/classroom/teacher/homework.vue';

const TeacherClassroomRoutes = [
	{
		path: '/classroom/:classroomId',
		component: ClassroomComponent,
	},
	{
		path: '/classroom/:classroomId/overview',
		component: ClassroomOverviewComponent,
	},
	{
		path: '/classroom/:classroomId/setup',
		component: ClassroomSetupComponent,
	},
     
	{
		path: '/classroom/:classroomId/daily-assignment',
		component: ClassroomDailyAssignmentComponent,
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
		path: '/classroom/:classroomId/report',
		component: ClassroomReportComponent,
	},
	{
		path: '/classroom/:classroomId/attendance',
		component: ClassroomAttendanceComponent,
	},
	{
		path: '/classroom/:classroomId/student-panel/:userId',
		component: ClassroomStudentPanelComponent,
		name: 'ClassroomStudentPanel'
	},
	{
		path: '/messages',
		component: ClassroomMessageComponent,
	},
	{
		path: '/students',
		component: StudentsComponent,
	},
];

export default TeacherClassroomRoutes;