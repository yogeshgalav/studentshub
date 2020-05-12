import ExploreComponent from '../../views/explore/explore.vue'
import ViewPost from '../../views/guest/guest-post-view.vue'

const routes = [
    {
      path: '/category/:id',
      component: ExploreComponent,
    },
    {
      path: '/subject/:id',
      component: ExploreComponent,
    },
    {
      path: '/course/:id',
      component: ExploreComponent,
    },
    {
      path: '/post/:id',
      component: ViewPost,
      name: 'ViewPost',
    },
    { path: '*', redirect: '/' },
];

export default routes;