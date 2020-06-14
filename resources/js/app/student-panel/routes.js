import ClassroomListComponent from '../../views/classroom/classroom-listvue'
import ClassroomMyPanelComponent from '../../views/classroom/classroom-my-panel.vue'
const StudentPanelRoutes = [
      {
        path: '/classrooms',
        component: ClassroomListComponent,
      },
      {
        path: '/classrooms/:classroomId',
        component: ClassroomMyPanelComponent,
      },
];

export default StudentPanelRoutes;