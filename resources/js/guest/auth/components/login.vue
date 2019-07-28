<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 login">
                <div class="card">
                    <div class="card-header">{{ trans('Login') }}</div>

                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                            <div class="form-group row alert alert-danger" v-if="srvError401">
                                <span>{{ trans('Invalid login credentials. Please try again.') }}</span>
                            </div>
                            <div class="form-group row alert alert-danger" v-if="srvErrorUnknown">
                                <span>{{ trans('An unknown error has occurred.') }}</span>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" class="form-control" name="email" v-model.lazy="email" autofocus v-validate="'required|email'">
                                    <span class="error">{{ formErrors('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="password" v-validate="'required'">
                                    <span class="error">{{ formErrors('password') }}</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div>
                                        <input type="checkbox" name="remember" id="remember" v-model="remember" />
                                        <label for="remember">
                                            {{ trans('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('Login') }}
                                    </button>

                                    <a class="btn btn-link" href="/forgot-password">
                                        {{ trans('Forgot Your Password') }}
                                    </a>

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
        top: 50%;
    }
</style>
<script>
    import { mapState } from 'vuex';
    import FormMixin from '../../components/mixins/form-mixin.js' ;

    export default {
        mixins: [FormMixin],
        data(){
            return{
                email:'',
                password:'',
                remember:false,
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
            },
            login: function () {
                let email = this.email;
                let password = this.password;
                let remember = this.remember;
                this.$store.dispatch('auth/login', { email, password, remember})
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

