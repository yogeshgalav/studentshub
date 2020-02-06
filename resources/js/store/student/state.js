const state = {
    new_post:{
      post_type:'article',
      postContent:{},
      post_heading:'',
      selected_subject_id:'',
      selected_subject:{
        'id':null,
        'subject_name':'',
      },
      selected_primary_subject_id:'',
      subject_list:[],
      primary_subject_list:[],
    },
    categories: [],
    AuthUserCategory: 0,
    subjects: [],
    files: [],
    dashboardPosts: [],
    postView:{
      'categories':[],
      'related_posts':[],
      'post_content':[],
    }
  }
  export default state;