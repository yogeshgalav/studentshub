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
subscribe({commit,email}){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/subscribe', method: 'POST' , data: email})
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