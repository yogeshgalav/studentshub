import DashboardComponent from './components/dashboard.vue'
import ViewPost from './components/post/view-post.vue'
import EditPost from './components/post/edit-post.vue'
import SharePost from './components/post/share-post.vue'
import AskQuestion from './components/ask-question.vue'
import GetQuestion from './components/view-questions.vue'
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
    {
        path: '/share-your-knowledge',
        component: SharePost,
        meta: {
          title: 'Share your knowledge',
          metaTags: [
            {
              name: 'description',
              content: 'Share knowledge related to your stream of education or of personal interest.'
            },
            {
              property: 'og:description',
              content: 'Share knowledge related to your stream of education or of personal interest.'
            }
          ]
        }
      },
      { path: '/edit-post', name:'EditPost', component: EditPost },
      // {
      //   path: '/about',
      //   // I'm kind of cheating by reusing the main app component here.
      //   component: App,
      //   meta: {
      //     title: 'About Page - Example App',
      //     metaTags: [
      //       {
      //         name: 'description',
      //         content: 'The about page of our example app.'
      //       },
      //       {
      //         property: 'og:description',
      //         content: 'The about page of our example app.'
      //       }
      //     ]
      //   },
    
      //   children: [
      //     {
      //       path: 'nested',
      //       component: Nested,
      //       meta: {
      //         title: 'Nested - About Page - Example App'
      //       }
      //     }
      //   ]
      // },
];

export default StudentRoutes;