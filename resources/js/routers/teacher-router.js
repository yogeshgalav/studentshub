import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);
import ClassroomRoutes from './../classroom/routes'

var routes = [
  { path: '*', redirect: '/' },
];
routes.concat(ClassroomRoutes);

const TeacherRouter = new VueRouter({
  routes,
  mode:'history'
});

export default TeacherRouter;
