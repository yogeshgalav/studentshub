<template>
  <div>
    <div class="container pb-100">
      <div class="row justify-content-center register">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center">
              <h3 class="weight-800 text-black font-size-18">{{ trans('Register') }}</h3>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
            <div class="col-md-8">
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
                    <i class="fa fa-user"></i>
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
                    <span class="error">{{errors.first('full_name')}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="email"
                  >{{ trans('E-Mail Address') }}</label>

                 <div class="inner-addon left-addon">
                    <i class="fa fa-envelope"></i>
                    <input
                      id="email"
                      type="email"
                      class="form-control"
                      name="email"
                      v-validate="'required|email'" 
                      placeholder="Email address"
                      v-model="email"
                    />
                    <span class="error">{{errors.first('email')}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="password"
                  >{{ trans('Password') }}</label>

                    <div class="inner-addon left-addon">
                    <i class="fa fa-lock"></i>
                    <input
                      id="password"
                      ref="password"
                      type="password"
                      class="form-control"
                      name="password"
                      v-validate="'required'" 
                      placeholder="Password"
                      v-model="password"
                    />
                    <span class="error">{{errors.first('password')}}</span>
                  </div>
                </div>

                <div class="form-group">
                  <label
                    for="password-confirm"
                  >{{ trans('Confirm Password') }}</label>

                   <div class="inner-addon left-addon">
                    <i class="fa fa-lock"></i>
                    <input
                      id="password-confirm"
                      type="password"
                      class="form-control"
                      name="password_confirmation"
                      v-validate="'required|confirmed:password'" placeholder="Confirm Password"
                    />
                    <span class="error">{{errors.first('password_confirmation')}}</span>
                  </div>
                </div>

                <div class="form-group mb-0">
                 <button type="submit" class="btn btn-primary">{{ trans('Register') }}</button>
                </div>
              </form>
              <form>
                <p class="text-center">OR</p>
                <p class="text-center">Sign up with your social network</p>
                <div class="display-flex">
                  <button class="btn btn-white mr-3" @click="AuthProvider('google')"><i><img src="/icons/search.png" /></i> Sign up with Google</button>
                <button class="btn btn-white"  @click="AuthProvider('facebook')"><i><img src="/icons/facebook.png" /></i> Sign up with Facebook</button>
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
  background: #eee;
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
import FormMixin from "../../../components/mixins/form-mixin.js";

export default {
  mixins: [FormMixin],
  data() {
    return {
      register_status:1,
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
          this.register();
        }
      });
      return true;
    },
    register: function () {
                this.register_status=0;
                let email = this.email;
                let password = this.password;
                let full_name = this.full_name;
                this.$store.dispatch('auth/register', { full_name, email, password})
                    .then((resp) => {
                        ({redirectUrl: window.location.href} = resp.data.success);
                    })
                        .catch(err => {
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
            
    AuthProvider(provider) {
      var self = this;

      this.$auth
        .authenticate(provider)
        .then(response => {
          self.SocialLogin(provider, response);
        })
        .catch(err => {
          console.log({
            err: err
          });
        });
    },

    SocialLogin(provider, response) {
      this.$http
        .post("/sociallogin/" + provider, response)
        .then(response => {
          console.log(response.data);
        })
        .catch(err => {
          console.log({
            err: err
          });
        });
    }
  },
  props: {}
};
</script>
