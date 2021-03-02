

<template>
  <main>
      <div class="blank">
      </div>
      <div class="heading">
          <h1>
              Your feedback is valuable for us, hence we would love to listen what you think about us.
          </h1>
      </div>
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
                <div>
                  <div>
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
.col-md-8{
    margin-left: 17%;
}
.feedback{
    font-size: 40px;
    color: #929090;
}
.blank{
    height: 100px;
}
.heading h1{
    font-size: 40px;
    color: white;
    font-weight: 700;
    width: 80%;
    margin: auto;
}
.heading{
    min-height: 500px;
    background: black;
    text-align: center;
    padding-top: 100px;
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
