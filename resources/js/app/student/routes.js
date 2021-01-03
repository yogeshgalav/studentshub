import DashboardComponent from '../../views/common/dashboard.vue'
import ViewPost from '../../views/common/student-post-view.vue'
import EditPost from '../../views/create-post/edit-post.vue'
import DoubtList from '../../views/doubt/doubt-list.vue'
import DoubtAnswer from '../../views/doubt/doubt-answers.vue'
import ExploreComponent from '../../views/explore/explore.vue'
const StudentRoutes = [
      {
        path: '/',
        component: DashboardComponent,
      },
      { path: '/explore/:subject', component: ExploreComponent },
      { path: '/explore', component: ExploreComponent },
      {
        path: '/doubts',
        component: DoubtList,
      },
      { path: '*', redirect: '/' },
      //Doubt Routes
      {
        path: '/doubt/:doubtId',
        component: DoubtAnswer,
        name: 'DoubtAnswer',
        meta: {
          title: 'Doubt',
        }
      },
      //Post Routes
      {
        path: '/post/:id',
        component: ViewPost,
        name: 'ViewPost',
        meta: {
          title: 'Post',
        }
      },
      { path: '/edit-post', name:'EditPost', component: EditPost },
      
];

export default StudentRoutes;