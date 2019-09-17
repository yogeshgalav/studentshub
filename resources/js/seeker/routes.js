import DashboardComponent from './components/dashboard.vue'
import ViewPost from './components/post/view-post.vue'

const StudentRoutes = [
      {
        path: '/',
        component: DashboardComponent,
      },
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