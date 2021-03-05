<template>
  <main>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="blank" />
    <div class="heading">
      <h1 class="main_heading">
        Feedback
      </h1>
      <h2 class="second_heading">
        Your feedback is valuable for us, hence we would love to listen what you think about us.
      </h2>
    </div>
    <div class="form justify-content-center">
      <form
        class=" col-md-6"
        @submit.prevent="handleSubmit"
      >
        <div
          v-if="!AuthUser"
          class="form-group row col-md-12"
        >
          <div class="col-md-12">
            <label
              for="email"
              class="col-form-label text-md-right"
            >{{ "Email" }}</label>
            <input
              id="email"
              v-model="email"
              v-validate="'required|email'"
              type="email"
              class="form-control"
              name="email"
            >
            <span class="error">{{ formErrors('email') }}</span>
          </div>
        </div>
        <div class="form-group row col-md-12">
          <div class="col-md-12">
            <label
              for="feedback"
              class="col-form-label text-md-right"
            >
              Please enter your feedback
            </label>
            <textarea
              id="feedback"
              v-model="feedback"
              v-validate="'required'"
              type="text"
              class="form-control"
              name="feedback"
              rows="10"
            />
            <span class="text-danger">
              {{ formErrors('feedback') }}</span>
          </div>
        </div>
        <div class="form-group row mb-0 col-md-12">
          <div class="col-md-12">
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
    <site-footer />
  </main>
</template>

<style scoped>
.mt-100 {
    margin-top: 200px;
}
input{
    border-radius: 0;
}
</style>

<script>
import FormMixin from '../../components/mixins/form-mixin';
import SiteFooter from '../footer/SiteFooter';
export default {
	components: {
		SiteFooter,
	},
	mixins: [
		FormMixin
	],
	data() {
		return {
			email:'',
			showLoader:false,
			feedback:'',
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.showLoader = true;
					console.log(this.showLoader);
					this.axios
						.post('/api/feedback', {
							email: (this.AuthUser ? this.AuthUser.email : this.email),
							feedback : this.feedback,
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
