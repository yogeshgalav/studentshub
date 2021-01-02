import ClassroomComponent from '../../views/student-classroom/classroom.vue';
import ClassroomUnitAssignmentComponent from '../../views/student-classroom/classroom-unit-assignment.vue';
import ClassroomDailyAssignmentComponent from '../../views/student-classroom/classroom-daily-assignment.vue';
import ClassroomResourceComponent from '../../views/classroom/resources.vue';
import ClassroomMessageComponent from '../../views/classroom/messages.vue';
import ClassroomDoubtComponent from '../../views/classroom/doubts.vue';
import ClassroomStudentPanelComponent from '../../views/teacher-classroom/classroom-student-panel.vue';
import ClassmatesComponent from '../../views/student-classroom/classmates.vue';

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
	{
		path: '/classroom/:classroomId/classmates',
		component: ClassmatesComponent,
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
];

export default StudentClassroomRoutes;