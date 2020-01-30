<template>
    <div class="container">
        <div class="row justify-content-center login">
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="weight-800 text-black font-size-18">{{ trans('Login') }}</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group row alert alert-danger" v-if="srvError401">
                                <span>{{ trans('Invalid login credentials. Please try again.') }}</span>
                            </div>
                            <div class="form-group row alert alert-danger" v-if="srvErrorUnknown">
                                <span>{{ trans('An unknown error has occurred.') }}</span>
                            </div>
                            <div class="form-group row">

                                    <input id="token" type="hidden" class="form-control" name="_token" :value="csrfToken">
                                    <span class="error">{{ formErrors('_token') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="email">{{ trans('E-Mail Address') }}</label>
                                <div class="inner-addon left-addon">
      <i class="fa fa-user"></i>      
      <input type="text" id="email"  name="email" v-model.lazy="email" autofocus v-validate="'required|email'" class="form-control" placeholder="Username or email" />
    <span class="error">{{ formErrors('email') }}</span>
    </div>
 </div>

                            <div class="form-group">
                                  <label for="password">{{ trans('Password') }}</label>
                                  <div class="inner-addon left-addon">
      <i class="fa fa-lock"></i>     
                                    <input id="password" type="password" class="form-control" name="password" v-model="password" v-validate="'required'" placeholder="Password">
                                    <span class="error">{{ formErrors('password') }}</span>
                                    </div>
                                    <div class="mt-1">
                                        <input type="checkbox" name="remember" id="remember" v-model="remember" />
                                        <label for="remember">
                                            {{ trans('Remember Me') }}
                                        </label>
                                    </div>
                            </div>

                        

                            <div class="form-group row mb-0">
                                <div class="col-md-8 center-col">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('Login') }} <i class="fa fa-arrow-right text-white" v-if="login_status"></i>
                                    </button>

                                    <div class="text-center center-col pt-2">
                                        <router-link  :to="'/forgot-password'">
                                        {{ trans('Forgot Your Password') }} 
                                    </router-link>     | <span class="text-black">Not a member? </span> <a href="#">Sign Up</a> 
                                    
                                        </div>

                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .login .card
    {
        position: relative;
        top: 30%;
    }
    .login .btn
    {
        width: 100%;
        border-radius: 0;
    }
    /* enable absolute positioning */
.inner-addon {
  position: relative;
}
.login .form-control
{

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
.left-addon .fa  { left:  0px;}
.right-addon .fa { right: 0px;}

/* add padding  */
.left-addon input  { padding-left:  35px; }
</style>
<script>
    import { mapState } from 'vuex';
    import FormMixin from '../../components/mixins/form-mixin.js' ;
    import swal from '../../components/swal';

    export default {
        mixins: [FormMixin],
        data(){
            return{
                email:'',
                password:'',
                remember:false,
                login_status:1,
                srvError401:'',
                srvErrorUnknown:'',
            }
        },
        methods:{
             trans: function (string,defaultString) {
                return this.$trans('auth',string,defaultString);
             },
             handleSubmit: function (e) {
                this.$validator.validate().then(valid => {
                 if (valid) {
                        this.form_errors=[];
                        this.login();
                    }
            });
            return true;
            },
            login: function () {
                this.login_status=0;
                let email = this.email;
                let password = this.password;
                let remember = this.remember;
                this.$store.dispatch('auth/login', { email, password, remember})
                    .then((resp) => {
                        swal.successDialog('Login','Success!','success')
                        ({redirectUrl: window.location.href} = resp.data.success);
                    })
                        .catch(err => {
                            console.log();
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
            computed: {
                ...mapState([
                    'user',
                    'isLoggedIn',
                ]),
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
            }
        }
</script>

