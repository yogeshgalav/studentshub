import state from './state';
import actions from './actions';
import mutations from './mutations';

const CreatePostStore = {
  namespaced:true,
  state,
  actions,
  mutations,
};
export default CreatePostStore;

