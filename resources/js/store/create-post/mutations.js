export default {
    set_post_type(state,data){
      state.new_post.post_type=data.post_type.toLowerCase();
    },
    set_post_article_content(state,data){
      state.new_post.articleContent.htmlContent = data.postContent;
    },
    set_post_notice_content(state,data){
      state.new_post.noticeContent.htmlContent = data.postContent;
      state.new_post.noticeContent.expiry_date = data.expiry_date;
    },
    set_post_document_content(state,data){
      state.new_post.documentContent.files = data.files;
      state.new_post.documentContent.description = data.description;
    },
    set_post_fact_content(state,data){
      state.new_post.factContent.image = data.image;
      state.new_post.factContent.description = data.description;
    },
    set_post_video_content(state,data){
      state.new_post.videoContent.link = data.link;
      state.new_post.videoContent.description = data.description;
    },
    set_post_subject(state,data){
      state.new_post.selected_subject.id=data.subject_id ? data.subject_id : null;
      state.new_post.selected_subject.subject_name=data.subject_name;
    },
    set_post_heading(state,data){
      state.new_post.heading=data.post_heading;
    },
   get_categories(state,data){
    state.categories = data.categories;
    state.AuthUserCategory = data.AuthUserCategory;
    state.new_post.subject_list=data.categories;
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
  }