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
        Frequently Asked Questions
      </h1>
    </div>

    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-100 p-2">
          <div class="form justify-content-center">
            <form
              class="col-md-12"
              @submit.prevent="handleSubmit"
            >
              <div
                v-if="!AuthUser"
                class="form-group row"
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
                  <span class="text-danger"> {{ formErrors("email") }}</span>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-12">
                  <label
                    for="query"
                    class="col-form-label text-md-right"
                  >
                    Query
                  </label>
                  <textarea
                    id="query"
                    v-model="query"
                    v-validate="'required'"
                    type="text"
                    rows="10"
                    class="form-control"
                    name="query"
                  />
                  <span class="text-danger"> {{ formErrors("query") }}</span>
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
            </form>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <strong>Q.</strong> How to access portal
              </h5>
              <p class="card-text">
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum."
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <strong>Q.</strong> how to reschdule class
              </h5>
              <p class="card-text">
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum."
              </p>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">
                <strong>Q.</strong> How to get access to course
              </h5>
              <p class="card-text">
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
                in reprehenderit in voluptate velit esse cillum dolore eu fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident,
                sunt in culpa qui officia deserunt mollit anim id est laborum."
              </p>
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
  margin-top: 150px;
}
strong {
  font-size: 20px;
}
.card {
  margin-top: 20px;
}
.heading{
  display: flex;
  align-items: center;
  justify-content: center;
}

</style>

<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import SiteFooter from '../footer/SiteFooter';
export default {
	name: 'Faq',
	components: {
		SiteFooter,
	},
	mixins: [FormMixin],
	props: ['faqs'],
	data() {
		return {
			email: '',
			query: '',
			showLoader: false,
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then((valid) => {
				if (valid) {
					this.showLoader = true;
					console.log(this.showLoader);
					this.axios
						.post('/api/faq', {
							email: this.AuthUser ? this.AuthUser.email : this.email,
							quer: this.query,
						})
						.then((resp) => {
							window.location.href = '/';
						})
						.catch((err) => {
							console.log(err);
						});
				}
			});
		},
	},
};
</script>
