<template>
    <main class=" pt-100 s_dashboard">
        <div class="container">
         <div class="row">
     <div class="col-md-6 col-12 center-col">
        <slot></slot>
        <a class=" h-card" :href="'/share-your-knowledge'"> <div class="dash_card">Share Your Knowledge</div>  </a>
        <div class="home_post">
             <home-post-container></home-post-container>   
        </div>   

         </div>
<div class="col-md-6 center-col">
                <div class="category_part">
                    <div class="cat_head">
                        <h6>CATEROIES</h6>
                    </div>
                   <div class="cat_list">
                          <p><a href="">Technology</a></p>
                          <p><a href="">Mangament</a></p>
                          <p><a href="">Health Care</a></p>
                          <p><a href="">Arts</a></p>
                          <p><a href="">Science</a></p>
                          <p><a href="">Economics</a></p>
                          <p><a href="">Education</a></p>
                          <p><a href="">Pharmacy</a></p>
                          <p><a href="">Journalism</a></p>
                          <p><a href="">Humanity</a></p>
                          <p><a href="">Hospitality</a></p>
                          <p><a href="">Fashion</a></p>
                          <p><a href="">Computer</a></p>
                          
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

</style>

<script>
import HomePostContainer from '../post-containers/HomePostContainer';

export default {
    
    components:{
            HomePostContainer
        },
        data() {
            return {
            }
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
