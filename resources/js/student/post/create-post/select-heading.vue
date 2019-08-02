<template>
    <div class="card h-card">
                    <div class="card-header">

                        <div class="row">
                            <label>Heading</label>
                            <input type="text" @input="editHeading($event)">
                        </div>
                    </div>
                </div>
</template>
<script>
export default {
    methods:{
        editHeading(event){
            this.$store.dispatch('createPost',{post_heading:event.target.value});
        }
    }
}
</script>
