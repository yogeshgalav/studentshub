import axios from 'axios';

export default {
	login({commit}, user){
		return new Promise((resolve, reject) => {
			// commit('auth_request')
			axios({url: window.App.baseUrl+'/api/login', data: user, method: 'POST' })
				.then(resp => {
					console.log(resp.data.success);
					const access_token = resp.data.success.access_token;
					const refresh_token = resp.data.success.refresh_token;
					localStorage.setItem('access_token', access_token);
					localStorage.setItem('refresh_token', refresh_token);
					// commit('auth_success', token, user)
					resolve(resp);
				})
				.catch(err => {
					// commit('auth_error')
					localStorage.removeItem('token');
					reject(err);
				});
		});
	},
	register({commit}, user){
		return new Promise((resolve, reject) => {
			// commit('auth_request')
			axios({url: window.App.baseUrl+'/api/register', data: user, method: 'POST' })
				.then(resp => {
					const access_token = resp.data.success.access_token;
					const refresh_token = resp.data.success.refresh_token;
					localStorage.setItem('access_token', access_token);
					localStorage.setItem('refresh_token', refresh_token);
					// commit('auth_success', token, user)
					resolve(resp);
				})
				.catch(err => {
					console.log(err);
					localStorage.removeItem('token');
					reject(err);
				});
		});
	},
	logout({commit}){
		return new Promise((resolve, reject) => {
			commit('logout');
			axios({url: window.App.baseUrl+'/logout', method: 'POST' })
				.then(resp => {
					window.App.signedIn=false;
					window.App.AuthUser=null;
					localStorage.removeItem('access_token');
					localStorage.removeItem('refresh_token');
					delete axios.defaults.headers.common['Authorization'];
					resolve();
				});
		});
	},
};
