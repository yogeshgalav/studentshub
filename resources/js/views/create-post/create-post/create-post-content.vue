<template>
  <div class="creat_post_card img_der">
    <main>
        <div v-if="postType==='article'">
        <vue-editor id="ArticleEditor" v-model="content" :editorOptions="editorSettings" @input="editContent" 
        :height="'100%'"/>
        </div>
        <div v-if="postType==='notice'">
        <vue-editor id="NoticeEditor" v-model="content" :editorOptions="editorSettings" @input="editContent" 
        :height="'100%'"/>
        </div>
        <div v-if="postType==='document'">
            <document/>
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
                      <button type="submit"  class="login_btn"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span> Back </button>
                <button type="submit" class="login_btn">Next <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></button>
                </div>
  </div>
</template>
<script>
import { VueEditor,Quill } from 'vue2-editor'

import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register("modules/imageDrop", ImageDrop);
Quill.register("modules/imageResize", ImageResize);
import Document from './post-type/document';
import Fact from './post-type/fact.vue';
import NetVideo from './post-type/video.vue';
import Mcq from './post-type/mcq.vue';
import EventBus from '../event-bus';
export default {
    components:{
        VueEditor,Document,Fact,Mcq,NetVideo
    },
    data(){
        return{
            content:'',
            files:[],
            editorSettings: {
            modules: {
                imageDrop: true,
                imageResize: {},
              }
            } 
        }
    },
    computed:{
        postType(){
            return this.$store.state.new_post.post_type.toLowerCase();
        }
    },
    mounted(){
        EventBus.$on('validateStep2',()=>{
			this.$validator.validate().then(valid => {
				if(valid){
					EventBus.$emit('validateWizard',2,true);
				}else{
					EventBus.$emit('validateWizard',2,false);
				}
			});
		});
    },
    methods:{
        editContent(){
            this.$store.commit('set_post_article_content',{postContent:this.content});
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