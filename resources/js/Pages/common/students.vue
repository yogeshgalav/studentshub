<template>
  <div>
    <div class="card row">
      <div class="card-body">
        <div class="col-md-3" />
        <div class="col-md-9" />
      </div>
    </div>
  </div>
</template>
<script>
export default {
    mounted(){
        this.axios.get('/api/get-students-interests');
    }
};
</script>