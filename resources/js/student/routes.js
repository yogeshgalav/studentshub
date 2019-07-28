import DashboardComponent from './home/dashboard.vue'

const HomeRoutes = [
    {
        path: '/dashboard',
        component: DashboardComponent,
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
];

export default HomeRoutes;