import DashboardComponent from '../../views/seeker-dashboard/dashboard.vue'
import ViewPost from '../../views/seeker-dashboard/view-post.vue'
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