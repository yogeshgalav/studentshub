import ClassroomComponent from '../../views/classroom/classroom.vue'
import ClassroomSetupComponent from '../../views/classroom/classroom.vue'
import ClassroomUnitAssignmentComponent from '../../views/classroom/classroom.vue'
import ClassroomDailyAssignmentComponent from '../../views/classroom/classroom.vue'
import ClassroomStudentComponent from '../../views/classroom/classroom.vue'

const ClassroomRoutes = [
      {
        path: '/classroom/:classroomId',
        component: ClassroomComponent,
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
        component: ClassroomStudentComponent,
      },
];

export default ClassroomRoutes;