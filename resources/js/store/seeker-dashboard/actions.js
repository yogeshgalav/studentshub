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
      commit('get_posts', posts)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
getCategories({commit}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-categories', method: 'GET' })
    .then(resp => {
     const categories = resp.data.success.categories
      commit('get_categories', categories,)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
getPostContent({commit},post_id){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-post-content/'+post_id, method: 'GET' })
    .then(resp => {
     const data = resp.data.success
      commit('get_post_content', data)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
addPostLike({commit},data){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/post/'+data.post_id+'/post-like/', method: 'POST' ,data:{'method':data.method,'type':data.type}})
    .then(resp => {
      commit('add_post_like',data.post_id)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
addPostDislike({commit},data){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/post/'+data.post_id+'/post-like', method: 'POST',data:{'method':data.method,'type':data.type} })
    .then(resp => {
      commit('add_post_dislike',data.post_id)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
} 