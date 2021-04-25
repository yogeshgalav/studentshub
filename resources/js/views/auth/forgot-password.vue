<template>
  <div class="container">
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="login_card">
      <div class="row justify-content-center align-items-center login">
        <div class="col-md-6">
          <div class="login_img">
            <img
              src="/images/Forgot-pass.svg"
              alt=""
            >
          </div>
        </div>
        <div class="col-md-6 ">
          <div class="logn_right">
            <div class="card_title text-center">
              <h3 class="weight-800 text-black font-size-18">
                {{ trans('Forgot Password') }}
              </h3>
            </div>
            <div class="card-body">
              <form @submit.prevent="handleSubmit">
                <div
                  v-if="srvError"
                  class="form-group row alert alert-danger"
                >
                  <span>{{ trans('An unknown error has occurred.') }}</span>
                </div>
                <div class="form-group">
                  <label
                    for="email"
                    class="text-md-right"
                  > {{ trans('E-Mail Address') }}</label>

                  <div class="inner-addon left-addon">
                    <div class="input_icon_frm">
                      <span class="icon_design_input"><i class="fa fa-envelope" /></span>
                      <input
                        id="email"
                        v-model="email"
                        v-validate="'required|email'"
                        type="email"
                        placeholder="Email address"
                        class="form-control"
                        name="email"
                        autofocus
                      >
                    </div>
                    <span class="error">{{ formErrors('email') }}</span>
                  </div>
                </div>
                <div class="form-group  mb-0">
                  <div>
                    <button
                      type="submit"
                      class="btn-primary btn-lg m-0-a"
                    >
                      Submit&nbsp;<i class="fa fa-arrow-right text-white" />
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
    .forgot-password .card
    {
        position: relative;
        top: 50%;
    }
    .login .form-control
{

    height: 48px !important;
    color: #000;
    border-radius: 0;
}
</style>
<script>
import swal from '../../components/swal';
import FormMixin from '../../components/mixins/form-mixin.js' ;

export default {
	mixins: [FormMixin],
	data(){
		return{
			showLoader:false,
			email:'',
			confirm_text:'',
			srvError: '',
		};
	},
	mounted(){
		let self=this;
		this.$validator.localize('en', {custom: {
			email: {
				required: self.trans('emailOrPhone.invalid','You must provide a valid email address or phone number.')
			}}});
		this.$validator.extend('email', {
			getMessage(field, args) {
				return self.trans('emailOrPhone.invalid','You must provide a valid email address or phone number.');
			},
			validate: function(value, args){
				var email = /\S+@\S+\.\S+/;
				var phoneno = /^\+?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
				if(value.match(email)){
					self.confirm_text=self.trans('forgotPassword.confirmEmail','Please check your email. If an account with the specified email address exists, you will be sent a link to reset your password.');
					return true;
				}else if(value.match(phoneno)){
					self.confirm_text=self.trans('forgotPassword.confirmPhone','Please check your phone. If an account with the specified phone number exists, you will be sent a link to reset your password.');
					return true;
				}
				return false;
			}
		});
	},
	methods:{
		trans: function (string,defaultString) {
			return this.$trans('auth',string,defaultString);
		},
		handleSubmit: function () {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.submitEmail();
				}
			});
		},
		submitEmail: function () {
			this.showLoader =true;
			this.axios.post('/api/forgot-password',{email:this.email})
				.then(()=>{
					this.showLoader =false;
					swal.infoDialog(this.confirm_text);
				}).catch(()=>{
					this.srvError = true;
				});
		}
	}
};
</script>
