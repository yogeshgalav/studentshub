import DashboardComponent from '../../views/common/dashboard.vue'
import ViewPost from '../../views/common/student-post-view.vue'
import ExploreComponent from '../../views/explore/explore.vue'

const StudentRoutes = [
      {
        path: '/',
        component: DashboardComponent,
      },
      { path: '/explore/:subject', component: ExploreComponent },
      { path: '/explore', component: ExploreComponent },
      { path: '*', redirect: '/' },
      //Post Routes
      {
        path: '/post/:id',
        component: ViewPost,
        name: 'ViewPost',
        meta: {
          title: 'Post',
        }
      },
];

export default StudentRoutes;