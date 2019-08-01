import axios from 'axios';

export default {
  createPost({commit}, post){
    return new Promise(() => {
      commit('create_post',post)
    })
},
} 