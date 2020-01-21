import DashboardComponent from './components/dashboard.vue'
import ViewPost from './components/post/view-post.vue'
import ExploreComponent from './../components/explore.vue'

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