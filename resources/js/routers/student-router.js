import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import HomeRoutes from './../home/routes'
import PostRoutes from './../post/routes'

var routes = [
  { path: '*', redirect: '/' },
];
routes.concat(HomeRoutes,PostRoutes);

const StudentRouter = new VueRouter({
  routes,
  mode:'history'
});

export default StudentRouter;
