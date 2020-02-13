import DashboardComponent from '../../views/student/dashboard'
import ViewPost from '../../views/student/view-post.vue'
import EditPost from '../../views/create-post/edit-post.vue'
import AskQuestion from '../../views/question/ask-question.vue'
import GetQuestion from '../../views/question/view-questions.vue'
const StudentRoutes = [
      {
        path: '/',
        component: DashboardComponent,
      },
      {
        path: '/ask-question',
        component: AskQuestion,
      },
      {
        path: '/get-question',
        component: GetQuestion,
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
      { path: '/edit-post', name:'EditPost', component: EditPost },
      
];

export default StudentRoutes;