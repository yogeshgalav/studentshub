<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header />
    <div>
      <div class="row">
        <div class="col-md-12">
          <select
            v-model="current_unit"
            class="form-control minimal"
          >
            <option
              v-for="(unit,index) in resourceUnitData"
              :key="index"
              :value="unit.id"
            >
              {{ 'Unit '+unit.unit_no+': '+unit.unit_name }}
            </option>
          </select>

          <div
            v-if="AuthTeacher && AuthTeacher.id===classroomDetail.teacher_id"
            class="row add_cl_q"
          >
            <div class="col-md-3 col-12">
              <div class="mt-2">
                <add-button
                  name="Add Resource"
                  size="lg"
                  @submit="addResource"
                />
              </div>
            </div>
            <div class="col-md-3 col-12" />
          </div>
          <div class="row add_cl_q">
            <div 
              v-for="(resource,index2) in resources"
              :key="index2"
              class="col-md-10 col-12 mt-2 card"
            >
              <div 
                class="card-body"
              >
                <p>{{ $dayjs(resource.created_at).format('D MMMM, YYYY') }}</p>
                <hr>
                <p>{{ resource.description }}</p>
                <a
                  :href="resource.link"
                  target="_blank"
                >{{ resource.link }}</a>

                <div
                  v-if="resource.type==='youtubeVideo'"
                  class="video_image"
                >
                  <iframe
                    :src="resource.link"
                    width="320"
                    height="240"
                    webkitallowfullscreen
                    mozallowfullscreen
                    allowfullscreen
                  />
                </div>
              </div>
            </div>
            <div class="col-md-3 col-12" />
          </div>
        </div>

        <modal
          name="addResourceModal"
          class="doubt_model model-md"
          :click-to-close="false"
        >
          <form
            @submit.prevent="saveResource()"
          >
            <div class="row">
              <div class="col-md-12 mt-2">
                <div class="row">
                  <div class="col-md-6">
                    <h4>Add Resource Link</h4>
                  </div>
                  <div class="col-md-6 text-right">
                    <button
                      type="button"
                      class="btn btn-lg btn-link font-size-24"
                      @click="$modal.hide('addResourceModal')"
                    >
                      &times;
                    </button>
                  </div>
                </div>
              </div>


              <div class="col-md-12">
                <div class="form-group">
                  <label for="resourceLink">Online Resource Link</label>
                  <div class="inner-addon left-addon">
                    <div class="cl_input">
                      <input
                        id="resourceLink"
                        v-model="resource_link"
                        v-validate="'required'"
                        type="text"
                        name="resource_link"
                        class="form-control"
                        @blur="embedresource"
                      >
                      <span class="text-danger">{{ formErrors('resource_link') }}</span>
                      <span class="text-danger">{{ resource_error }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label for="resourceDescription">Description:</label>
                  <div class="inner-addon left-addon">
                    <div class="cl_input">
                      <input
                        id="resourceDescription"
                        v-model="description"
                        v-validate="'required'"
                        name="description"
                        class="form-control"
                        placeholder="say something about this resource..."
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
</template>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import AddButton from '../../components/AddButton';
    
import ClassroomHeader from '../../components/ClassroomHeader';
    
export default {
	components: {
		AddButton,
		ClassroomHeader
	},
	mixins:[FormMixin],
	data() {
		return {
			showLoader:true,
			resourceUnitData: [],
			current_unit: '',
			resource_link: '',
			description: '',
			resource_error: '',
			resource_type: '',
		};
	},
	computed:{
		resources(){
			if(this.current_unit){
				return this.resourceUnitData.find(node => node.id === this.current_unit).classroom_resources;
			}
			return [];
		},
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		}
	},
	mounted() {
		this.getResources();
	},
	methods: {
		getResources(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-resources').then((resp) => {
				this.resourceUnitData = resp.data.success.resourceUnitData;
				this.current_unit = this.resourceUnitData.length ? this.resourceUnitData[0].id : '';
				this.showLoader=false;
			});
		},
		addResource() {
			this.$modal.show('addResourceModal');
		},
		saveResource() {
			this.$validator.validate().then(valid => {
				if(valid  && this.resource_link && this.resource_error===''){
					//call api and update field
					this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/add-resource',{
						unit_id: this.current_unit,
						resource_link: this.resource_link,
						resource_type: this.resource_type,
						description: this.description,
					}).then(()=>{
						let resource = this.resourceUnitData.find(node=>node.id===this.current_unit);
						resource.classroom_resources.push({
							link:this.resource_link,
							type:this.resource_type,
							description:this.description,
						});
			      this.$modal.hide('addResourceModal');
						this.resource_link = '';
						this.description = '';
					});
				}
			});
		},
		embedresource(event){
			this.resource_error='';
			let url =event.target.value.trim();
			if(url===''){
				this.resource_error='A resource link is required.';
				return false;
			}
			let link = this.matchResourceUrl(url);
        
			if(link!==false){
				this.resource_link=link;
				return true;
			}else{
				this.resource_error='This resource link is not supported';
				return false;
			}        
		},
		matchResourceUrl(link){
			var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
			var matches = link.match(p);
			if(matches){
				this.resource_type = 'youtubeVideo';
				return 'https://www.youtube.com/embed/' + matches[1];
			}
			let url = link.replace(/#[^#]*$/, '').replace(/\?[^\?]*$/, '');
			if(url.indexOf('.pdf')>-1){
				this.resource_type = 'documentLink';
				return url;
			}
			if(url.indexOf('drive.google.com')>-1 || url.indexOf('docs.google.com')>-1){
				this.resource_type = 'googleDrive';
				return url;
			}
			return false;
		}
	}
};

</script>
