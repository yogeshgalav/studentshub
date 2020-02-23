export default {
    create_post(state,data){
      switch(data.field){
        case 'post_type':
        state.new_post.post_type=data.post_type.toLowerCase();
        break
        case 'post_heading':
        state.new_post.post_heading=data.post_heading;
        break
        case 'post_subject':
        state.new_post.selected_subject.id=data.subject_id ? data.subject_id : null;
        state.new_post.selected_subject.subject_name=data.subject_name;
        break
        case 'postContent':
        console.log(data.postContent)
          switch(state.new_post.post_type){
            case 'article':  
            state.new_post.postContent = data.postContent;
          break;
            case 'video':  
          state.new_post.postContent = {'link':data.link,'description':data.description};
          break;
          }
        break;
      }
    },
    updateFiles(state,data){
     state.new_post.files=data;
    },
    submitPost(state){
      
  },get_categories(state,data){
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