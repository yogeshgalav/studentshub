import axios from 'axios';

export default {
  login({commit}, user){
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios({url: window.App.baseUrl+'/api/login', data: user, method: 'POST' })
      .then(resp => {
        const token = resp.data.success.token
        const user = resp.data.success.user
        localStorage.setItem('access_token', token);
        commit('auth_success', token, user)
        resolve(resp)
      })
      .catch(err => {
        commit('auth_error')
        localStorage.removeItem('token')
        reject(err)
      })
    })
},
register({commit}, user){
  return new Promise((resolve, reject) => {
    commit('auth_request')
    axios({url: window.App.baseUrl+'/register', data: user, method: 'POST' })
    .then(resp => {
      const token = resp.data.token
      const user = resp.data.user
      localStorage.setItem('access_token', token)
      commit('auth_success', token, user)
      resolve(resp)
    })
    .catch(err => {
      commit('auth_error', err)
      localStorage.removeItem('token')
      reject(err)
    })
  })
},
logout({commit}){
  return new Promise((resolve, reject) => {
    commit('logout')
    axios({url: window.App.baseUrl+'/logout', method: 'POST' })
    .then(resp => {
      window.App.signedIn=false;
      window.App.AuthUser=null;
    localStorage.removeItem('access_token')
    delete axios.defaults.headers.common['Authorization']
    resolve()
    });
  })
},
} 