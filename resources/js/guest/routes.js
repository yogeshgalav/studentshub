import WelcomeComponent from './home/welcome.vue'
import ExploreComponent from './home/explore.vue'
import LoginComponent from './auth/components/login.vue'
import RegisterComponent from './auth/components/register.vue'
import ViewPost from '../components/PostViewPage.vue'

const routes = [
    { path: '/', name:'welcome', component: WelcomeComponent },
    { path: '/explore', name:'explore', component: ExploreComponent },
    { path: '/login', name:'login', component: LoginComponent },
    { path: '/get-started', name:'register', component: RegisterComponent },
    {
        path: '/post/:id',
        component: ViewPost,
        name: 'ViewPost',
        meta: {
          title: 'Post',
        }
      },
    { path: '*', redirect: '/' },
];

export default routes;