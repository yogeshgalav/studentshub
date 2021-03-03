
<template>
  <div>
    <div class="blank" />
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <header class="heading">
      <h1 class="main_heading">
        Contact Us
      </h1>
      <h2 class="second_heading">
        We help Students, Teachers and Institutes to Find Pain Points and Boost
        Productivity.
      </h2>
    </header>
    <div class="">
      <div
        class="row"
        style="background: black"
      >
        <div class="col-6">
          <div class="mapouter">
            <div class="gmap_canvas">
              <iframe
                id="gmap_canvas"
                width="100%"
                height="500"
                src="https://maps.google.com/maps?q=26.9024375%2075.78706249999999&t=&z=11&ie=UTF8&iwloc=&output=embed"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
              /><a
                href="https://yt2.org/youtube-to-mp3-ALeKk00qEW0sxByTDSpzaRvl8WxdMAeMytQ1611842368056QMMlSYKLwAsWUsAfLipqwCA2ahUKEwiikKDe5L7uAhVFCuwKHUuFBoYQ8tMDegUAQCSAQCYAQCqAQdnd3Mtd2l6"
              /><br>
            </div>
          </div>
        </div>
        <div class="col right">
          <p>
            1, Patel Nagar<br>
            22 Godam, Hawa Sadak,<br>
            Jaipur, Rajasthan, 302006
          </p>
          <p>
            Mobile: +91 8003345821<br>
            Email: info@studentshub.in
          </p>
        </div>
      </div>
    </div>

    <main>
      <div class="form">
        <form @submit.prevent="handleSubmit">
          <div
            v-if="!AuthUser"
            class="form-group row"
          >
            <label
              for="Name"
              class="col-md-4 col-form-label text-md-right"
            >{{ "Name" }}</label>
            <div class="col-md-6">
              <input
                id="name"
                ref="name"
                v-model="name"
                v-validate="'required|max:255'"
                type="name"
                class="form-control"
                name="name"
              >
            </div>
          </div>
          <div
            v-if="!AuthUser"
            class="form-group row"
          >
            <label
              for="email"
              class="col-md-4 col-form-label text-md-right"
            >Email</label>
            <div class="col-md-6">
              <input
                id="email"
                v-model="email"
                v-validate="'required|email'"
                type="email"
                class="form-control"
                name="email"
              >
              <span class="error">{{ formErrors("email") }}</span>
            </div>
          </div>
          <div class="form-group row">
            <label
              for="descrption"
              class="col-md-4 col-form-label text-md-right"
            >Description</label>
            <div class="col-md-6">
              <textarea
                id="discription"
                v-model="description"
                type="description"
                class="form-control"
                name="description"
                rows="8"
                cols="80"
              />
            </div>
          </div>
          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button
                type="submit"
                class="btn btn-primary"
              >
                {{ 'Submit' }}
              </button>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-12">
        <div class="divider mt-5" />
      </div>
      <site-footer />
    </main>
  </div>
</template>
<style scoped>
.mt-100 {
  margin-top: 200px;
}
.right {
  text-align: left;
  height: 500px;
  background: black;
  color: azure;
  padding-left: 2%;
  padding: 12% 0 2% 5%;
  font-size: 20px;
}

input {
  border-radius: 0%;
}
.input_field{
    margin: 20px 0 20px 0;
}
.field input{
    font-size: 20px;
}
hr {
  color: black;
  height: 10px;
  margin-top: -2px;
  background: royalblue;
  margin-bottom: auto;
}
.mapouter {
  position: relative;
  text-align: right;
  height: 500px;
  width: 100%;
}
.gmap_canvas {
  overflow: hidden;
  background: none !important;
  height: 500px;
  width: 100%;
}

.heading .main_heading {
  font-size: 60px;
  margin-bottom: 20px;
}



</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import SiteFooter from '../footer/SiteFooter';
export default {
	name: 'Contactus',
	components: {
		SiteFooter,
	},
	mixins: [FormMixin],
	data() {
		return {
			name: '',
			email: '',
			description: '',
			showLoader:false,
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then((valid) => {
				if (valid) {
					this.axios
						.post('/api/contactus', {
							name: (this.AuthUser ? this.AuthUser.full_name : this.name),
							email:(this.AuthUser ? this.AuthUser.email : this.email),
							description: this.description,
						})
						.then((resp) => {
							window.location.href = '/';
						})
						.catch((err) => {});
				}
			});
		},
	},
};
</script>
