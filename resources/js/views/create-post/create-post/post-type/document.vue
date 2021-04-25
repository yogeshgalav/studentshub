<template>
<div>
  <div class="container" role="main">
<form enctype="multipart/form-data" novalidate class=" text-center box has-advanced-upload">
	<div class="box__input">
		<svg class="box__icon" xmlns="http://www.w3.org/2000/svg" width="50" height="43" viewBox="0 0 50 43"><path d="M48.4 26.5c-.9 0-1.7.7-1.7 1.7v11.6h-43.3v-11.6c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v13.2c0 .9.7 1.7 1.7 1.7h46.7c.9 0 1.7-.7 1.7-1.7v-13.2c0-1-.7-1.7-1.7-1.7zm-24.5 6.1c.3.3.8.5 1.2.5.4 0 .9-.2 1.2-.5l10-11.6c.7-.7.7-1.7 0-2.4s-1.7-.7-2.4 0l-7.1 8.3v-25.3c0-.9-.7-1.7-1.7-1.7s-1.7.7-1.7 1.7v25.3l-7.1-8.3c-.7-.7-1.7-.7-2.4 0s-.7 1.7 0 2.4l10 11.6z" /></svg>
		<label for="documentUpload"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
	</div>
	<file-upload
		id="documentUpload"
		class="btn btn-primary mt-3"
		post-action="/upload/post"
		extensions="xlsx,xls,doc,docx,ppt,pptx,pdf,jpg,jpeg,png"
		accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.pdf"
		:multiple="true"
		:drop="true"
		:size="1024 * 1024 * 10"
		v-model="files"
		ref="upload">
		Upload
	</file-upload>
	<div class="example-vuex">   
    <div class="upload row">
      <ul>
        <li v-for="(file, index) in files" :key="index">
          <span>{{file.name}}</span> - <span>{{file.size | formatSize}}</span>
        </li>
      </ul>
    </div>
  </div>
</form>
</div>
<div class="col-md-8">
<div class="document_text">
	<textarea type="text" v-model="description" placeholder="Description"></textarea>
</div>
</div>
</div>
</template>
<style scoped>
.document_text {
    margin-top: 30px;
}

.document_text textarea {
    width: 100%;
    border-radius: 4px;
	padding: 10px 15px;
    height: 80px;
}

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
import EventBus from '../../event-bus';

export default {
  components: {
    FileUpload,
  },
  data(){
	  return {
		  files:[],
		  description:'',
	  };
  },
  filters:{
	  formatSize(val){
		  let kb=val/1024;
		  let mb=kb/1024;
		  if(mb>1){
			  return parseFloat(mb).toFixed(1) +' MB';
		  }else if(kb>1){
			  return parseFloat(kb).toFixed(1) +' KB';
		  }else{
			  return val + ' bytes';
		  }
	  }
  },
  mounted(){
	  EventBus.$on('validateStep4', () => {
		  	const data = {files:this.files,description:this.description}
			this.$store.commit('set_post_document_content', data);
		  EventBus.$emit('validateWizard',4,true);
	  })
  },
}
</script>
