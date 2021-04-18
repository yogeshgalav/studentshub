import ClassroomComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomOverviewComponent from '../../views/teacher-classroom/classroom-overview.vue';
import ClassroomSetupComponent from '../../views/teacher-classroom/classroom-setup.vue';
import ClassroomUnitAssignmentComponent from '../../views/teacher-classroom/classroom-unit-assignment.vue';
import ClassroomDailyAssignmentComponent from '../../views/teacher-classroom/daily-assignment/classroom-daily-assignment.vue';
import ClassroomDailyReportComponent from '../../views/teacher-classroom/classroom-daily-report.vue';
import ClassroomResourceComponent from '../../views/classroom/resources.vue';
import ClassroomMessageComponent from '../../views/classroom/messages.vue';
import ClassroomDoubtComponent from '../../views/classroom/doubts.vue';
import ClassroomReportComponent from '../../views/classroom/report.vue';
import ClassroomStudentPanelComponent from '../../views/classroom/teacher/daily-assignment.vue';
import ClassroomAttendanceComponent from '../../views/classroom/student/attendance.vue';
import DoubtAnswer from '../../views/doubt/doubt-answers.vue';

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
		path: '/classroom/:classroomId/daily-report',
		component: ClassroomDailyReportComponent,
	},
	{
		path: '/classroom/:classroomId/unit-assignment',
		component: ClassroomUnitAssignmentComponent,
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
		path: '/classroom/:classroomId/students',
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
		path: '/doubt/:doubtId',
		component: DoubtAnswer,
		name: 'DoubtAnswer',
	},
	{
		path: '/messages',
		component: ClassroomMessageComponent,
	},
];

export default TeacherClassroomRoutes;