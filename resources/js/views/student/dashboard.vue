<template>
    <main class=" pt-100 s_dashboard">
        <div class="container">
         <div class="row">
     <div class="col-md-8 col-12 center-col">
        <slot></slot>
        <a class=" h-card" :href="'/share-your-knowledge'"> <div class="dash_card know_img"><img src="/images/knowledge.svg" alt=""> Share Your Knowledge <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></div>  </a>
        <div class="home_post">
             <home-post-container></home-post-container>   
        </div>   

         </div>
<div class="col-md-4">
                <div class="category_part">
                    <div class="cat_head">
                        <h6>{{student_course}}</h6>
                    </div>
                   <div class="cat_list">
                          <p v-for="subject in course_subjects" :key="subject.id">
                              <a :href="subject.subject_url">{{subject.Subject_name}}</a>
                        </p>
                    </div>     
                </div>
                </div>
     </div> 
         <div class="row main_post_dash">

            <div class="col-md-8 center-col">

                
                </div>
         </div>
        </div>
    </main>
</template>
<style scoped>
    .main-habit-builder {
        margin: auto;
    }
    .pt-50
    {
        padding-top: 50px;
    }main.pt-100.s_dashboard {
    margin-left: 60px;
}
.dash_card.know_img img {
    margin-right: 10px;
    width: 30px;
}
.dash_card.know_img span {
    margin-left: 5px;
}
.dash_card.know_img {
    display: flex;
    align-items: center;
}
    .main-habit-builder .btn-default {
        background: #fff !important;
        box-shadow: 2px 2px 2px #bbbbcc;
        border: 1px solid #eee;
        font-size: 17px;
        font-family: Arial, Helvetica, sans-serif;
        color: #bbbbcc !important;
        font-weight: bold;
        margin-right: 20px;
        margin-bottom: 5px;
    }
    .share{
        position:fixed;
        z-index: 999;
    }
    .main-habit-builder input {
        color: #bbbbcc;
    }

    .main-habit-builder .card {
        padding: 20px !important;
    }

    .main-habit-builder h2 {
        font-size: 36px;
        font-weight: 600;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
    }

    .main-habit-builder p {
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        color: #000;
        margin: 2px 0px 2px 0px;
    }
.main_post_dash {
    margin-top: 20px;
}
.home_post {
    margin-top: 20px;
}

/* catergorry list css */

.cat_head {
    border-bottom: solid 1px #ccc;
    padding: 0px 0 5px;
    margin-bottom: 20px;
}

.cat_list a {
    color: black;
    font-weight: 600;
}
.cat_list a:hover
{
    text-decoration: none;
}
.cat_list {
    margin-left: 25px;
}
.cat_list p {
    /* margin: 0; */
    position: relative;
}

.cat_list p:before {
    position: absolute;
    content: '';
     background-color: #F2F2F2;
    width: 15px;
    height: 15px;
    border-radius: 50px;
    left: -25px;
    border: solid 1px #ccc;
    top: 3px;
}
@media only screen and (max-width: 600px) {
main.pt-100.s_dashboard {
    margin-left: 0;
}
}
</style>

<script>
import HomePostContainer from '../post-containers/HomePostContainer';

export default {
    
    components:{
            HomePostContainer
        },
        data() {
            return {
                student_course:'',
                course_subjects:[]
            }
        },
        mounted(){
            this.axios.get("/api/get-student-course-details").then((resp)=>{
                this.student_course=resp.data.success.course.course_name;
                this.course_subjects=resp.data.success.course.subjects;
            });
        },
        methods: {
            trans: function (string, defaultString) {
                return this.$trans('home', string, defaultString);
            },
            redirectPostView(post_id){
                this.$router.push({path:'/post/1'})
            }
        },
    }
</script>
