<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div :class="!createPost ? 'container pb-100' : ''">
      <div :class="['login_card', (createPost ? 'pos-inherit' : '')]">
        <div class="row justify-content-center register">
          <div class="col-md-6">
            <div class="login_img">
              <img
                v-lazy="'/images/register.svg'"
                alt="studentsHub register"
              >
            </div>
          </div>
          <div class="col-md-6">
            <div class="logn_right">
              <div class="card_title text-center">
                <h3 class="weight-800 text-black font-size-18">
                  {{ ('Register') }}
                </h3>
              </div>

              <div class="card_body">
                <div class="row justify-content-center">
                  <div class="col-md-12">
                    <form
                      id="register_form"
                      name="register"
                      method="POST"
                      action="/register"
                      @submit.prevent="handleSubmit"
                    >
                      <div class="form-group">
                        <input
                          id="token"
                          type="hidden"
                          class="form-control"
                          name="_token"
                          :value="csrfToken"
                        >
                        <input
                          id="fcmToken"
                          type="hidden"
                          class="form-control"
                          name="fcmToken"
                          :value="fcmToken"
                        >
                      </div>

                      <div class="form-group">
                        <label for="password"> {{ ('Password') }}</label>
                        <div class="inner-addon left-addon ">
                          <div class="input_icon_frm">
                            <span class="icon_design_input"><i
                              class="fa fa-lock"
                            /></span>
                            <input
                              id="password"
                              ref="password"
                              v-model="password"
                              v-validate="'required|min:8'"
                              :type="showPassword ? 'text' : 'password'"
                              class="form-control"
                              name="password"
                              placeholder="Password"
                              maxlength="16"
                            >
                            <div
                              class="input-group-append"
                              @click="showPassword = !showPassword"
                            >
                              <span
                                v-show="showPassword"
                                class="input-group-text"
                              ><i
                                                         
                                class="fa fa-eye-slash"
                                aria-hidden="true"
                              />
                              </span>
                              <span
                                v-show="!showPassword"
                                class="input-group-text"
                              >
                                <i                     
                                  class="fa fa-eye"
                                  aria-hidden="true"
                                />
                              </span>
                            </div>
                          </div>
                          <span class="error">{{ formErrors('password') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="password-confirm"> {{ ('Confirm Password') }}</label>

                        <div class="inner-addon left-addon">
                          <div class="input_icon_frm">
                            <span class="icon_design_input"><i
                              class="fa fa-lock"
                            /></span>
                            <input
                              id="password-confirm"
                              v-validate="'required|confirmed:password'"
                              :type="showConfirmPassword ? 'text' : 'password'"
                              class="form-control"
                              name="password_confirmation"
                              placeholder="Confirm Password"
                            >
                            <div
                              class="input-group-append"
                              @click="showConfirmPassword = !showConfirmPassword"
                            >
                              <span
                                v-show="showConfirmPassword"
                                class="input-group-text"
                              ><i
                                                         
                                class="fa fa-eye-slash"
                                aria-hidden="true"
                              />
                              </span>
                              <span
                                v-show="!showConfirmPassword"
                                class="input-group-text"
                              >
                                <i                     
                                  class="fa fa-eye"
                                  aria-hidden="true"
                                />
                              </span>
                            </div>
                          </div>
                          <span class="error">{{ formErrors('password_confirmation') }}</span>
                        </div>
                      </div>
                      <div
                        v-if="join_id"
                        class="form-group"
                      >
                        <label> {{ 'Join Id:' }} </label>
                        <strong class="font-size-18">{{ join_id }}</strong>
                      </div>

                      <div 
                        v-if="!createPost"
                        class="form-group mb-0"
                      >
                        <div>
                          <button
                            type="submit"
                            class="btn-primary btn-lg m-0-a"
                          >
                            {{ ('Register') }}&nbsp;<i
                              class="fa fa-arrow-right text-white"
                            />
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div
                    v-if="!createPost"
                    style="text-align: center; margin-top: 20px;"
                  >
                    <a :href="'/login'">
                      Already have an account?
                    </a>
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
    .fa-exclamation-circle{
        cursor: pointer;
    }
    .fa-exclamation-circle:hover{
        color: blue;
    }
    /* .on-hover{
        width: 300px;
        font-size: 13px;
    } */
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

    .display-flex {
        display: flex;
    }
    
/*adding style to eye icon */
.input_icon_frm .input-group-append{
  cursor: pointer;
}
.pos-inherit {
  position: inherit;
}
</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import NoSidebarLayout from '@/Layouts/NoSidebarLayout';

export default {
	layout:NoSidebarLayout,
	mixins: [FormMixin],
	props:{
		createPost:{
			default:false,
		}
	},
	data() {
		return {
			showConfirmPassword: false,
			showPassword: false,
			showLoader: false,
			fcmToken: '',
			role: 'student',
			full_name: '',
			email: '',
			password: '',
			join_id: '',
			dict: {
				custom: {
					full_name: {
						required: 'You must provide your Full Name to continue.'
					},
					email: {
						required: 'You must provide your Email Address to continue.',
						email: 'Seems like you have entered an incorrect Email.'
					},
					password: {
						required: 'You must create new Password to continue.',
					},
					password_confirmation: {
						required: 'The confirm password field is required.',
						confirmed: 'The confirm password field is not same as password.'
					}
				}
			}
		};
	},
	mounted(){
		this.fcmToken = localStorage.getItem('fcmToken');
		if(this.$route){
			this.join_id = this.$route.query.joinId;
		}
		this.$validator.localize('en', this.dict);
	},
	methods: {
		handleSubmit(e) {
			this.validateForm().then(valid => {
				if (valid) {
					this.form_errors = [];
					if(!this.createPost){
						this.showLoader = true;
						document.getElementById('register_form').submit();
					} else {
						this.$store.commit('set_new_user_data',{
							full_name:full_name,      
							email:email,      
							password:password,      
						});
					}
				}
			});
			return true;
		},
	}
};

</script>
