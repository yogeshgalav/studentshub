<template>
  <main>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="blank" />
    <div
      class="heading"
      style="background-image: url('/images/welcome/study-background.jpg');"
    >
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
          class="form-group"
        >
          <label
            for="email"
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
        <div class="form-group">
          <label
            for="feedback"
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
        <div class="form-group-button">
          <button
            type="submit"
            class="btn btn-primary"
          >
            {{ 'Submit' }}
          </button>
        </div>
      </form>
    </div>
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
import NoSidebarLayout from '@/Layouts/NoSidebarLayout.vue';

export default {
	mixins: [
		FormMixin
	],
	layout: NoSidebarLayout,
	data() {
		return {
			email:'',
			showLoader:false,
			feedback:'',
		};
	},
	methods: {
		handleSubmit() {
			this.validateForm().then(valid => {
				if (valid) {
					this.showLoader = true;
					console.log(this.showLoader);
					this.axios
						.post('/api/feedback', {
							email: this.email,
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
