<template>
<main>
     <modal name="edit-modal">
            hello world
        </modal>
</main>
</template>
<script>

export default {
     data() {
    return {
      content:'',
    }
  },
    methods:{
        openModal () {
    this.$modal.show('edit-modal');
  },
  hide () {
    this.$modal.hide('edit-modal');
  }
    }
}
</script>
