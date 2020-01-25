<template>
    <main>
        <div class="container pt-100">
            <div class="col-md-12">
                    <category-filter :categories="categories"></category-filter>
            </div>
            <div class="col-md-8 center-col">
        <div class="row">
            <div class="col-md-12">
                 <dashboard-post-container :posts="posts"></dashboard-post-container>   
            </div>   
        </div>
                </div>
            </div>
       
    </main>
</template>
<style scoped>
    .main-habit-builder {
        margin: auto;
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
</style>

<script>
import DashboardPostContainer from '../post/DashboardPostContainer';
import CategoryFilter from '../category/CategoryFilter';

import {mapState} from 'vuex';

export default {
    props:['posts','categories'],
	computed:{
		// ...mapState({
		// 	'posts': state=>state.dashboardPosts,
		// }),
	},        components:{
            DashboardPostContainer,CategoryFilter
        },
        data() {
            return {
            }
        },
        mounted(){
            // this.getDashboardPosts();
        },
        methods: {
            trans: function (string, defaultString) {
                return this.$trans('home', string, defaultString);
            },
            getDashboardPosts(){
                this.$store.dispatch('getPosts');
            },
            redirectPostView(post_id){
                this.$router.push({path:'/post/1'})
            }
        },
    }
</script>
