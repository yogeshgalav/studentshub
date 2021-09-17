<template>
  <vue-editor
    id="homework_html"
    v-model="content"
    name="homework_html"
    :editor-options="editorSettings"
    :height="'100%'"
  />
</template>
<script>
import { VueEditor,Quill } from 'vue2-editor';
import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageResize', ImageResize);

export default {
	prop: ['value'],
	components:{
		VueEditor
	},    
	data(){
		return {
			content:'',
			editorSettings: {
				modules: {
					imageDrop: true,
					imageResize: {},
				}
			},
		};
	}
};
</script>