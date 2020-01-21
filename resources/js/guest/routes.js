import WelcomeComponent from './home/welcome.vue'
import ExploreComponent from './../components/explore.vue'
import LoginComponent from './auth/components/login.vue'
import RegisterComponent from './auth/components/register.vue'
import ViewPost from '../components/PostViewPage.vue'
import ForgotPasswordComponent from './auth/components/forgot-password.vue';

const routes = [
    { 
      path: '/', name:'welcome', 
      component: WelcomeComponent, 
      meta: {
        title: "Student'sHUB",
      }
    },
    { path: '/explore/:subject', component: ExploreComponent },
    { path: '/explore', component: ExploreComponent },
    { path: '/login', name:'login', component: LoginComponent },
    { path: '/get-started', name:'register', component: RegisterComponent },
    { path: '/forgot-password', name:'forgot-password', component: ForgotPasswordComponent },
    {
      path: '/auth/:provider/callback',
      component: {
        template: '<div class="auth-component"></div>'
      }
    },
    {
        path: '/post/:id',
        component: ViewPost,
        name: 'ViewPost',
      },
    { path: '*', redirect: '/' },
];

export default routes;