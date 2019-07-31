<template>
    <main>
        <div class="row">
            <div class="col-3" v-for="type in postTypes" :key="type">
                <div class="post-type" @click="selectPostType(type)">
                    {{type}}
                </div>
            </div>
        </div>
    </main>
</template>
<style scoped>
.post-type{
    margin: 50%;
}
</style>

<script>
export default {
    data(){
        return{
            postTypes:[
                'Article',
                'Fact',
                'Notice',
                'Youtube Video',
                'Quora',
                'Link',
                'MCQ',
                ],
        }
    },
    methods:{
        selectPostType(type){
            this.$emit('selectPostType',type);
        }
    }
}
</script>
