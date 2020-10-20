import ClassroomComponent from '../../views/student-classroom/classroom.vue';
import ClassroomUnitAssignmentComponent from '../../views/student-classroom/classroom-unit-assignment.vue';
import ClassroomDailyAssignmentComponent from '../../views/student-classroom/classroom-daily-assignment.vue';
import ClassroomResourceComponent from '../../views/student-classroom/classroom.vue';
import ClassroomMessageComponent from '../../views/student-classroom/classroom.vue';
import ClassroomDoubtComponent from '../../views/student-classroom/classroom-doubts.vue';
import ClassroomStudentReportComponent from '../../views/teacher-classroom/classroom-student-report.vue';
// import ClassroomDailyReportComponent from '../../views/student-classroom/classroom-daily-report.vue';

const StudentClassroomRoutes = [
	{
		path: '/classroom/:classroomId',
		component: ClassroomComponent,
	},
	{
		path: '/classroom/:classroomId/unit-assignment',
		component: ClassroomUnitAssignmentComponent,
	},
	{
		path: '/classroom/:classroomId/daily-assignment',
		component: ClassroomDailyAssignmentComponent,
	},
	// {
	// 	path: '/classroom/:classroomId/daily-report',
	// 	component: ClassroomDailyReportComponent,
	// },
	// {
	// 	path: '/classroom/:classroomId/students',
	// 	component: ClassroomStudentDetailComponent,
	// },
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
		path: '/classroom/:classroomId/my-report',
		component: ClassroomStudentReportComponent,
	},
];

export default StudentClassroomRoutes;