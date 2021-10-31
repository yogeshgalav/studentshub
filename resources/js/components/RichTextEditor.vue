<template>
  <div>
    <form enctype="multipart/form-data">
      <button
        type="button"
        class="btn btn-white"
        @click="addVideo"
      >
        Yotube video
      </button>
      <button
        type="button"
        class="btn btn-white"
        @click="addVideo"
      >
        Document
      </button>
      <button
        type="button"
        class="btn btn-white"
        @click="$refs.imageInput.click()"
      >
        Images
      </button>
      <input
        ref="imageInput"
        type="file"
        accept="image/*"
        hidden
        multiple
        @change="handleImage"
      >
      <vue-editor
        id="homework_html"
        ref="editor"
        :value="content"
        name="homework_html"
        :editor-options="editorSettings"
        :editor-toolbar="customToolbar"
        :height="'100%'"
        @input="$emit('update:content', $event)"
      />
    </form>
  </div>
</template>
<script>
import { VueEditor,Quill } from 'vue2-editor';
import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageResize', ImageResize);

export default {
	components:{
		VueEditor
	},
	props: ['content'],    
	data(){
		return {
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
	},
	methods:{
		addVideo(){
			let quill = this.$refs.editor.quill;
			const selection = quill.getSelection(); // get position of cursor (index of selection)
			quill.clipboard.dangerouslyPasteHTML(selection.index, '&nbsp;<b>World</b>');
		},
		addDocument(){
			let quill = this.$refs.editor.quill;
			const selection = quill.getSelection(); // get position of cursor (index of selection)
			quill.clipboard.dangerouslyPasteHTML(selection.index, '&nbsp;<b>World</b>');
		},
		handleImage(e){
			const selectedImage = e.target.files[0];
			this.getBase64(selectedImage).then(data=>{
				let $html= '<img src=\"'+data+'\" alt=\"Red dot\" />';
				let quill = this.$refs.editor.quill;
				let selection = quill.getSelection();
				quill.clipboard.dangerouslyPasteHTML(selection ? selection.index : 0, $html);
			});
		},
		getBase64(file) {
			return new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = () => resolve(reader.result);
				reader.onerror = error => reject(error);
			});
		}
	}
};
</script>