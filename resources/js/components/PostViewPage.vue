<template>
    
</template>
<script>
export default {
    mounted(){
        this.$store.dispatch('explore/getPostContent',this.$route.params.id);
    }
}
</script>
