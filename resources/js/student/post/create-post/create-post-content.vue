<template>
    <main>
        <vue-editor v-model="content" :height="'100%'"/>
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
    }
}
</script>
