<template>
<div class="row">
     <div class="col-md-8 offset-2">
                
                <div class="form-group">
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Enter Heading</p></div>
                    <label class="weight-500">Heading</label>
                    <input type="text" class="form-control" @input="editHeading($event)">
                </div>
            
               
            </div>
</div>
  
</template>
<script>
export default {
    methods:{
        editHeading(event){
            this.$store.dispatch('createPost',{field:'post_heading',post_heading:event.target.value});
        }
    }
}
</script>
