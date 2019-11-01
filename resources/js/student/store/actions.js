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
getSubjects({commit,categoryId}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-subects/'+categoryId, method: 'GET' })
    .then(resp => {
     const subjects = resp.data.success.subjects
      commit('get_subjects', subjects,)
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
getSubjectList({commit},data){
  commit('set_subject', data.subject_id)
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-subject-list/'+data.subject_id, method: 'GET' })
    .then(resp => {
     const subject_data = resp.data.success
      commit('get_subject_list', subject_data)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
submitPost({commit},data){
  return new Promise((resolve, reject) => {
    console.log(data,'hre');
    axios({url: window.App.baseUrl+'/api/submit-post', data: data, method: 'POST' })
      .then((resp) => {
        resolve(resp)
      })
      .catch((err) => {
        reject(err)
      })
  })
},
} 