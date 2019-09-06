import axios from 'axios';

export default {
  getExplorePageContent({commit}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-explore-posts', method: 'GET' })
    .then(resp => {
     const data = resp.data.success
      commit('get_explore_page_content', data,)
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
      commit('get_post_content', data,)
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