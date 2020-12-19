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
                      name="Add Video"
                      size="lg"
                      @submit="addVideo(unit.id)"
                    />
                  </div>
                </div>
                <div class="col-md-3 col-12" />
              </div>
            </accordion>
          </div>

          <modal
            name="addVideoModal"
            class="doubt_model model-md"
            :click-to-close="false"
          >
            <form
              @submit.prevent="submitVideo()"
            >
              <div class="video_box">
                <div class="row">
                  <div class="col-md-4">
                    <div class="video_link form-group">
                      <label for="videoLink">Online Video Link</label>

                      <input
                        id="videoLink"
                        v-model="video_link"
                        v-validate="'required'"
                        type="text"
                        name="youtube_video_link"
                        class="form-control"
                        @blur="embedvideo"
                      >
                      <span class="text-danger">{{ video_error }}</span>
                    </div>
                  </div>
                  <div class="col-md-8" />
                </div>
                <div class="row">
                  <div class="col-md-8 mt-2">
                    <div class="video_des">
                      <label for="videoDescription">Description:</label>
                      <input
                        id="videoDescription"
                        v-model="description"
                        v-validate="'required'"
                        name="description"
                        placeholder="say something about this video..."
                      >
                      <span class="text-danger">{{ formErrors('description') }}</span>
                    </div>
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
			video_link: '',
			description: '',
			video_error: '',
		};
	},
	mounted() {
		this.getUnitDetails();
	},
	methods: {
		getUnitDetails(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/unit-details').then((resp) => {
				this.unitData = resp.data.success.unitData;
				this.showLoader=false;
			});
		},
		addVideo(unit_id) {
			this.unit_id = unit_id;
			this.$modal.show('addVideoModal');
		},
		submitVideo() {
			this.$validator.validate().then(valid => {
				if(valid  && this.video_link && this.video_error===''){
					//call api and update field
					this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/add-video',{
						unit_id: this.unit_id,
						video_link: this.video_link,
						description: this.description,
					}).then(()=>{
						this.unit_id = '';
						this.video_link = '';
						this.description = '';
					});
				}
			});
		},
		embedvideo(event){
			this.video_error='';
			let url =event.target.value.trim();
			if(url===''){
				this.video_error='A video link is required.';
				return false;
			}
			let link = this.matchVideoUrl(url);
        
			if(link!==false){
				this.video_link=link;
				return true;
			}else{
				this.video_error='This video link is not supported';
				return false;
			}        
		},
		matchVideoUrl(link){
			let url = link.replace(/#[^#]*$/, '').replace(/\?[^\?]*$/, '');
			if(url.indexOf('.pdf')>-1){
				return url;
			}
			return false;
		}
	}
};

</script>
