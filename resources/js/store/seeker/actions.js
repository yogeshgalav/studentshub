import axios from 'axios';

export default {
addPostLike({commit},data){
  return new Promise((resolve, reject) => {
    axios({url: '/api/post/'+data.post_id+'/post-like/', method: 'POST' ,data:{'method':data.method,'type':data.type}})
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
    axios({url: '/api/post/'+data.post_id+'/post-like', method: 'POST',data:{'method':data.method,'type':data.type} })
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