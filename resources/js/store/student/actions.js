import axios from 'axios';

export default {
getStudentPosts({commit}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-student-posts', method: 'GET' })
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
getCategories({commit}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-categories', method: 'GET' })
    .then(resp => {
      let data={};
     data['categories'] = resp.data.success.categories
     data['AuthUserCategory'] = resp.data.success.AuthUserCategory
      commit('get_categories', data);
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
} 