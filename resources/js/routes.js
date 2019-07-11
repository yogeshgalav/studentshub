import PostRoutes from './post/routes'
import HomeRoutes from './home/routes'
import GuestRoutes from './guest/routes'
import AuthRoutes from './auth/routes'

var exRoutes = [
    
    
];
const routes=exRoutes.concat(AuthRoutes,GuestRoutes,HomeRoutes,PostRoutes);

export default routes;

