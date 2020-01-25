<template>
    <main>
        <div v-if="postType==='article'">
        <vue-editor id="ArticleEditor" v-model="content" :editorOptions="editorSettings" @input="editContent" 
        :useCustomImageHandler="true" @image-added="handleImageAdded" :height="'100%'"/>
        </div>
        <div v-if="postType==='notice'">
        <vue-editor id="NoticeEditor" v-model="content" :editorOptions="editorSettings" @input="editContent" 
        :useCustomImageHandler="true" @image-added="handleImageAdded" :height="'100%'"/>
        </div>
        <div v-if="postType==='document'">
            <document/>
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
import EventBus from '../event-bus';
export default {
    components:{
        VueEditor,Document
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
        },
         handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
             console.log('here')
        // An example of using FormData
        // NOTE: Your key could be different such as:
        // formData.append('file', file)
        let url = '1234'; // Get url from response
        Editor.insertEmbed(cursorLocation, "image", url);
        var formData = new FormData();
        formData.append("image", file);
         let imageData={
             'cursorLocation':cursorLocation,
             'formData':formData,
             'url':url
         }
            this.$store.dispatch('storeContentImage',imageData);
        },
        /**
     * Has changed
     * @param  Object|undefined   newFile   Read only
     * @param  Object|undefined   oldFile   Read only
     * @return undefined
     */
    inputFile: function (newFile, oldFile) {
      if (newFile && oldFile && !newFile.active && oldFile.active) {
        // Get response data
        console.log('response', newFile.response)
        if (newFile.xhr) {
          //  Get the response status code
          console.log('status', newFile.xhr.status)
        }
      }
    },
    /**
     * Pretreatment
     * @param  Object|undefined   newFile   Read and write
     * @param  Object|undefined   oldFile   Read only
     * @param  Function           prevent   Prevent changing
     * @return undefined
     */
    inputFilter: function (newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Filter non-image file
        if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
          return prevent()
        }
      }

      // Create a blob field
      newFile.blob = ''
      let URL = window.URL || window.webkitURL
      if (URL && URL.createObjectURL) {
        newFile.blob = URL.createObjectURL(newFile.file)
      }
    }
    }
}
</script>
