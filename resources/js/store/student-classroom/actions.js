import axios from 'axios';

export default {
  getClassroomDetail({commit},classroomId){
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/get-classroom-detail/'+classroomId, method: 'GET' })
    .then(resp => {
     const data = resp.data.success.classroomDetail
      commit('get_classroom_detail', data,)
      resolve(resp)
    })
    .catch(err => {
      reject(err)
    })
  })
},
} 