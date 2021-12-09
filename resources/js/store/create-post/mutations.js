export default {
	set_new_user_data(state,data){
		state.full_name = data.full_name;      
		state.email = data.email;
		state.password = data.password;
	},
	set_post_article_content(state,data){
		state.new_post.article_html_content = data.postContent;
		state.new_post.description = data.description;
	},
	set_post_subject(state,data){
		state.new_post.selected_subjects=data.selected_subjects;
		state.new_post.category_id=data.selected_category;
	},
	set_post_heading(state,data){
		state.new_post.heading=data.post_heading;
	},
	get_categories(state,data){
		state.categories = data.categories;
	},
	set_subject(state,data){
		state.new_post.selected_primary_subject_id=data.subject_id;
		state.new_post.selected_subject=state.new_post.subject_list.find(node=>node.id===data.subject_id);
	},
};