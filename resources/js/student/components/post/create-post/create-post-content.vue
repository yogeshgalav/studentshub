<template>
    <main>
        <div v-if="$store.state.new_post.post_type.toLowerCase()==='article'">
        <vue-editor v-model="content" :editorOptions="editorSettings" @input="editContent" :height="'100%'"/>
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
    methods:{
        editContent(){
            this.$store.dispatch('createPost',{post_content:this.content});
        }
    }
}
</script>
