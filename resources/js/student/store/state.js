const state = {
    new_post:{
      post_type:'article',
      post_content:'',
      post_subject:'',
      post_heading:'',
      selected_subject_id:'',
      selected_subject:'',
      selected_primary_subject_id:'',
      subject_list:[],
      primary_subject_list:[],
    },
    categories: [],
    subjects: [],
    dashboardPosts: [],
    postView:{
      'categories':[],
      'related_posts':[],
      'post_content':[],
    }
  }
  export default state;