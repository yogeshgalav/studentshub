const state = {
    new_post:{
      post_type:'article',
      selected_subject:{},
      heading:'',
      articleContent:{
        htmlContent:''
      },
      noticeContent:{
        htmlContent:'',
        expiry_date:''
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
        video_id:'',
        description:''
      },
      mcqContent:{
        question:'',
        option1:'',
        option2:'',
        option3:'',
        option4:'',
        answer:''
      },
    },
    categories: [],
    AuthUserCategory: 0,
    subjects: [],
  }
  export default state;