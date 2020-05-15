import axios from 'axios';

export default {
getDashboardPosts({commit,state},data){
  return new Promise((resolve, reject) => {
    commit('increase_post_paginate_count')
    var route=data ? data.route : '/get-posts'
    route=route+'?page='+state.current_page;
    if(data.params){
      route=route+'&'+data.params;
    }
    axios({url: window.App.baseUrl+'/api'+route, method: 'GET' })
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
getPostContent({commit},post_id){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-post-content/'+post_id, method: 'GET' })
    .then(resp => {
     const data = resp.data.success
      commit('get_post_content', data);
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
subscribe({commit},data){
  console.log(data);
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/subscribe',data:data, method: 'POST'})
    .then(resp => {
     const data = resp.data.success
      // commit('get_explore_page_content', data,)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
} 