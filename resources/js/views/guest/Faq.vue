<template>
  <main>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="space" />
    <h3>Frequently Asked Questions</h3>

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
                    <span class="text-danger">
                      {{ formErrors("email") }}</span>
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="query"
                    class="col-md-4 col-form-label text-md-right"
                  >
                    Query
                  </label>

                  <div class="col-md-6">
                    <textarea
                      id="query"
                      v-model="query"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      name="query"
                    />
                    <span class="text-danger">
                      {{ formErrors("query") }}</span>
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
.query {
  background: whitesmoke;
  height: 200px;
  padding: 30px;
}
h3 {
  font-size: 24px;
  margin-bottom: -142px;
  margin-top: 4%;
  text-align: center;
}
.query div{
    margin: 10px;
}
.space {
  min-height: 60px;
}
.position {
  position: relative;
}
input {
  width: 100%;
  outline: none;
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
	props:['faqs'],
	data() {
		return {
			email: '',
			query: '',
			showLoader:false,
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.showLoader = true;
					console.log(this.showLoader);
					this.axios
						.post('/api/faq', {
							email: (this.AuthUser ? this.AuthUser.email : this.email),
							query : this.query,
						})
						.then(resp => {
							window.location.href = '/';
						})
						.catch(err => {
							console.log(err);
						});
				}
			});
		}
	},
};
</script>
