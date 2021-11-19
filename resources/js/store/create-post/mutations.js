export default {
	set_post_type(state,data){
		state.new_post.post_type=data.post_type.toLowerCase();
	},
	set_post_article_content(state,data){
		state.new_post.article_html_content = data.postContent;
		state.new_post.description = data.description;
	},
	set_post_notice_content(state,data){
		state.new_post.notice_html_content = data.postContent;
		state.new_post.notice_expiry_date = data.expiry_date;
	},
	set_post_document_content(state,data){
		state.new_post.document_link = data.document_link;
		state.new_post.description = data.description;
	},
	set_post_fact_content(state,data){
		state.new_post.fact_image = data.image;
		state.new_post.description = data.description;
		state.new_post.fact_image_url = data.url;
	},
	set_post_video_content(state,data){
		state.new_post.video_id = data.video_id;
		state.new_post.description = data.description;
	},
	set_post_mcq_content(state,data){
		state.new_post.mcq_option1 = data.option1;
		state.new_post.mcq_option2 = data.option2;
		state.new_post.mcq_option3 = data.option3;
		state.new_post.mcq_option4 = data.option4;
		state.new_post.mcq_correct_option = data.correct_option;
		state.new_post.mcq_answer = data.answer;
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
	get_subject_list(state,data){
		state.new_post.primary_subject_list=[];
		state.new_post.primary_subject_list=state.new_post.subject_list;
		state.new_post.subject_list=[];
		state.new_post.subject_list = data.subject_list;
	},
};