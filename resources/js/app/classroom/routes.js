import ClassroomListComponent from '../../views/classroom/classroom-list.vue'
import ClassroomComponent from '../../views/classroom/classroom.vue'
import ClassroomStudentPanelComponent from '../../views/classroom/classroom-student-panel.vue'
import ClassroomTopicComponent from '../../views/classroom/classroom-topic.vue'

const ClassroomRoutes = [
      {
        path: '/classrooms',
        component: ClassroomListComponent,
      },
      {
        path: '/classroom/{classroomId}',
        component: ClassroomComponent,
      },
      {
        path: '/classroom/{classroomId}/student-panel/{userId}',
        component: ClassroomStudentPanelComponent,
      },
      {
        path: '/classroom/{classroomId}/topic/{topicId}',
        component: ClassroomTopicComponent,
      },
];

export default ClassroomRoutes;