import axios from 'axios';

export default {
  createPost({commit}, data){
    return new Promise(() => {
      commit('create_post',data)
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
submitPost({commit},data){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/submit-post', data: data, method: 'POST' })
      .then((resp) => {
        resolve(resp)
      })
      .catch((err) => {
        reject(err)
      })
  })
},
updateFiles({commit},data){
  return new Promise((resolve, reject) => {
  })
},
} 