import LoginComponent from './components/login.vue'
import RegisterComponent from './components/register.vue'

const AuthRoutes = [
    { path: '/', name:'login', component: LoginComponent },
    { path: '/', name:'register', component: RegisterComponent },
];

export default AuthRoutes;