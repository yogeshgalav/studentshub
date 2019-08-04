import axios from 'axios';

export default {
  createPost({commit}, post){
    return new Promise(() => {
      commit('create_post',post)
    })
},
getPosts({commit}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-posts', method: 'GET' })
    .then(resp => {
     const posts = resp.data.success.posts
      commit('get_posts', posts,)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
} 