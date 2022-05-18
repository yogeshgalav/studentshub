<template>
  <div>
    <form enctype="multipart/form-data">
      <button
        type="button"
        class="btn btn-white mb-1"
        data-toggle="modal" 
        data-target="#urlModal"
        @click="addVideo"
      >
        YouTube video
      </button>
      <button
        type="button"
        class="btn btn-white mb-1"
        data-toggle="modal" 
        data-target="#urlModal"
        @click="addDocument"
      >
        Document
      </button>
      <button
        type="button"
        class="btn btn-white mb-1"
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
        v-model="content"
        name="homework_html"
        :editor-options="editorSettings"
        :editor-toolbar="customToolbar"
        :height="'100%'"
      />
      <!-- urlModal starts -->
      <div
        id="urlModal"
        class="modal"
        tabindex="-1"
        role="dialog"
      >
        <div
          class="modal-dialog modal-dialog-centered"
          role="document"
        >
          <div class="modal-content">
            <div class="modal-body">
              <form class="">
                <div class="form-group">
                  <label for="url">{{ pasteUrl }}</label>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <input
                    id="url"
                    v-model="url"
                    type="text"
                    name="url"
                    class="form-control"
                  >
                  <span class="text-danger">{{ url_error }}</span>
                </div>
                <div>
                  <button
                    type="button"
                    class="btn btn-primary"
                    @click="submitUrl"
                  >
                    Submit
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { VueEditor,Quill } from 'vue2-editor';
import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageResize', ImageResize);
// Import the BlockEmbed blot.
var BlockEmbed = Quill.import('blots/block/embed');

// Create a new format based off the BlockEmbed.
class Youtube extends BlockEmbed {
	static create(value) {

		var node = super.create(value);

		node.setAttribute('src', value);

		node.setAttribute('frameborder', '0');
		node.setAttribute('mozallowfullscreen', true);
		node.setAttribute('webkitallowfullscreen', true);
		node.setAttribute('allowfullscreen', true);
		node.setAttribute('width', '100%');
		node.setAttribute('height', '400');
		node.setAttribute('class', 'ql-align-center');
		return node;
	}

	static value(node) {
		return node.getAttribute('src');
	}

}

class EmbedDocment extends BlockEmbed {

	static create(value) {
		var node = super.create(value);
		node.setAttribute('src', value);
		node.setAttribute('type', 'application/pdf');
		node.setAttribute('width', '100%');
		node.setAttribute('height', '600px');
		return node;
	}

	static value(node) {
		return node.getAttribute('src');
	}
}

// Extending a class with our new functionality
class EmbedImage extends BlockEmbed {
	static create(value) {
		let node = super.create();
		node.setAttribute('alt', value.alt);
		node.setAttribute('src', value.src);
		return node;
	}

	static value(node) {
		return {
			alt: node.getAttribute('alt'),
			src: node.getAttribute('src')
		};
	}
}

EmbedImage.blotName = 'EmbedImage';
EmbedImage.tagName = 'img';

Quill.register(EmbedImage);
// Give our new Footer format a name to use in the toolbar.
Youtube.blotName = 'Youtube';
Youtube.tagName = 'iframe';
Quill.register(Youtube);

EmbedDocment.blotName = 'EmbedDocment';
EmbedDocment.tagName = 'embed';
Quill.register(EmbedDocment);
export default {
	components:{
		VueEditor
	},
	props: ['value'],   
	data(){
		return {
			url: '',
			url_type: '',
			url_error: '',
			video_id: '',
			document_link: '',
			content: this.value,
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
				['link'],
			],
		};
	},
	computed:{
		pasteUrl(){
			return this.url_type==='document' ?
				'Paste online document url ending with .pdf extenstion' :
				'Paste Youtube video url';
		},
	},
	// mounted(){
	// 	let quill = this.$refs.editor.quill;
	// 	quill.getModule('toolbar').addHandler('video', videoHandler);
	// },
	watch:{
		content(val){
			this.$emit('input',val);
		}
	},
	methods:{
		addVideo(){
			this.url_type='video';
		},
		addDocument(){
			this.url_type='document';
		},
		handleImage(e){
			const selectedImage = e.target.files[0];
			this.getBase64(selectedImage).then(data=>{
				let quill = this.$refs.editor.quill;
				let selection = quill.getSelection();
				quill.insertEmbed(selection ? selection.index : 0, 'EmbedImage', {
					alt: this.AuthUser.full_name,
					src: data,
				});
			});
		},
		getBase64(file) {
			return new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = () => resolve(reader.result);
				reader.onerror = error => reject(error);
			});
		},
		submitUrl(){
			let quill = this.$refs.editor.quill;
			const selection = quill.getSelection(); // get position of cursor (index of selection)
			const cursor_index = selection ? selection.index : (this.content.length);
			if(this.url_type==='video' && this.isVideoUrlValid()){
				quill.insertEmbed(cursor_index, 'Youtube', 'https://www.youtube.com/embed/'+ this.video_id);
			}else if(this.url_type==='document'  && this.isDocumentUrlValid()){
				quill.insertEmbed(cursor_index, 'EmbedDocment', this.document_link);
			}
			if(!this.url_error){
				$('#urlModal').modal('hide');
			}
			return true;
		},isVideoUrlValid() {
			this.url_error = '';
			if (this.url === '') {
				this.url_error = 'An Youtube video link is required.';
				return false;
			}
			let id = this.matchYoutubeUrl();

			if (id !== false) {
				this.video_id = id;
				return true;
			}
			this.url_error = 'This video link is not supported';
			return false;
		},
		matchYoutubeUrl() {
			var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
			var matches = this.url.match(p);

			if (matches) {
				return matches[1];
			}
			return false;
		},
		isDocumentUrlValid(){
			this.url_error='';
			if(this.url===''){
				this.url_error='A document link is required.';
				return false;
			}
			let link = this.matchDocumentUrl();
        
			if(link!==false){
				this.document_link=link;
				return true;
			}
			this.url_error='This document link is not supported';
			return false;
		},
		matchDocumentUrl(){
			let doc_url = this.url.replace(/#[^#]*$/, '').replace(/\?[^\?]*$/, '');
			if(doc_url.indexOf('.pdf')>-1){
				return doc_url;
			}
			return false;
		},
	}
};
</script>