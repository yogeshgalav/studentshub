import Vue from 'vue';
import Vuex from 'vuex';
// const productStore = require('./product/store').default
// const userStore = require('./user/store').default
import authStore from './../auth/store';

Vue.use(Vuex);
const store = new Vuex.Store({
    modules: {
        auth: authStore,
      }
});

export default store;