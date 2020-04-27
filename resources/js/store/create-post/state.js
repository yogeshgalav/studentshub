const state = {
    new_post:{
      post_type:'article',
      selected_subject:{},
      heading:'',
      articleContent:{
        htmlContent:''
      },
      noticeContent:{
        htmlContent:''
      },
      documentContent:{
        files:'',
        description:''
      },
      factContent:{
        image:'',
        description:''
      },
      videoContent:{
        link:'',
        description:''
      },
    },
    categories: [],
    AuthUserCategory: 0,
    subjects: [],
  }
  export default state;