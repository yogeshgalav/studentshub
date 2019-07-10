import ViewPost from './components/view-post.vue'
import EditPost from './components/edit-post.vue'
import SharePost from './components/share-post.vue'
const postRoutes = [
    {
        path: '/post',
        component: ViewPost,
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
];

export default postRoutes;