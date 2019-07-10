import Dashboard from './home/dashboard.vue'
import WelcomeComponent from './guest/welcome.vue'
import postRoutes from './post/routes'

var exRoutes = [
    {
        path: '/dashboard',
        component: Dashboard,
        meta: {
          title: 'Knowledge is Immortal',
          metaTags: [
            {
              name: 'description',
              content: 'Invest your time wisely on the Internet.'
            },
            {
              property: 'og:description',
              content: 'Invest your time wisely on the Internet.'
            }
          ]
        }
      },
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
    { path: '/', name:'welcome', component: WelcomeComponent },
    { path: '*', redirect: '/' },
];
const routes=exRoutes.concat(postRoutes);

export default routes;

