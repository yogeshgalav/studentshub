<style scoped>
.col-md-8{
    margin-left: 17%;
}
.feedback{
    font-size: 40px;
    color: #929090;
}
</style>

<template>
  <main>
    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-100 p-2">
            <h1 class="feedback">Feedback</h1>
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="handleSubmit">
                <div class="form-group row">
                  <label
                    for="email"
                    class="col-md-4 col-form-label text-md-right"
                  >{{ "email" }}</label>
                  <div class="col-md-6">
                    <input
                      id="email"
                      v-model="email"
                      v-validate="'required|email'"
                      type="email"
                      class="form-control"
                      name="email"
                    >
                    <span class="text-danger">
                      {{ formErrors("email") }}</span>
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
                      {{ formErrors("feedback") }}</span>
                  </div>
                </div>
                <div class="form-group row mb-0">
                  <div class="col-md-8 offset-md-4">
                    <button
                      type="submit"
                      class="btn btn-primary btn-block"
                    >
                      {{ "Submit" }}
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <site-footer />
  </main>
</template>

<style scoped>
.mt-100 {
    margin-top: 200px;
}
</style>

<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import SiteFooter from "../footer/SiteFooter";
export default {
	mixins: [ FormMixin ],
    name: "feedback",
  components: {
    SiteFooter,
  },
	data() {
		return {
			email: "",
            feedback:'',
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.axios
						.post('/api/feedback', {
							email: this.email
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
