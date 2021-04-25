import ClassroomComponent from '../../views/student-classroom/classroom.vue';
import ClassroomUnitAssignmentComponent from '../../views/student-classroom/classroom-unit-assignment.vue';
import ClassroomResourceComponent from '../../views/classroom/resources.vue';
import ClassroomMessageComponent from '../../views/classroom/messages.vue';
import ClassroomDoubtComponent from '../../views/classroom/doubts.vue';
import ClassroomStudentPanelComponent from '../../views/classroom/student/daily-assignment.vue';
import ClassroomReportComponent from '../../views/classroom/report.vue';
import ClassroomAttendanceComponent from '../../views/classroom/student/attendance.vue';

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
		component: ClassroomStudentPanelComponent,
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
		path: '/classroom/:classroomId/student-panel',
		component: ClassroomStudentPanelComponent,
	},
	{
		path: '/messages',
		component: ClassroomMessageComponent,
	},
];

export default StudentClassroomRoutes;