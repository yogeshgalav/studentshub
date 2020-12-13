<template>
  <div class="container">
    <loading 
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="login_card">
      <div class="row  login">
        <div class="col-md-6">
          <div class="login_img">
            <img
              src="/images/Group.svg"
              alt=""
            >
          </div>   
        </div>
        <div class="col-md-6 ">
          <div class="logn_right">
            <div class="card_title">
              <h3>{{ trans('Login') }}</h3>
            </div>
            <div class="card_body">
              <form @submit.prevent="handleSubmit">
                <div
                  v-if="srvError401"
                  class="form-group row alert alert-danger"
                >
                  <span>{{ trans('Invalid login credentials. Please try again.') }}</span>
                </div>
                <div
                  v-if="srvErrorUnknown"
                  class="form-group row alert alert-danger"
                >
                  <span>{{ trans('An unknown error has occurred.') }}</span>
                </div>
                <div class="form-group row">
                  <input
                    id="token"
                    type="hidden"
                    class="form-control"
                    name="_token"
                    :value="csrfToken"
                  >
                  <span class="error">{{ formErrors('_token') }}</span>
                </div>
                <div class="form-group">
                  <label for="email"> {{ trans('E-Mail Address') }}</label>
                  <div class="inner-addon left-addon">
                    <div class="input_icon_frm">
                      <span class="icon_design_input"><i class="fa fa-user" /></span>
                      <input
                        id="email"
                        v-model.lazy="email"
                        v-validate="'required|email'"
                        type="text"
                        name="email"
                        autofocus
                        class="form-control"
                        placeholder="Username or email"
                      >
                    </div>
                    <span class="error">{{ formErrors('email') }}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="password"> {{ trans('Password') }}</label>
                  <div class="inner-addon left-addon">
                    <div class="input_icon_frm">
                      <span class="icon_design_input"><i class="fa fa-lock" /></span>
                      <input
                        id="password"
                        v-model="password"
                        v-validate="'required'"
                        type="password"
                        class="form-control"
                        name="password"
                        placeholder="Password"
                      >
                    </div>
                    <span class="error">{{ formErrors('password') }}</span>
                  </div>
                  <div class="mt-1 forget_rember_pass">
                    <div class="rem_pass">
                      <input
                        id="remember"
                        v-model="remember"
                        type="checkbox"
                        name="remember"
                      >
                      <label for="remember">
                        {{ trans('Remember Me') }}
                      </label>
                    </div>
                    <div class="forget_pass">
                      <router-link :to="'/forgot-password'">
                        {{ trans('Forgot Your Password') }} 
                      </router-link>    
                    </div>   
                  </div>
                </div>

                <div class="form-group  mb-0">
                  <div class="login_btn_part">
                    <button
                      type="submit"
                      class="login_btn"
                    >
                      {{ trans('Login') }} <i class="fa fa-arrow-right text-white" />
                    </button>
                  </div>
                </div>
                <!-- <div class=" form-group social_btn">
                  <p class="text-center mb-1 mt-1">
                    OR
                  </p>
                  <p class="text-center">
                    Sign up with your social network
                  </p>
                  <div class="social_login d-flex">
                    <a
                      class="btn btn-white mr-3"
                      href="/social-auth/google"
                    ><i><img src="/icons/search.png"></i> Sign up with Google</a>
                    <a
                      class="btn btn-white mr-3"
                      href="/social-auth/facebook"
                    ><i><img src="/icons/facebook.png"></i> Sign up with Facebook</a>
                  </div>
                </div> -->
                            
                <div class="text-center center-col pt-2">
                  <span
                    class="text-gray"
                    style="color:#868686;"
                  >Dont't have an account?</span> <router-link :to="'/get-started'">
                    Sign Up
                  </router-link>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="login_card">
      <div class="row">
        <div class="col-md-12">
          <router-link
            :to="'/membership-plan'"
            class="font-size-40 text-black weight-800 mb-2 line-height-25-px text-center"
          >
            {{ trans('New Institute or Teacher?') }} 
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
 
    /* enable absolute positioning */

.inner-addon {
  position: relative;
}
.login .form-control
{

    height: 48px !important;
    color: #000;
    border-radius: 0;
}
/* style glyph */
.inner-addon .fa {
  position: absolute;
  padding: 18px;
  pointer-events: none;
}

/* align glyph */
.left-addon .fa  { left:  0px;}
.right-addon .fa { right: 0px;}

/* add padding  */
/* .left-addon input  { padding-left:  35px; } */

</style>
<script>
import { mapState } from 'vuex';
import FormMixin from '../../components/mixins/form-mixin.js' ;
import swal from '../../components/swal';

export default {
	mixins: [FormMixin],
	data(){
		return{
			showLoader:false,
			email:'',
			password:'',
			remember:false,
			srvError401:'',
			srvErrorUnknown:'',
		};
	},
	mounted(){
		var self=this;
		this.$validator.localize('en', {custom: {
			email: {
				required: self.trans('emailOrPhone.invalid','You must provide a valid email address or phone number.')
			}}});
		this.$validator.extend('email', {
			getMessage() {
				return self.trans('emailOrPhone.invalid','You must provide a valid email address or phone number.');
			},
			validate: function(value) {
				const email = /\S+@\S+\.\S+/;
				const phone = /^\+?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
				return !!(value.match(email) || value.match(phone));
			}
		});
	},
	methods:{
		trans: function (string,defaultString) {
			return this.$trans('auth',string,defaultString);
		},
		handleSubmit: function (e) {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.form_errors=[];
					this.showLoader=true;
					this.login();
				}
			});
			return true;
		},
		login: function () {
			let email = this.email;
			let password = this.password;
			let remember = this.remember;
			this.$store.dispatch('auth/login', { email, password, remember})
				.then((resp) => {
					this.showLoader=false;
					swal.successDialog('Login','Success!','success')
					({redirectUrl: window.location.href} = resp.data.success);
				})
				.catch(err => {
					this.showLoader=false;
					if( 401 === err.response.status){
						this.srvError401=true;
						this.srvErrorUnknown=false;
						this.form_errors=[];
					} else {
						this.srvErrorUnknown=true;
						this.srvError401 = false;
						this.form_errors=err.response.data.errors;
					}
				});
		},
	}
};
</script>

