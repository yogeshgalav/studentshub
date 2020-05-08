<template>
  <div>
    <loading 
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="container pb-100">
      <div class="login_card">
      <div class="row justify-content-center register">
        <div class="col-md-6">
                <div class="login_img">
                    <img src="/images/register.svg" alt="">
                </div>   
            </div>
        <div class="col-md-6">
          <div class="logn_right">
            <div class="card_title text-center">
              <h3 class="weight-800 text-black font-size-18">{{ trans('Register') }}</h3>
            </div>

            <div class="card_body">
                <div class="row justify-content-center">
            <div class="col-md-12">
                  <form @submit.prevent="handleSubmit">
                <div class="form-group">
                
                  <input
                    id="token"
                    type="hidden"
                    class="form-control"
                    name="_token"
                    :value="csrfToken"
                  />
                  <span class="error">{{ formErrors('_token') }}</span>
                </div>
                <div class="form-group">
                    <label> {{ trans('Full Name') }} </label>
                  <div class="inner-addon left-addon">
                     <div class="input_icon_frm">
                    <span class="icon_design_input"><i class="fa fa-user"></i></span>
                    <input
                      id="full_name"
                      type="text"
                      class="form-control"
                      name="full_name"
                      placeholder="Enter Full Name"
                      autofocus
                      v-validate="'required'"
                      v-model="full_name"
                    />
                     </div>
                    <span class="error">{{errors.first('full_name')}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="email"
                  >  {{ trans('E-Mail Address') }}</label>

                 <div class="inner-addon left-addon">
                    <div class="input_icon_frm">
                    <span class="icon_design_input"><i class="fa fa-envelope"></i></span>
                    <input
                      id="email"
                      type="email"
                      class="form-control"
                      name="email"
                      v-validate="'required|email'" 
                      placeholder="Email address"
                      v-model="email"
                    />
                    </div>
                    <span class="error">{{errors.first('email')}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="password"
                  > {{ trans('Password') }}</label>

                    <div class="inner-addon left-addon ">
                       <div class="input_icon_frm">
                      
                    <span class="icon_design_input"><i class="fa fa-lock"></i></span>
                    <input
                      id="password"
                      ref="password"
                      type="password"
                      class="form-control"
                      name="password"
                      v-validate="'required'" 
                      placeholder="Password"
                      v-model="password"
                    /></div>
                    <span class="error">{{errors.first('password')}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="password-confirm"
                  > {{ trans('Confirm Password') }}</label>

                   <div class="inner-addon left-addon">
                      <div class="input_icon_frm">
                    <span class="icon_design_input"><i class="fa fa-lock"></i></span>
                    <input
                      id="password-confirm"
                      type="password"
                      class="form-control"
                      name="password_confirmation"
                      v-validate="'required|confirmed:password'" placeholder="Confirm Password"
                    /></div>
                    <span class="error">{{errors.first('password_confirmation')}}</span>
                  </div>
                </div>

                <div class="form-group mb-0">
                    <div class="login_btn_part">
                 <button type="submit" class="login_btn">{{ trans('Register') }} <i class="fa fa-arrow-right text-white"></i></button>
                </div>
                </div>
              </form>
                </div>
                </div>
                </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.register .card {
  position: relative;
  top: 15%;
}
.register .btn {
  width: 100%;
  border-radius: 0;
}
/* enable absolute positioning */
.inner-addon {
  position: relative;
}
.register .form-control {
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
.left-addon .fa {
  left: 0px;
}
.right-addon .fa {
  right: 0px;
}

/* add padding  */
.left-addon input {
  padding-left: 35px;
}

.display-flex{
  display:flex;
}
</style>
<script>
import FormMixin from "../../components/mixins/form-mixin.js";
import swal from '../../components/swal';

export default {
  mixins: [FormMixin],
  data() {
    return {
      showLoader:false,
      full_name:'',
      email:'',
      password:'',
      dict: {
        custom: {
          full_name: {
            required: "You must provide your Full Name to continue."
          },
          email: {
            required: "You must provide your Email Address to continue.",
            email: "Seems like you have entered an incorrect Email."
          },
          password: {
            required: "You must create new Password to continue.",
          },
          password_confirmation: {
            required: "The confirm password field is required"
          }
        }
      }
    };
  },
  methods: {
    trans: function(string, defaultString) {
      return this.$trans("auth", string, defaultString);
    },
    handleSubmit(e) {
      this.$validator.localize("en", this.dict);
      this.$validator.validate().then(valid => {
        if (valid) {
          this.form_errors=[];
          this.showLoader=true;
          this.register();
        }
      });
      return true;
    },
    register: function () {
                let email = this.email;
                let password = this.password;
                let full_name = this.full_name;
                this.$store.dispatch('auth/register', { full_name, email, password})
                    .then((resp) => {
                      this.showLoader=false;
                        swal.successDialog('Register','Success!','success')
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
                        })
                    },
  },
};
</script>
