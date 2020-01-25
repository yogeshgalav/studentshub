import state from './state';
import actions from './actions';
import mutations from './mutations';

const exploreStore = {
  namespaced:true,
  state,
  actions,
  mutations,
};
export default exploreStore;

