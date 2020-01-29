import state from './state';
import actions from './actions';
import mutations from './mutations';

const StudentStore = {
  namespaced:true,
  state,
  actions,
  mutations,
};
export default StudentStore;

