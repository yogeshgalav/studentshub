<template>
  <section>
    <modal
      id="addEditInstituteModal"
      key="addEditInstituteModal"
      ref="addEditInstituteModal"
      name="addEditInstituteModal"
      class="model-md"
      heading="Profile Info"
      @submit="submitModal()"
    >
      <template slot="modalBody">
        <form validationScope="add_institute_form">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="moto">Moto</label>
                <input
                  id="state"
                  v-model="edit_institute.moto"
                  name="moto"
                  class="form-control"
                  placeholder="write moto here"
                >
                <label for="website">Website</label>
                <input
                  id="website"
                  v-model="edit_institute.website"
                  name="website"
                  class="form-control"
                  placeholder="http://website.com"
                >
                <label for="address">Address</label>
                <input
                  id="address"
                  v-model="edit_institute.address"
                  name="address"
                  class="form-control"
                  placeholder="write Address here"
                >
                <label for="city">City</label>
                <input
                  id="city"
                  v-model="edit_institute.city"
                  name="city"
                  class="form-control"
                  placeholder="write City here"
                >
                <label for="state">State</label>
                <input
                  id="state"
                  v-model="edit_institute.state"
                  name="state"
                  class="form-control"
                  placeholder="write State here"
                >
                <label for="latitude">Latitude</label>
                <input
                  id="latitude"
                  v-model="edit_institute.latitude"
                  name="latitude"
                  class="form-control"
                  placeholder="write latitude here"
                >
                <label for="longitude">Longitude</label>
                <input
                  id="longitude"
                  v-model="edit_institute.longitude"
                  name="longitude"
                  class="form-control"
                  placeholder="write longitude here"
                >
                <label for="fb_url"> Facebook Profile Url</label>
                <input
                  v-model="edit_institute.fb_url"
                  class="form-control"
                  type="text"
                  placeholder="http://facebook.com/profile-id"
                >
                <span class="text-danger">{{ errors.fb_url }}</span>
                <label>Twitter Url</label>
                <input
                  v-model="edit_institute.twitter_url"
                  class="form-control"
                  type="text"
                  placeholder="http://twitter.com/profile-id"
                >
                <span class="text-danger">{{ errors.twitter_url }}</span>
                <label>Instagram Username</label>
                <input
                  v-model="edit_institute.insta_url"
                  class="form-control"
                  type="text"
                  placeholder="http://instagram.com/profile-id"
                >
                <span class="text-danger">{{ errors.insta_url }}</span>
                <label>Linkedin Profile Url</label>
                <input
                  v-model="edit_institute.linkedin_url"
                  class="form-control"
                  type="text"
                  placeholder="http://linked.com/profile-id"
                >
                <span class="text-danger">{{ errors.linkedin_url }}</span>
                <label>Youtube Vedio Url</label>
                <input
                  v-model="edit_institute.youtube_vedio_url"
                  class="form-control"
                  type="text"
                  placeholder="http://youtube.com/profile-id"
                >
                <span class="text-danger">{{ errors.youtube_vedio_url }}</span>
              </div>
            </div>
          </div>
        </form>
      </template>
    </modal>
  </section>
</template>
<script>
import Modal from '@/components/VueNiceModal.vue';

export default {
	components: {
		Modal,
	},
	props:['value'],
	emits:['input'],
	data(){
		return {
			edit_institute:this.value,
			errors: {
				fb_url: '',
				twitter_url: '',
				insta_url: '',
				linkedin_url: '',
				youtube_vedio_url: '',
			},
		};
	},
	watch:{
		value(val){
			this.edit_institute = val;
		}
	},
	methods:{
		submitModal() {      
			if (
				this.institute.fb_url &&
                !this.institute.fb_url.includes('facebook.com')
			) {
				this.errors.fb_url = 'This is not valid Facebook url.';
				return false;
			}
			if (
				this.institute.twitter_url &&
			          !this.institute.twitter_url.includes('twitter.com')
			) {
				this.errors.twitter_url = 'This is not valid Twitter url.';
				return false;
			}
			if (
				this.institute.insta_url &&
			          !this.institute.insta_url.match(/^[a-zA-Z0-9_.]*$/g)
			) {
				this.errors.insta_url = 'This is not valid Instagram username.';
				return false;
			}
			if (
				this.institute.linkedin_url &&
                !this.institute.linkedin_url.includes('linkedin.com')
			) {
				this.errors.linkedin_url = 'This is not valid Linkedin url.';
				return false;
			}
			if (
				this.institute.youtube_vedio_url &&
			          !this.institute.youtube_vedio_url.includes('youtube.com')
			) {
				this.errors.youtube_vedio_url = 'This is not valid Youtube url.';
				return false;
			}

			this.$emit('input',this.edit_institute);

			this.axios
				.post('/api/add-update-institute',this.edit_institute)
				.then((resp) => {
					
				});
		
			this.errors = {
				fb_url: '',
				twitter_url: '',
				insta_url: '',
				linkedin_url: '',
				youtube_vedio_url: '',
			};
		},
	}
};
</script>