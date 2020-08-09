import ClassroomComponent from '../../views/classroom/classroom.vue'
import ClassroomOverviewComponent from '../../views/classroom/classroom-overview.vue'
import ClassroomSetupComponent from '../../views/classroom/classroom-setup.vue'
import ClassroomUnitAssignmentComponent from '../../views/classroom/classroom-setup.vue'
import ClassroomDailyAssignmentComponent from '../../views/classroom/classroom-daily-assignment.vue'
import ClassroomStudentDetailComponent from '../../views/classroom/classroom.vue'

const ClassroomRoutes = [
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
        path: '/classroom/:classroomId/unit-assignment',
        component: ClassroomUnitAssignmentComponent,
      },
      {
        path: '/classroom/:classroomId/daily-assignment',
        component: ClassroomDailyAssignmentComponent,
      },
      {
        path: '/classroom/:classroomId/students',
        component: ClassroomStudentDetailComponent,
      },
];

export default ClassroomRoutes;