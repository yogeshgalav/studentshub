import Vue from 'vue';
import Vuex from 'vuex';
// const productStore = require('./product/store').default
// const userStore = require('./user/store').default
import authStore from './auth/store';
import exploreStore from './home/store';

Vue.use(Vuex);
const store = new Vuex.Store({
    modules: {
        auth: authStore,
        explore: exploreStore,
      }
});

export default store;