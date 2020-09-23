<template>
  <button
    type="button"
    :class="[buttonsize, 'btn btn-success btn-labeled']"
    @click="$emit('submit')"
  >
    <span class="btn-label bg-success-accent"><i class="fa fa-plus" /></span>{{ name }}
  </button>
</template>
<style scoped>
    .btn-label {
        padding: 15px;
        text-align: center;
        margin-right: 50px;
        border-radius: 3px 0 0 3px;
    }
    .btn-labeled {
        padding: 0 70px 0 0 !important;
    }
</style>
<script>
export default {

	props:{ 
    name:
    { type:String, default: 'Add' },
     size:
    { type:String, default: 'md' },
  },
  computed: {
    buttonsize() {
   if(this.size === 'md')  {
    return 'btn-md'
   }
    if(this.size === 'lg')  {
    return 'btn-lg'
   }
     if(this.size === 'sm')  {
    return 'btn-sm'
   }
   return false
    
  } }
}
</script>
