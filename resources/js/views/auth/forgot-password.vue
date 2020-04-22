<template>
    <div class="container">
        <loading 
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
        <div class="row justify-content-center login">
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header text-center">
                        <h3 class="weight-800 text-black font-size-18">{{ trans('Forgot Password') }}</h3>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="handleSubmit">
                        <div class="form-group row alert alert-danger" v-if="srvError">
                            <span>{{ trans('An unknown error has occurred.') }}</span>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ trans('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" v-model="email" autofocus v-validate="'required|email'">
                                <span>{{ formErrors('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
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
    .forgot-password .card
    {
        position: relative;
        top: 50%;
    }
</style>
<script>
import swal from '../../components/swal';
import FormMixin from '../../components/mixins/form-mixin.js' ;

export default {
    mixins: [FormMixin],
    data(){
        return{
            email:'',
            confirm_text:'',
            srvError: '',
        }
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
            this.axios.post('/api/forgot-password',{email:this.email})
            .then(()=>{
                swal.infoDialog(this.confirm_text)
            }).catch(()=>{
                this.srvError = true;
            })
        }
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
                    self.confirm_text=self.trans("forgotPassword.confirmEmail","Please check your email. If an account with the specified email address exists, you will be sent a link to reset your password.");
                    return true;
                }else if(value.match(phoneno)){
                    self.confirm_text=self.trans("forgotPassword.confirmPhone","Please check your phone. If an account with the specified phone number exists, you will be sent a link to reset your password.");
                    return true;
                }
                return false;
            }
            });
    }
}
</script>
