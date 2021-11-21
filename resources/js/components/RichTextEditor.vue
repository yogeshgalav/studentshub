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
        Yotube video
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
        @selection-change=""
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

export default {
	components:{
		VueEditor
	},
	props: ['content'],    
	data(){
		return {
			url: '',
			url_type: '',
			url_error: '',
			video_id: '',
			document_link: '',
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
	computed:{
		pasteUrl(){
			return this.url_type==='document' ?
				'Paste online document url ending with .pdf extenstion' :
				'Paste Youtube video url';
		},
	},
	mounted(){
		let quill = this.$refs.editor.quill;
		quill.getModule('toolbar').addHandler('video', videoHandler);
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
		},
		submitUrl(){
			let quill = this.$refs.editor.quill;
			const selection = quill.getSelection(); // get position of cursor (index of selection)
			if(this.url_type==='video' && this.isVideoUrlValid()){
				let videoHtml = '<iframe src="https://www.youtube.com/embed/'+ this.video_id + '" width="320" height="240" webkitallowfullscreen mozallowfullscreen allowfullscreen />';
								console.log(videoHtml);

				quill.clipboard.dangerouslyPasteHTML(selection ? selection.index : 0, videoHtml);
			}else if(this.url_type==='document'  && this.isDocumentUrlValid()){
				let documentHtml ='<embed src="'+this.document_link+'" type="application/pdf" width="100%" height="600px" />';
				console.log(documentHtml);
				quill.clipboard.dangerouslyPasteHTML(selection ? selection.index : 0, documentHtml);
			}
			if(!this.url_error){
				$('#urlModal').modal('hide');
			}
			return true;
		},
		isVideoUrlValid() {
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
		videoHandler() {
			let url = prompt('Enter Video URL: ');
			url = getVideoUrl(url);
			let range = quill.getSelection();
			if (url !== null) {
				quill.insertEmbed(range, 'video', url);
			}
		},getVideoUrl(url) {
			let match = url.match(/^(?:(https?):\/\/)?(?:(?:www|m)\.)?youtube\.com\/watch.*v=([a-zA-Z0-9_-]+)/) ||
        url.match(/^(?:(https?):\/\/)?(?:(?:www|m)\.)?youtu\.be\/([a-zA-Z0-9_-]+)/) ||
        url.match(/^.*(youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/);
			console.log(match[2]);
			if (match && match[2].length === 11) {
				return ('https') + '://www.youtube.com/embed/' + match[2] + '?showinfo=0';
			}
			if (match = url.match(/^(?:(https?):\/\/)?(?:www\.)?vimeo\.com\/(\d+)/)) { // eslint-disable-line no-cond-assign
				return (match[1] || 'https') + '://player.vimeo.com/video/' + match[2] + '/';
			}
			return null;
		}
	}
};
</script>