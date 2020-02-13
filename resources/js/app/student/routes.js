import DashboardComponent from '../../views/student/dashboard'
import ViewPost from '../../views/student/view-post.vue'
import EditPost from '../../views/create-post/edit-post.vue'
import SharePost from '../../views/create-post/share-post.vue'
import DoubtList from '../../views/doubt/doubt-list.vue'
import DoubtAnswer from '../../views/doubt/doubt-answers.vue'
const StudentRoutes = [
      {
        path: '/',
        component: DashboardComponent,
      },
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