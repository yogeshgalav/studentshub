<template>
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
            <div class="row">
                <div class="col-md-8">
                    <label for="videoLink">Youtube Video Link</label>

                    <input type="text" id="videoLink" v-model="video_link" @blur="addVideo">
                    
                </div>
                <div class="col-md-8 mt-2">
                    <label for="videoDescription">A little Description</label>
                    <textarea id="videoDescription" v-model="video_description" @blur="addVideo" />
                </div>
            </div>
        </div>
    </main>
</template>
<script>
import { VueEditor,Quill } from 'vue2-editor'

import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register("modules/imageDrop", ImageDrop);
Quill.register("modules/imageResize", ImageResize);
import Document from './post-type/document';
import Fact from './post-type/fact';
import MCQ from './post-type/mcq';
import EventBus from '../event-bus';
export default {
    components:{
        VueEditor,Document,Fact,MCQ
    },
    data(){
        return{
            content:'',
            files:[],
            video_link:'',
            video_description:'',
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
            this.$store.dispatch('createPost',{field:'postContent',postContent:{content:this.content}});
        },
        addVideo(){
            let data={};
            data.link=this.video_link;
            data.description=this.video_description;
            data.field='postContent';
            this.$store.dispatch('createPost',data);
        }
    }
}
</script>
