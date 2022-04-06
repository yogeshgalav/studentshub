<template>
  <div>
    <div class="blank" />
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <header
      class="heading"
      style="background-image: url('/images/welcome/study-background.jpg');"
    >
      <h1 class="main_heading">
        Contact Us
      </h1>
      <h2 class="second_heading">
        We help Students, Teachers and Institutes to Find Pain Points
        and Boost Productivity.
      </h2>
    </header>
    <div
      class="flex"
      style="background: #fff"
    >
      <div class="col-6">
        <div class="mapouter">
          <div class="gmap_canvas">
            <iframe
              id="gmap_canvas"
              width="100%"
              height="500px"
              src="https://maps.google.com/maps?q=26.9024375%2075.78706249999999&t=&z=11&ie=UTF8&iwloc=&output=embed"
            /><a
              href="https://yt2.org/youtube-to-mp3-ALeKk00qEW0sxByTDSpzaRvl8WxdMAeMytQ1611842368056QMMlSYKLwAsWUsAfLipqwCA2ahUKEwiikKDe5L7uAhVFCuwKHUuFBoYQ8tMDegUAQCSAQCYAQCqAQdnd3Mtd2l6"
            /><br>
          </div>
        </div>
      </div>
      <div class="right col-lg-6">
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

    <main>
      <div class="form justify-content-center">
        <form
          class="col-md-6"
          @submit.prevent="handleSubmit"
        >
          <div>
            <div
              v-if="!AuthUser"
              class="form-group row"
            >
              <div class="col-md-12">
                <label
                  for="Name"
                  class="col-form-label text-md-right"
                >{{ "Name" }}</label>
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
              <div class="col-md-12">
                <label
                  for="email"
                  class="col-form-label text-md-right"
                >Email</label>
                <input
                  id="email"
                  v-model="email"
                  v-validate="'required|email'"
                  type="email"
                  class="form-control"
                  name="email"
                >
                <span class="error">{{
                  formErrors("email")
                }}</span>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <label
                  for="descrption"
                  class="col-form-label text-md-right"
                >Description</label>
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
              <div class="col-md-8">
                <button
                  type="submit"
                  class="btn btn-primary"
                >
                  {{ "Submit" }}
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-12">
        <div class="divider mt-5" />
      </div>
    </main>
  </div>
</template>
<style scoped>
.mt-100 {
    margin-top: 200px;
}
.right {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 500px;
    background: black;
    color: azure;
    font-size: 20px;
}
input {
    border-radius: 0%;
}
.form {
    max-width: 100%;
    margin: auto;
    display: flex;
    margin-bottom: -48px;
    background: #f6f6f6;
    padding: 50px 0;
}
.flex{
    display: flex;
    margin-left: -14px;
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
    min-width: 103%;
    max-block-size: 105%;
}
.gmap_canvas {
    overflow: hidden;
    background: none !important;
    height: 500px;
    width: 100%;
}
@media (max-width: 800px) {
    .flex {
        display: flex;
        flex-direction: column;
    }
    .col-6 {
        -webkit-box-flex: 0;
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>
<script>
import FormMixin from '@/components/mixins/form-mixin.js';
import NoSidebarLayout from '@/Layouts/NoSidebarLayout.vue';

export default {
	name: 'Contactus',
	layout: NoSidebarLayout,
	mixins: [FormMixin],
	data() {
		return {
			name: '',
			email: '',
			description: '',
			showLoader: false
		};
	},
	methods: {
		handleSubmit() {
			this.validateForm().then(valid => {
				if (valid) {
					this.axios
						.post('/api/contactus', {
							name: this.AuthUser
								? this.AuthUser.full_name
								: this.name,
							email: this.AuthUser
								? this.AuthUser.email
								: this.email,
							description: this.description
						})
						.then(resp => {
							window.location.href = '/';
						})
						.catch(err => {});
				}
			});
		}
	}
};
</script>
