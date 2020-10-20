import ClassroomComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomOverviewComponent from '../../views/teacher-classroom/classroom-overview.vue';
import ClassroomSetupComponent from '../../views/teacher-classroom/classroom-setup.vue';
import ClassroomUnitAssignmentComponent from '../../views/teacher-classroom/classroom-unit-assignment.vue';
import ClassroomDailyAssignmentComponent from '../../views/teacher-classroom/daily-assignment/classroom-daily-assignment.vue';
import ClassroomDailyReportComponent from '../../views/teacher-classroom/classroom-daily-report.vue';
import ClassroomResourceComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomMessageComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomDoubtComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomStudentDetailsComponent from '../../views/teacher-classroom/classroom-student-detail.vue';
import ClassroomStudentReportComponent from '../../views/teacher-classroom/classroom-student-report.vue';

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
		component: ClassroomStudentDetailsComponent,
	},
	{
		path: '/classroom/:classroomId/student-report/:userId',
		component: ClassroomStudentReportComponent,
	},
];

export default TeacherClassroomRoutes;