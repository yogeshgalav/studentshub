import WelcomeComponent from './welcome.vue'
import ExploreComponent from './explore.vue'

const guestRoutes = [
    { path: '/', name:'welcome', component: WelcomeComponent },
    { path: '/explore', name:'explore', component: ExploreComponent },
];

export default guestRoutes;