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
      v-for="(unit,index) in documentUnitData"
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
              <div class="row add_cl_q">
                <ol>
                  <li 
                    v-for="(document,index2) in unit.documents"
                    :key="index2"
                    class="col-md-10 col-12 mt-2"
                  >
                    <a :href="document.link">{{ document.link }}</a>
                    <p>{{ document.description }}</p>
                  </li>
                </ol>
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
                      <h4>Add Document Link</h4>
                    </div>
                    <div class="col-md-6 text-right">
                      <button
                        type="button"
                        class="btn btn-lg btn-link font-size-24"
                        @click="$modal.hide('addDocumentModal')"
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
                        <input
                          id="documentDescription"
                          v-model="description"
                          v-validate="'required'"
                          name="description"
                          class="form-control"
                          placeholder="say something about this document..."
                        >
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
			documentUnitData: [],
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
				this.documentUnitData = resp.data.success.documentUnitData.map(node=>{
					node.documents = node.classroom_documents.map(node2=>{
						let new_node = {};
						new_node['id'] = node2.id;
						new_node['description'] = node2.description;
						new_node['link'] = node2.document.link;
						return new_node;
					});
					return node;
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
						let document = this.documentUnitData.find(node=>node.id===this.unit_id);
						document.documents.push({
							document_link:document_link,
							description:description,
						});
			      this.$modal.hide('addDocumentModal');
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
