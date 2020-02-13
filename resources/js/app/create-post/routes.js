
import SharePost from '../../views/create-post/share-post.vue'
const CreatePostRoutes = [
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
];

export default CreatePostRoutes;