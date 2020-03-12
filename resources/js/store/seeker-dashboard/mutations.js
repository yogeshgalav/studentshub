export default {
    create_post(state,post){
      state.new_post = Object.assign(state.new_post,post)
    },
    add_post_like(state,post_id){
      state.dashboardPosts.map(node=>{
        if(node.id===post_id){
          node.total_likes=node.total_likes+1
        };
        return node;
      });
    },
    add_post_dislike(state,post_id){
      state.dashboardPosts.map(node=>{
        if(node.id===post_id){
          node.total_likes=node.total_likes+1
        };
        return node;
      });
    },
    get_posts(state,posts){
      state.dashboardPosts = posts.data;
    },
    get_categories(state,categories){
      state.categories = categories;
      state.new_post.subject_list=categories;
    },
    get_subjects(state,subjects){
      state.subjects = subjects;
    },
  //   submitPost(state){
  //     axios({url: window.App.baseUrl+'/api/submit-post', data: state.new_post, method: 'POST' })
  //     .then(() => {

  //     })
  //     .catch(() => {
        
  //     })
  // },
  get_post_content(state,data){
    state.postView.categories = data.categories;
    state.postView.related_posts = data.related_posts;
    state.postView.post_content = data.post_content;
    },
    set_subject(state,data){
      state.new_post.selected_primary_subject_id=data;
      state.new_post.selected_subject=state.new_post.subject_list.find(node=>node.id===data);
    },
    get_subject_list(state,data){
      state.new_post.primary_subject_list=[];
      state.new_post.primary_subject_list=state.new_post.subject_list;
      state.new_post.subject_list=[];
      state.new_post.subject_list = data.subject_list;
    },
  }