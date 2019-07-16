import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import GuestRoutes from './../guest/routes'
import AuthRoutes from './../auth/routes'

var routes = [
  { path: '*', redirect: '/' },
];
routes.concat(AuthRoutes,GuestRoutes);

const GuestRouter = new VueRouter({
  routes,
  mode:'history'
});
export default GuestRouter;
