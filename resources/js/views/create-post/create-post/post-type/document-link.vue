<template>
  <div class="document_box">
    <div class="row">
      <div class="col-md-4">
        <div class="document_link form-group">
          <label for="documentLink">Online Document Link</label>

          <input
            id="documentLink"
            v-model="document_link"
            v-validate="'required'"
            type="text"
            name="youtube_document_link"
            class="form-control"
            @blur="embeddocument"
          >
          <span class="text-danger">{{ document_error }}</span>
        </div>
      </div>
      <div class="col-md-8" />
    </div>
    <div class="row">
      <div class="col-md-8 mt-2">
        <div class="document_des">
          <label for="documentDescription">Description:</label>
          <textarea
            id="documentDescription"
            v-model="description"
            v-validate="'required'"
            name="description"
            placeholder="say something about this document..."
          />
          <span class="text-danger">{{ formErrors('description') }}</span>
        </div>
      </div>
    </div>
  </div>   
</template>
<style>
.document_link input {
    width: 100%;
    transform: inherit;
}
.document_image {
    background-color: #ccc;
    /* padding: 50px; */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 240px;
    width: 320px;
    font-size: 60px;
}
.document_des textarea {
    width: 100%;
    border-radius: 5px;
    height: 65px;
}
</style>
<script>
import FormMixin from '../../../../components/mixins/form-mixin.js';
import { mapState } from 'vuex';
import EventBus from '../../event-bus';

export default {
	mixins:[FormMixin],
	props:['newPost'],
	data(){
		return {
			document_link:this.newPost.document_link,
			document_error:'',
			description:this.newPost.description,
			is_embeded:false
		};
	},
  
	mounted(){
	  EventBus.$on('validateStep2', () => {
			this.$validator.validate().then(valid => {
				if(valid  && this.document_link && this.document_error===''){
					const data = {document_link:this.document_link,description:this.description};
					this.$store.commit('set_post_document_content', data);
					EventBus.$emit('validateWizard',2,true);
				}else{
					EventBus.$emit('validateWizard',2,false);
				}
			});
	  });
	},
	methods: {
		embeddocument(event){
			this.document_error='';
			let url =event.target.value.trim();
			if(url===''){
				this.document_error='A document link is required.';
				return false;
			}
			let link = this.matchDocumentUrl(url);
        
			if(link!==false){
				this.document_link=link;
				return true;
			}else{
				this.document_error='This document link is not supported';
				return false;
			}        
		},
		matchDocumentUrl(link){
			let url = link.replace(/#[^#]*$/, '').replace(/\?[^\?]*$/, '');
			if(url.indexOf('.pdf')>-1){
				return url;
			}
			return false;
		}
	}
};
</script>