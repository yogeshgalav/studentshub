<template>
<div class="row">
            <div class="col-md-8 offset-2">
                
                <div class="form-group">
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Choose Category</p></div>
                    <label class="weight-500">Choose Category</label>
                    <select class="form-control custom-select" @input="selectPostType($event)">
                        <option v-for="type in postTypes" :key="type">
                             {{type}}
                            
                        </option>
                    </select>
                </div>
                <div class="form-group">
 <label class="weight-500">Select Subject</label>
<select class="form-control custom-select" @input="editSubject($event)">
    <option>Select Subject</option>
</select>
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
