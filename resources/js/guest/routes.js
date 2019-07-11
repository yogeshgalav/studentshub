import WelcomeComponent from './welcome.vue'
import ExploreComponent from './explore.vue'

const guestRoutes = [
    { path: '/', name:'welcome', component: WelcomeComponent },
    { path: '/', name:'explore', component: ExploreComponent },
    { path: '*', redirect: '/' },
];

export default guestRoutes;