export default {
	get_posts(state,posts){
		state.dashboardPosts=state.dashboardPosts.concat(posts.data);
		state.current_page = posts.current_page;
	},
	increase_post_paginate_count(state){
		state.current_page=state.current_page+1;
	},
	get_post_content(state,data){
		state.postView.post_content = data.post_content;
		state.postView.most_viewed = data.most_viewed;
		state.postView.most_liked = data.most_liked;
	},
	set_post_initial(state,data){
		state.postView.post_content.heading = data.heading;
		state.postView.post_content.category_name = data.category_name;
		state.postView.post_content.subject_name = data.subject_name;
		state.postView.post_content.profile_image = data.profile_image;
		state.postView.post_content.institute_name = data.institute_name;
		state.postView.post_content.post_type = data.post_type;
		state.postView.post_content.user_name = data.user_name;
		state.postView.post_content.total_likes = data.total_likes;
		state.postView.post_content.total_dislikes = data.total_dislikes;
		state.postView.post_content.total_views = data.total_views;
	},
};