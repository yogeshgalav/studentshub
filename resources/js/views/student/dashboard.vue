<template>
    <main class=" pt-100 s_dashboard">
        <div class="container">
         <div class="row">
     <div class="col-md-8 center-col">
        <slot></slot>
        <a class=" h-card" :href="'/share-your-knowledge'">
        <div class="dash_card">
                        Share Your Knowledge
                    </div>  
                    </a>
         </div>
     </div> 
         <div class="row main_post_dash">

            <div class="col-md-8 center-col">

                 <home-post-container></home-post-container>   
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
