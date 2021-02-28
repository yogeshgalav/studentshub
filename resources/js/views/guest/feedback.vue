<template>
  <main>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-100 p-2">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="handleSubmit">
                <div
                  v-if="!AuthUser"
                  class="form-group row"
                >
                  <label
                    for="email"
                    class="col-md-4 col-form-label text-md-right"
                  >{{ "Email" }}</label>
                  <div class="col-md-6">
                    <input
                      id="email"
                      v-model="email"
                      v-validate="'required|email'"
                      type="email"
                      class="form-control"
                      name="email"
                    >
                    <span class="text-danger">{{ formErrors('email') }}</span>
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="feedback"
                    class="col-md-4 col-form-label text-md-right"
                  >
                    Please enter your feedback
                  </label>

                  <div class="col-md-6">
                    <textarea
                      id="feedback"
                      v-model="feedback"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      name="feedback"
                    />
                    <span class="text-danger">
                      {{ formErrors('feedback') }}</span>
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
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
.mt-100 {
    margin-top: 200px;
}
</style>

<script>
import FormMixin from '../../components/mixins/form-mixin.js';
export default {
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
