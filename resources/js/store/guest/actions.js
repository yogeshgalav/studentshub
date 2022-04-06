import axios from 'axios';

export default {
  getWelcomePageContent({commit}){
  return new Promise((resolve, reject) => {
    axios({url: '/api/get-explore-posts', method: 'GET' })
    .then(resp => {
     const data = resp.data.success
      commit('get_welcome_page_content', data,)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
} 