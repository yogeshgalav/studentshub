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
getStudentsDetail({commit}, classroomId) {
  return new Promise((resolve, reject) => {
    axios({url: window.App.baseUrl+'/api/classroom/'+classroomId + '/students-data', method:'GET' }).then(resp=> {
      const data = resp.data.success.student_details
      commit('get_students_detials', data)
      resolve(resp)
    }).catch(error=> {
      reject(resp)
    })
  }
 
  )

}


} 