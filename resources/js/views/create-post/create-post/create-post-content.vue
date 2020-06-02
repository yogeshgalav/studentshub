<template>
  <div class="creat_post_card img_der artical_page">
    <main>
        <div v-if="postType==='article'">
            <blog-article/>
        </div>
        <div v-if="postType==='fact'">
            <fact/>
        </div>
        <div v-if="postType==='mcq'">
            <mcq/>
        </div>
        <div v-if="postType==='video'">
            <net-video />
        </div>
    </main>
    <div class="creat_post_btn">
        <button type="button" @click="prevTab" class="login_btn"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span> Back </button>
        <button type="button" @click="nextTab" class="login_btn">Next <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></button>
    </div>
  </div>
</template>
<script>
import BlogArticle from './post-type/blog-article';
import Fact from './post-type/fact.vue';
import NetVideo from './post-type/video.vue';
import Mcq from './post-type/mcq.vue';

export default {
    components:{
        BlogArticle,Document,Fact,Mcq,NetVideo,Notice
    },
    computed:{
        postType(){
            return this.$store.state.new_post.post_type.toLowerCase();
        },
    },
    methods:{
        nextTab(){
            EventBus.$emit('nextTab');
        },
        prevTab(){
            EventBus.$emit('prevTab');
        },
    }
}
</script>
<style  scoped>
.creat_post_btn button {
    margin: 20px 15px 0px 0;
    width: auto;
}

.creat_post_btn {
    display: flex;
}
.creat_post_card {
    padding: 20px;
}
button.login_btn span {
    margin: 0px 5px;
}
.creat_post_card .form-control
{
    border-radius: 0;
      transform: inherit;
    }
</style>