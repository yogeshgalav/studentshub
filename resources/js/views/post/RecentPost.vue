<template>
    <div>
        
    </div>
</template>
<style scoped>
    

</style>
<script>
    import {
        mapState
    } from 'vuex';

    export default {
        computed: {
            ...mapState({
                'posts': state => state.guest.posts.ExploreSidebar,
            }),
        },
        methods: {}
    }

</script>
