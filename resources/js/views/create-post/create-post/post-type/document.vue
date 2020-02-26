<template>
<div>
  <div class="container" role="main">
<h1><a href="/article-url"></a></h1>
<nav role="navigation">
<a href="https://css-tricks.com/examples/DragAndDropFileUploading/">Auto Submit</a>
<a href="https://css-tricks.com/examples/DragAndDropFileUploading/?submit-on-demand" class="is-selected">Submit On Demand</a>
</nav>
<form method="post" action="https://css-tricks.com/examples/DragAndDropFileUploading//?submit-on-demand" enctype="multipart/form-data" novalidate class=" text-center box has-advanced-upload">
<div class="box__input">
<svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z" /></svg>
<input type="file" name="files[]" id="file" class="box__file" data-multiple-caption="{count} files selected" multiple />
<label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>

</div>
<button type="submit" class="btn btn-primary mt-3">Upload</button>
<div class="box__uploading">Uploading&hellip;</div>
<div class="box__success">Done! <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?submit-on-demand" class="box__restart" role="button">Upload more?</a></div>
<div class="box__error">Error! <span></span>. <a href="https://css-tricks.com/examples/DragAndDropFileUploading//?submit-on-demand" class="box__restart" role="button">Try again!</a></div>
</form>
<footer>
<p><strong>Be sure to try the demo on a browser (e.g. IE 9 and below) that does not support drag&amp;drop file upload. You can also try with a JavaScript support disabled.</strong></p>
<p>The icon was borrowed from <a href="http://www.flaticon.com/free-icon/outbox_3686" target="_blank">FlatIcon</a>.</p>
</footer>
</div>
  <div class="example-vuex">
    
    <h1 id="example-title" class="example-title">Upload Here</h1>
    <div class="upload row">
      <ul>
        <li v-for="(file, index) in new_post.files" :key="index">
          <span>{{file.name}}</span> -
          <span>{{file.size | formatSize}}</span> -
          <span v-if="file.error">{{file.error}}</span>
          <span v-else-if="file.success">success</span>
          <span v-else-if="file.active">active</span>
          <span v-else-if="file.active">active</span>
          <span v-else></span>
        </li>
      </ul>
      <div class="col-md-8">
        
      <div class="example-btn box">
        <file-upload
        id="documentUpload"
          class="btn btn-primary"
          post-action="/upload/post"
          extensions="xlsx,xls,doc,docx,ppt,pptx,txt,pdf,gif,jpg,jpeg,png,webp"
          accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"
          :multiple="true"
          :drop="true"
          :size="1024 * 1024 * 10"
          :value="new_post.files"
          @input="inputUpdate"
          ref="upload">
          <i class="fa fa-plus"></i>
          Select files
        </file-upload>
      </div>
      </div>
      <div class="col-md-12">
        <button type="button" class="btn btn-success" v-if="!$refs.upload || !$refs.upload.active" @click.prevent="$refs.upload.active = true">
          <i class="fa fa-arrow-up" aria-hidden="true"></i>
          Start Upload
        </button>
        <button type="button" class="btn btn-danger"  v-else @click.prevent="$refs.upload.active = false">
          <i class="fa fa-stop" aria-hidden="true"></i>
          Stop Upload
        </button></div>
    </div>
  </div>
</div>
</template>
<style scoped>


.box
				{
					font-size: 1.25rem; /* 20 */
					background-color: #c8dadf;
					position: relative;
          padding:60px 20px;
          width: 100%;
          min-height: 300px;
          text-align: center;
				}
				.box.has-advanced-upload
				{
					outline: 2px dashed #92b0b3;
					outline-offset: -10px;

					-webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
					transition: outline-offset .15s ease-in-out, background-color .15s linear;
				}
				.box.is-dragover
				{
					outline-offset: -20px;
					outline-color: #c8dadf;
					background-color: #fff;
				}
					.box__dragndrop,
					.box__icon
					{
						display: none;
					}
					.box.has-advanced-upload .box__dragndrop
					{
						display: inline;
					}
					.box.has-advanced-upload .box__icon
					{
						width: 100%;
						height: 80px;
						fill: #92b0b3;
						display: block;
						margin-bottom: 40px;
					}

					.box.box__input
					{
						visibility: hidden;
					}
.box__input input[type="file"] {
    display: none;
}
					.box__uploading,
					.box__success,
					.box__error
					{
						display: none;
					}
					.box.is-uploading .box__uploading,
					.box.is-success .box__success,
					.box.is-error .box__error
					{
						display: block;
						position: absolute;
						top: 50%;
						right: 0;
						left: 0;

						-webkit-transform: translateY( -50% );
						transform: translateY( -50% );
					}
					.box__uploading
					{
						font-style: italic;
					}
					.box__success
					{
						-webkit-animation: appear-from-inside .25s ease-in-out;
						animation: appear-from-inside .25s ease-in-out;
					}
						@-webkit-keyframes appear-from-inside
						{
							from	{ -webkit-transform: translateY( -50% ) scale( 0 ); }
							75%		{ -webkit-transform: translateY( -50% ) scale( 1.1 ); }
							to		{ -webkit-transform: translateY( -50% ) scale( 1 ); }
						}
						@keyframes appear-from-inside
						{
							from	{ transform: translateY( -50% ) scale( 0 ); }
							75%		{ transform: translateY( -50% ) scale( 1.1 ); }
							to		{ transform: translateY( -50% ) scale( 1 ); }
						}

					.box__restart
					{
						font-weight: 700;
					}
					.box__restart:focus,
					.box__restart:hover
					{
						color: #39bfd3;
					}

					.box__file
					{
						width: 0.1px;
						height: 0.1px;
						opacity: 0;
						overflow: hidden;
						position: absolute;
						z-index: -1;
					}
					.box__file + label
					{
						max-width: 80%;
						text-overflow: ellipsis;
						white-space: nowrap;
						cursor: pointer;
						display: inline-block;
						overflow: hidden;
					}
					.box__file + label:hover strong,
					.box__file:focus + label strong,
					.box__file.has-focus + label strong
					{
						color: #39bfd3;
					}
					.box__file:focus + label,
					.box__file.has-focus + label
					{
						outline: 1px dotted #000;
						outline: -webkit-focus-ring-color auto 5px;
					}
						.js .box__file + label *
						{
							/* pointer-events: none; */ /* in case of FastClick lib use */
						}

					.no-js .box__file + label
					{
						display: none;
					}

					.no-js .box__button
					{
						display: block;
					}
					.box__button
					{
						font-weight: 700;
						color: #e5edf1;
						background-color: #39bfd3;
						display: block;
						padding: 8px 16px;
						margin: 40px auto 0;
					}
						.box__button:hover,
						.box__button:focus
						{
							background-color: #0f3c4b;
						}

.example-vuex label.btn {
  margin-bottom: 0;
  margin-right: 1rem;
}
/* .box{
  width: 100%;
  height: 100px;
  display: inline-block;
  	background:rgb(151, 151, 229);
} */


</style>

<script>
import { mapState } from 'vuex'
import FileUpload from 'vue-upload-component'
export default {
  components: {
    FileUpload,
  },
  computed: {
    ...mapState([
      'new_post',
    ])
  },
  methods: {
    inputUpdate(files) {
      this.$store.commit('updateFiles', files)
    },
  }
}
</script>
