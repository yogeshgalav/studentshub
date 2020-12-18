import ClassroomComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomOverviewComponent from '../../views/teacher-classroom/classroom-overview.vue';
import ClassroomSetupComponent from '../../views/teacher-classroom/classroom-setup.vue';
import ClassroomUnitAssignmentComponent from '../../views/teacher-classroom/classroom-unit-assignment.vue';
import ClassroomDailyAssignmentComponent from '../../views/teacher-classroom/daily-assignment/classroom-daily-assignment.vue';
import ClassroomDailyReportComponent from '../../views/teacher-classroom/classroom-daily-report.vue';
import ClassroomDocumentComponent from '../../views/classroom/documents.vue';
import ClassroomVideoComponent from '../../views/classroom/videos.vue';
import ClassroomMessageComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomDoubtComponent from '../../views/teacher-classroom/classroom.vue';
import ClassroomStudentsComponent from '../../views/teacher-classroom/classroom-students.vue';
import ClassroomStudentPanelComponent from '../../views/teacher-classroom/classroom-student-panel.vue';

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
		path: '/classroom/:classroomId/documents',
		component: ClassroomDocumentComponent,
	},
	{
		path: '/classroom/:classroomId/videos',
		component: ClassroomVideoComponent,
	},
	{
		path: '/classroom/:classroomId/doubts',
		component: ClassroomDoubtComponent,
	},
	{
		path: '/classroom/:classroomId/students',
		component: ClassroomStudentsComponent,
	},
	{
		path: '/classroom/:classroomId/student-panel/:userId',
		component: ClassroomStudentPanelComponent,
		name: 'ClassroomStudentPanel'
	},
];

export default TeacherClassroomRoutes;