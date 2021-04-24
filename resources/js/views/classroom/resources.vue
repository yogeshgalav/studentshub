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
      <div
        v-if="!unit_list.length && AuthTeacher"
        class="card"
      >
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <p>
                {{ 'No unit created.This page will populate once unit setup is done. ' }}
                <router-link :to="'/classroom/'+$route.params.classroomId+'/setup'">
                  Click here to to create unit
                </router-link>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div
        v-else
        class="row"
      >
        <div class="col-md-6 mb-2">
          <select
            v-model="current_unit"
            class="form-control minimal"
            @change="getResources"
          >
            <option
              v-for="(unit,index) in unit_list"
              :key="index"
              :value="unit.id"
            >
              {{ 'Unit '+unit.unit_no+': '+unit.unit_name }}
            </option>
          </select>
        </div>
        <div class="col-md-6 ">
          <div
            v-if="AuthTeacher && AuthTeacher.id===classroomDetail.teacher_id"
          >
            <div class="text-right">
              <button
                class="btn-lg btn-primary"
                data-toggle="modal"
                data-target="#addResourceModal"
              >
                <i class="fas fa-plus" />&nbsp;&nbsp;Add Resource
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="mt-2">
            <div
              v-if="!resources.length"
              class="card"
            >
              <div class="card-body">
                <div class="col-md-12">
                  <p>
                    {{ 'Currently no resource has been added to this unit.' }}
                  </p>
                </div>
              </div>
            </div>
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
              <!-- <like-component
                :post="resource"
                likable-type="resource"
                :show-dislike="false"
              /> -->
            </div>
            <div class="col-md-3 col-12" />
          </div>
        </div>

        <modal
          ref="addResourceModal"
          name="addResourceModal"
          heading="Add Resource"
          @submit="saveResource()"
        >
          <template slot="modalBody">
            <form>
              <div class="row">
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
                  <div
                    v-if="resource_type==='documentLink' || resource_type==='youtubeVideo'" 
                    class="mt-1 forget_rember_pass"
                  >
                    <div class="rem_pass">
                      <input
                        id="shareAsPost"
                        v-model="share_as_post"
                        name="shareAsPost"
                        type="checkbox"
                      >
                      <label for="shareAsPost">
                        {{ 'Share as post' }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </template>
        </modal>
      </div>
    </div>
  </div>
</template>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import Modal from '../../components/VueNiceModal';
import LikeComponent from '../common/LikeComponent';
import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: {
		ClassroomHeader,
		Modal,
		LikeComponent,
	},
	mixins:[FormMixin],
	data() {
		return {
			showLoader:true,
			resources:[],
			unit_list: [],
			current_unit: '',
			resource_link: '',
			description: '',
			resource_error: '',
			resource_type: '',
			share_as_post: '',
		};
	},
	computed:{
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		}
	},
	mounted() {
		this.getResources();
	},
	methods: {
		getResources(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-resources?unitId='+this.current_unit)
				.then((resp) => {
					this.unit_list = resp.data.success.unit_list;
					this.current_unit = resp.data.success.current_unit;
					this.resources = resp.data.success.resources;
					this.showLoader=false;
				});
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
						share_as_post: this.share_as_post,
					}).then(()=>{
						this.resources.unshift({
							link:this.resource_link,
							type:this.resource_type,
							description:this.description,
						});
						this.$refs.addResourceModal.closeModal();
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
