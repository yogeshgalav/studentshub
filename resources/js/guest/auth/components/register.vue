<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ trans('Register') }}</div>

                        <div class="card-body">
                            <form @submit="handleSubmit($event)" method="POST" action="/register">
                                <div class="form-group row">

                                    <input id="token" type="hidden" class="form-control" name="_token"
                                        :value="csrfToken">
                                    <span class="error">{{ formErrors('_token') }}</span>
                                </div>
                                <div class="form-group row">
                                    <label for="full_name"
                                        class="col-md-4 col-form-label text-md-right">{{ trans('Your Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="full_name" type="text" class="form-control" name="full_name"
                                            autofocus v-validate="'required'">
                                        <span class="error">{{errors.first('full_name')}}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-right">{{ trans('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                            v-validate="'required|email'">
                                        <span class="error">{{errors.first('email')}}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-right">{{ trans('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" ref="password" type="password" class="form-control"
                                            name="password" v-validate="'required'">
                                        <span class="error">{{errors.first('password')}}</span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-right">{{ trans('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" v-validate="'required|confirmed:password'">
                                        <span class="error">{{errors.first('password_confirmation')}}</span>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ trans('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <form>
                                <button @click="AuthProvider('github')">auth Github</button>
                                <button @click="AuthProvider('facebook')">auth Facebook</button>
                                <button @click="AuthProvider('google')">auth Google</button>
                                <button @click="AuthProvider('twitter')">auth Twitter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import FormMixin from '../../../components/mixins/form-mixin.js';

    export default {
        mixins: [FormMixin],
        data() {
            return {
                dict: {
                    custom: {
                        password_confirmation: {
                            required: 'The confirm password field is required'
                        },
                    }
                },
            }
        },
        methods: {
            trans: function (string, defaultString) {
                return this.$trans('auth', string, defaultString);
            },
            handleSubmit(e) {
                this.$validator.localize('en', this.dict);
                this.$validator.validate().then(valid => {
                    if (!valid) {
                        e.preventDefault();
                    }
                });
                return true;
            },

            AuthProvider(provider) {

                var self = this

                this.$auth.authenticate(provider).then(response => {

                    self.SocialLogin(provider, response)
                }).catch(err => {
                    console.log({
                        err: err
                    })
                })
            },

            SocialLogin(provider, response) {
                this.$http.post('/sociallogin/' + provider, response).then(response => {
                    console.log(response.data)
                }).catch(err => {
                    console.log({
                        err: err
                    })
                })
            },



        }   ,
        props: {

        }
    }

</script>
