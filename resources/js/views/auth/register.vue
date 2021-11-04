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
              <img
                src="/images/register.svg"
                alt=""
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
                        <label> {{ ('Full Name') }} </label>
                        <div class="inner-addon left-addon">
                          <div class="input_icon_frm">
                            <span class="icon_design_input"><i
                              class="fa fa-user"
                            /></span>
                            <input
                              id="full_name"
                              v-model="full_name"
                              v-validate="'required'"
                              type="text"
                              class="form-control"
                              name="full_name"
                              placeholder="Enter Full Name"
                              autofocus
                              maxlength="255"
                            >
                          </div>
                          <span class="error">{{ errors.first('full_name') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="email"> {{ ('E-Mail Address') }}</label>

                        <div class="inner-addon left-addon">
                          <div class="input_icon_frm">
                            <span class="icon_design_input"><i
                              class="fa fa-envelope"
                            /></span>
                            <input
                              id="email"
                              v-model="email"
                              v-validate="'required|email'"
                              type="email"
                              class="form-control"
                              name="email"
                              placeholder="Email address"
                              maxlength="255"
                            >
                          </div>
                          <span class="error">{{ errors.first('email') }}</span>
                        </div>
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
                          <span class="error">{{ errors.first('password') }}</span>
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
                          <span class="error">{{ errors.first('password_confirmation') }}</span>
                        </div>
                      </div>


                      <div class="form-group">
                        <div
                          style="display: flex; justify-content: space-between; align-items: center;"
                          @click="joinIdInfoVisible = !joinIdInfoVisible"
                        >
                          <label> {{ 'Join Id (optional)' }} </label>
                          <i
                            class="fa fa-exclamation-circle"
                            aria-hidden=""
                          />
                        </div>
                        <div
                          v-if="joinIdInfoVisible"
                          style="display: flex; justify-content: flex-end;"
                          class="data"
                        >
                          <p class="on-hover text-grey">
                            Join id is provide by teacher to students to join classroom directly with correct education details. Ignore this field if you are a teacher or institute.
                          </p>
                        </div>

                        <div class="inner-addon left-addon">
                          <div class="input_icon_frm">
                            <span class="icon_design_input"><i
                              class="fa fa-user"
                            /></span>
                            <input
                              id="join_id"
                              v-model="join_id"
                              type="text"
                              class="form-control"
                              name="join_id"
                              placeholder="Classroom Join ID"
                              autofocus
                            >
                          </div>
                          <span class="error">{{ errors.first('join_id') }}</span>
                        </div>
                      </div>

                      <div class="form-group mb-0">
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
                      <div style="text-align: center; margin-top: 20px;">
                        <router-link :to="'/login'">
                          Already have an account?
                        </router-link>
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

</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import swal from '../../components/swal';


export default {
	mixins: [FormMixin],
	data() {
		return {
			showConfirmPassword: false,
			showPassword: false,
			showLoader: false,
			fcmToken: '',
			full_name: '',
			email: '',
			password: '',
			join_id: '',
			joinIdInfoVisible: false,
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
		this.join_id = this.$route.query.joinId;
		this.$validator.localize('en', this.dict);
	},
	methods: {
		handleSubmit(e) {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.form_errors = [];
					this.showLoader = true;
					document.getElementById('register_form').submit();
				}
			});
			return true;
		},
	}
};

</script>
