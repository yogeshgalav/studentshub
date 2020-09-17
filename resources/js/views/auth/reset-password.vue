<template>
  <main>
    <div class="col-md-12">
      <div class="row justify-content-center">
      <div class="col-md-6 mt-100 p-2">
        <div class="card">
          <div class="card-header">
            {{ 'Reset Password' }}
          </div>

          <div class="card-body">
            <form @submit.prevent="submitPassword">
              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                >{{ 'Password' }}</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    v-model="password"
                    v-validate="'required'"
                    type="password"
                    class="form-control"
                    name="password"
                    autocomplete
                  >
                  <span>{{ errors.first('password') }}</span>
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
                    v-validate="'required'"
                    type="password"
                    class="form-control"
                    name="confirm-password"
                  >
                  <span>{{ errors.first('confirm-password') }}</span>
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button
                    type="submit"
                    class="btn btn-primary"
                  >
                    {{ 'Reset Password' }}
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
import Vue from 'vue';
import VeeValidate  from 'vee-validate';

Vue.use(VeeValidate);

export default {
	components:{
		VeeValidate
	},
	props:['token'],
	data(){
		return{
			password:'',
			confirm_password:'',
		};
	},
	methods:{
		handleSubmit(){
			this.$validator.validate().then(valid => {
				if (valid) {
					this.submitPassword();
				}
			});
		},
		submitPassword(){
			let api_path= '/api/reset-password';
			api_path = this.token ? (api_path+'/'+this.token) : api_path;
			this.axios.post(api_path,{
				password:this.password,
				confirm_password:this.confirm_password
			}).then((resp)=>{
				window.location.href = this.AuthUser ? '/' : '/login';
			}).catch((err)=>{

			});
		}
	} 
};
</script>
