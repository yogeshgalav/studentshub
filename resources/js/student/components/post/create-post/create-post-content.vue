<template>
    <main>
        <div v-if="postType==='article'">
        <vue-editor v-model="content" :editorOptions="editorSettings" @input="editContent" useCustomImageHandler @image-added="handleImageAdded" :height="'100%'"/>
        </div>
        <div v-if="postType==='video'">
        <input type="text" v-model="video_link" @input="editConent">
        <input type="text" v-model="video_description" @input="editConent">
        </div>
    </main>
</template>
<script>
import { VueEditor } from "vue2-editor";
// import { Quill } from "quill";
// import { ImageDrop } from "quill-image-drop-module";
// import { ImageResize } from "quill-image-resize-module";
// Quill.register("modules/imageDrop", ImageDrop);
// Quill.register("modules/imageResize", ImageResize);

export default {
    components:{
        VueEditor,
        // Quill
    },
    data(){
        return{
            content:'',
            video_link:'',
            video_description:'',
            editorSettings: {
        // modules: {
        //   imageDrop: true,
        //   imageResize: {
        //     displaySize: true
        //   }
        // }
      }
        }
    },
    computed:{
        postType(){
            return this.$store.state.new_post.post_type.toLowerCase();
        }
    },
    methods:{
        editContent(){
            this.$store.dispatch('createPost',{postContent:{content:this.content}});
        },
        addVideo(){
            this.$store.dispatch('createPost',{
                postContent:{
                    video_link:this.video_link,
                    video_description:this.video_description
                    }
                });
        },
         handleImageAdded: function(file, Editor, cursorLocation, resetUploader) {
        // An example of using FormData
        // NOTE: Your key could be different such as:
        // formData.append('file', file)

        var formData = new FormData();
        formData.append("image", file);

        this.$axios({
            url: "/api/save-post-image",
            method: "POST",
            data: formData
        })
            .then(result => {
            let url = result.data.url; // Get url from response
            Editor.insertEmbed(cursorLocation, "image", url);
            resetUploader();
            })
            .catch(err => {
            console.log(err);
            });
        }
    }
}
</script>
