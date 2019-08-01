<template>
    <main>
        <div v-if="$store.state.new_post.post_type.toLowerCase()==='article'">
        <vue-editor v-model="content" @input="editContent" :height="'100%'"/>
        </div>
    </main>
</template>
<script>
import { VueEditor } from "vue2-editor";
export default {
    components:{
        VueEditor
    },
    data(){
        return{
            content:'',
        }
    },
    methods:{
        editContent(){
            this.$store.dispatch('createPost',{post_content:this.content});
        }
    }
}
</script>
