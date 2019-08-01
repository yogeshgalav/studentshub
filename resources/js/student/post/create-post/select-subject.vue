<template>
    <div class="card h-card">
                    <div class="card-header">

                        <div class="row">
                            <input type="text" @input="editSubject($event)">
                        </div>
                    </div>
                </div>
</template>
<script>
export default {
    methods:{
        editSubject(event){
            this.$store.dispatch('createPost',{post_subject:event.target.value});
        }
    }
}
</script>
