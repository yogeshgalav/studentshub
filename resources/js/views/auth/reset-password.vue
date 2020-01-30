<template>
<main>
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ trans('Reset Password') }}</div>

                <div class="card-body">
                    <form @submit.prevent="handleSubmit">
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ trans('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" v-model="password" autocomplete v-validate="'required'">
                                <span>{{ errors.first('password') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm-password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="confirm-password" type="password" class="form-control" name="confirm-password" v-model="confirm_password" v-validate="'required'">
                                <span>{{ errors.first('confirm-password') }}</span>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ trans('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</template>
<script>
import Vue from 'vue';
import VeeValidate  from 'vee-validate';

Vue.use(VeeValidate);

export default {
    components:{
        VeeValidate
    },
    data(){
        return{
            password:'',
            confirm_password:'',
        }
    },
    methods:{
        trans: function (string) {
            return this.$trans('auth',string);
        },
        handleSubmit: function (e) {
            this.$validator.validate().then(valid => {
                if (valid) {
                    this.submitPassword();
                }
            });
        },
        submitPassword: function () {
            this.axios.post('/api/reset-password',{password:this.password,confirm_password:this.confirm_password,token:this.token})
            .then((resp)=>{
                window.location.href = "/login";
            }).catch((err)=>{

            })
        }
    },
   props:['token'] 
}
</script>
