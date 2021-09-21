<template>
  <vue-editor
    id="homework_html"
    v-model="content"
    name="homework_html"
    :editor-options="editorSettings"
    :editor-toolbar="customToolbar"
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
			customToolbar: [
				[{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
				[{ 'header': [1, 2, 3, 4, 5, 6, false] }],
				[{ 'font': [] }],
				['bold', 'italic', 'underline', 'strike'],        // toggled buttons
				[{ 'align': '' }, { 'align': 'center' }, { 'align': 'right' }, { 'align': 'justify' }],
				['blockquote', 'code-block'],
				[{ 'list': 'ordered'}, { 'list': 'bullet' }],
				[{ 'indent': '-1'}, { 'indent': '+1' }],         // outdent/indent
				[{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
				['link','image','video'],
				['clean']
			],
		};
	}
};
</script>