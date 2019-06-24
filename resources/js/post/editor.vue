<template>
  <vue-editor
    v-model="content"
    @focus="onEditorFocus"
    @blur="onEditorBlur"
    @selection-change="onSelectionChange"
  />
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
  components: { VueEditor },
  props:['content'],
  data: () => ({
    share_content: ""
  }),

  methods: {
    onEditorBlur(quill) {
      console.log("editor blur!", quill);
    },

    onEditorFocus(quill) {
      console.log("editor focus!", quill);
    },

    onSelectionChange(range) {
      console.log("selection change!", range);
    }
  }
};
</script>
// var content = [
//   { text: 'Hel' },
//   { text: 'lo' },
//   { text: 'World', attributes: { bold: true } }
// ];