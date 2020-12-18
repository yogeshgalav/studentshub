<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header />
    
    <div
      v-for="(unit,index) in unitData"
      :key="index"
      class="card mt-5"
    >
      <div>
        <div class="row">
          <div class="col-md-12">
            <accordion
              :title="'Unit '+unit.unit_no+': '+unit.unit_name"
              :aria-expanded="true"
              tab="accordion_status_unit_active"
            >
              <div class="row add_cl_q">
                <div class="col-md-3 col-12">
                  <div class="mt-2">
                    <add-button
                      name="Add Document"
                      size="lg"
                      @submit="addDocument(unit.id)"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-12" />
              </div>
            </accordion>
          </div>

          <modal
            name="addDocumentModal"
            class="doubt_model model-md"
            :click-to-close="false"
          >
            <form
              @submit.prevent="saveDocument()"
            >
              <div class="row">
                <div class="col-md-12 mt-2">
                  <div class="row">
                    <div class="col-md-6">
                      <h4>Question</h4>
                    </div>
                    <div class="col-md-6 text-right">
                      <button
                        type="button"
                        class="btn btn-lg btn-link font-size-24"
                        @click="close()"
                      >
                        &times;
                      </button>
                    </div>
                  </div>
                </div>


                <div class="col-md-12">
                  <div class="form-group">
                    <label for="documentLink">Online Document Link</label>
                    <div class="inner-addon left-addon">
                      <div class="cl_input">
                        <input
                          id="documentLink"
                          v-model="document_link"
                          v-validate="'required'"
                          type="text"
                          name="document_link"
                          class="form-control"
                          @blur="embeddocument"
                        >
                        <span class="text-danger">{{ formErrors('document_link') }}</span>
                        <span class="text-danger">{{ document_error }}</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label for="documentDescription">Description:</label>
                    <div class="inner-addon left-addon">
                      <div class="cl_input">
                        <textarea
                          id="documentDescription"
                          v-model="description"
                          v-validate="'required'"
                          name="description"
                          class="form-control"
                          placeholder="say something about this document..."
                        />
                        <span class="text-danger">{{ formErrors('description') }}</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-1 row text-right">
                  <div class="col-md-12">
                    <hr>
                    <button
                      type="submit"
                      class="btn btn-outline-primary mb-2"
                    >
                      Submit
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </modal>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import Accordion from '../../components/accordion';
import AddButton from '../../components/AddButton';
    
import ClassroomHeader from '../../components/ClassroomHeader';
    
export default {
	components: {
		Accordion,
		AddButton,
		ClassroomHeader
	},
	mixins:[FormMixin],
	data() {
		return {
			showLoader:true,
			unitData: [],
			unit_id: '',
			document_link: '',
			description: '',
			document_error: '',
		};
	},
	mounted() {
		this.getDocuments();
	},
	methods: {
		getDocuments(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-documents').then((resp) => {
				this.documents = resp.data.success.documents;
				this.documents.map(node=>{
					let unit = this.unitData.find(node2=>node2.id===node.unit_id);
					if(unit){
						unit.documents.push({
							'id':node.document_id,
							'link':node.link,
							'description':node.description,
						});
					}else{
						this.unitData.push({
							'id':node.unit_id,
							'name':node.unit_name,
							'documents':[{
								'id':node.document_id,
								'link':node.link,
								'description':node.description,
							}]
						});
					}
				});
				this.showLoader=false;
			});
		},
		addDocument(unit_id) {
			this.unit_id = unit_id;
			this.$modal.show('addDocumentModal');
		},
		saveDocument() {
			this.$validator.validate().then(valid => {
				if(valid  && this.document_link && this.document_error===''){
					//call api and update field
					this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/add-document',{
						unit_id: this.unit_id,
						document_link: this.document_link,
						description: this.description,
					}).then(()=>{
						this.unit_id = '';
						this.document_link = '';
						this.description = '';
					});
				}
			});
		},
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
