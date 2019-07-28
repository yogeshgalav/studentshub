import WelcomeComponent from './welcome.vue'
import ExploreComponent from './explore.vue'

const routes = [
    { path: '/', name:'welcome', component: WelcomeComponent },
    { path: '/explore', name:'explore', component: ExploreComponent },
    { path: '*', redirect: '/' },
];

export default routes;