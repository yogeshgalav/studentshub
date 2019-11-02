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
        state.new_post.post_subject=data.post_subject;
        break
        case 'postContent':
        console.log(data,state.new_post.post_type)
          switch(state.new_post.post_type){
            case 'article':  
          state.new_post.postContent = {'content':data.content};
          break;
            case 'video':  
          state.new_post.postContent = {'link':data.link,'description':data.description};
          break;
          }
        break;
      }
    },
    get_posts(state,posts){
      state.dashboardPosts = posts;
    },
    get_categories(state,categories){
      state.categories = categories;
      state.new_post.subject_list=categories;
    },
    get_subjects(state,subjects){
      state.subjects = subjects;
    },
    submitPost(state){
      
  },
  get_post_content(state,data){
    state.postView.categories = data.categories;
    state.postView.related_posts = data.related_posts;
    state.postView.post_content = data.post_content;
    },
    set_subject(state,data){
      state.new_post.selected_primary_subject_id=data;
      state.new_post.selected_subject=state.new_post.subject_list.find(node=>node.id===data);
      state.new_post.selected_subject_id=state.new_post.selected_subject.id;
    },
    get_subject_list(state,data){
      state.new_post.primary_subject_list=[];
      state.new_post.primary_subject_list=state.new_post.subject_list;
      state.new_post.subject_list=[];
      state.new_post.subject_list = data.subject_list;
    },
  }