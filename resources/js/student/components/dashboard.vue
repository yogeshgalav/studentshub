<template>
    <main>
        <slot></slot>
        <router-link class="btn btn-primary" :to="'/share-your-knowledge'">share</router-link>
        
        <div class="row main-habit-builder">
            <div class="col-md-6">
                <div class="card h-card" @click="redirectPostView(1)" v-for="post in $store.state.dashboardPosts" :key="post.id">
                    <div class="card-header">

                        <div class="row">
                            {{post.content}}

                        </div>
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
import { mapGetters } from 'vuex'

    export default {
        data() {
            return {
            }
        },
        mounted(){
            this.getDashboardPosts();
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
