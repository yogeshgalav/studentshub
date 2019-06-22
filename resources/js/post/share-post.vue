<template>
  <editor :content="content"></editor>
</template>

<script>
// Import the editor
import Editor from './editor'

export default {
  components: {
    Editor,
  },
  data() {
    return {
      content:'',
    }
  },
}
</script>