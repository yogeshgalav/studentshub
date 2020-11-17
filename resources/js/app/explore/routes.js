import ExploreComponent from '../../views/explore/explore.vue'
import ViewPost from '../../views/guest/guest-post-view.vue'

const routes = [
    {
      path: '/search',
      component: ExploreComponent,
      name:'search'
    },
    {
      path: '/category/:id',
      component: ExploreComponent,
      name:'category'
    },
    {
      path: '/subject/:id',
      component: ExploreComponent,
      name:'subject'
    },
    {
      path: '/course/:id',
      component: ExploreComponent,
      name:'course'
    },
    {
      path: '/post/:id',
      component: ViewPost,
      name: 'ViewPost',
    },
];

export default routes;