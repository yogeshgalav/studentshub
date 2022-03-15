import state from './state';
import actions from './actions';
import mutations from './mutations';

const CreatePostStore = {
	namespaced:true,
	state,
	actions,
	mutations,
};
export default CreatePostStore;

// import { defineStore } from 'pinia';

// export const useCreatePostStore = defineStore('createPost', {
// 	state: () => {
// 		return {
// 			selected_subjects:[],
// 			category_id:'',
// 			course_id:'',
// 			heading:'',
// 			article_html_content:'',
// 			categories: [],
// 			subjects: [],
// 			selected_course: {
// 				id:'',
// 				course_name:''
// 			},
// 			full_name:'',
// 			email:'',
// 			password:'',
// 		 };
// 	},
// 	// could also be defined as
// 	// state: () => ({ count: 0 })
// 	actions: {
// 		submitPost(data){
// 			return new Promise((resolve, reject) => {
// 				axios({url: '/api/submit-post', data: data, method: 'POST' })
// 					.then((resp) => {
// 						resolve(resp);
// 					})
// 					.catch((err) => {
// 						reject(err);
// 					});
// 			});
// 		},
// 		set_new_user_data(data){
// 			this.full_name = data.full_name;      
// 			this.email = data.email;
// 			this.password = data.password;
// 		},
// 		set_post_article_content(data){
// 			this.article_html_content = data.postContent;
// 			this.description = data.description;
// 		},
// 		set_post_subject(data){
// 			this.selected_subjects=data.selected_subjects;
// 			this.category_id=data.selected_category;
// 		},
// 		set_post_heading(data){
// 			this.post.heading=data.post_heading;
// 		},
// 		get_categories(data){
// 			this.categories = data.categories;
// 		},
// 		set_subject(data){
// 			this.selected_subjects=this.subjects.find(node=>node.id===data.subject_id);
// 		},
// 	},
// });