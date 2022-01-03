<template>
  <main>
    <div class="col-md-12">
      <div class="row justify-content-center">
        <div class="col-md-6 mt-100 p-2">
          <div class="card">
            <div class="card-header">
              {{ "Reset Password" }}
            </div>

            <div class="card-body">
              <form @submit.prevent="handleSubmit">
                <div class="form-group row">
                  <label
                    for="password"
                    class="col-md-4 col-form-label text-md-right"
                  >{{ "Password" }}</label>

                  <div class="col-md-6">
                    <input
                      id="password"
                      ref="password"
                      v-model="password"
                      v-validate="'required|min:6'"
                      :type="showPassword ? 'text' : 'password'"
                      class="form-control"
                      name="password"
                      autocomplete
                    >
                    <div
                      class="input-group-append"
                      @click="showPassword = !showPassword"
                    >
                      <span
                        v-show="showPassword"
                        class="input-group-text"
                      ><i
                                                         
                        class="fa fa-eye-slash"
                        aria-hidden="true"
                      />
                      </span>
                      <span
                        v-show="!showPassword"
                        class="input-group-text"
                      >
                        <i                     
                          class="fa fa-eye"
                          aria-hidden="true"
                        />
                      </span>
                    </div>
                    <span class="error">{{
                      errors.first("password")
                    }}</span>
                  </div>
                </div>
                <div class="form-group row">
                  <label
                    for="confirm-password"
                    class="col-md-4 col-form-label text-md-right"
                  >Confirm Password</label>

                  <div class="col-md-6">
                    <input
                      id="confirm-password"
                      v-model="confirm_password"
                      v-validate="
                        'required|confirmed:password'
                      "
                      :type="showConfirmPassword ? 'text' : 'password'"
                      class="form-control"
                      name="confirm-password"
                    >
                    <div
                      class="input-group-append"
                      @click="showConfirmPassword = !showConfirmPassword"
                    >
                      <span
                        v-show="showConfirmPassword"
                        class="input-group-text"
                      ><i
                                                         
                        class="fa fa-eye-slash"
                        aria-hidden="true"
                      />
                      </span>
                      <span
                        v-show="!showConfirmPassword"
                        class="input-group-text"
                      >
                        <i                     
                          class="fa fa-eye"
                          aria-hidden="true"
                        />
                      </span>
                    </div>
                    <span class="error">{{
                      errors.first("confirm-password")
                    }}</span>
                  </div>
                </div>
                <div class="form-group row mb-0">
                  <div class="col-md-8 offset-md-4">
                    <button
                      type="submit"
                      class="btn btn-primary"
                    >
                      {{ "Reset Password" }}
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
/*adding style to eye icon */
.col-md-6 .input-group-append{
  cursor: pointer;
  display: inline-block;
}
/*.col-md-6{
  position: relative;
}
span{
  height: 100%;
}
.col-md-6 .input-group-append{
  cursor: pointer;
  position: absolute;
  height: 80%;
  right: 19.5%;
  top:3%;
  display: inline-block;
}
input{
  width: 70%;
}*/

</style>
<script>
import Vue from 'vue';
import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);
export default {
	components: {
		VeeValidate
	},
	props: ['token'],
	data() {
		return {
			showConfirmPassword: false,
			showPassword: false,
			password: '',
			confirm_password: ''
		};
	},
	methods: {
		handleSubmit() {
			this.$validator.validate().then(valid => {
				if (valid) {
					let api_path = '/api/reset-password';
					api_path = this.token
						? api_path + '/' + this.token
						: api_path;
					this.axios
						.post(api_path, {
							password: this.password,
							confirm_password: this.confirm_password
						})
						.then(resp => {
							window.location.href = this.token ? '/' : '/login';
						})
						.catch(err => {});
				}
			});
		}
	}
};
</script>
