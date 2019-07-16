import LoginComponent from './components/login.vue'
import RegisterComponent from './components/register.vue'

const AuthRoutes = [
    { path: '/login', name:'login', component: LoginComponent },
    { path: '/register', name:'register', component: RegisterComponent },
];

export default AuthRoutes;