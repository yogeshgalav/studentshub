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
                  {{ trans('Register') }}
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
                      </div>
                      <div class="form-group">
                        <label> {{ trans('Full Name') }} </label>
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
                            >
                          </div>
                          <span class="error">{{ errors.first('full_name') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="email"> {{ trans('E-Mail Address') }}</label>

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
                            >
                          </div>
                          <span class="error">{{ errors.first('email') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="password"> {{ trans('Password') }}</label>

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
                              type="password"
                              class="form-control"
                              name="password"
                              placeholder="Password"
                            >
                          </div>
                          <span class="error">{{ errors.first('password') }}</span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="password-confirm"> {{ trans('Confirm Password') }}</label>

                        <div class="inner-addon left-addon">
                          <div class="input_icon_frm">
                            <span class="icon_design_input"><i
                              class="fa fa-lock"
                            /></span>
                            <input
                              id="password-confirm"
                              v-validate="'required|confirmed:password'"
                              type="password"
                              class="form-control"
                              name="password_confirmation"
                              placeholder="Confirm Password"
                            >
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
                        <div class="login_btn_part">
                          <button
                            type="submit"
                            class="login_btn"
                          >
                            {{ trans('Register') }} <i
                              class="fa fa-arrow-right text-white"
                            />
                          </button>
                        </div>
                      </div>
                      <div>
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
      <div class="login_card">
        <div class="row">
          <div class="col-md-12 text-center mt-3">
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

</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import swal from '../../components/swal';


export default {
	mixins: [FormMixin],
	data() {
		return {
			showLoader: false,
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
		this.join_id = this.$route.params.joinId;
		this.$validator.localize('en', this.dict);
	},
	methods: {
		trans: function (string, defaultString) {
			return this.$trans('auth', string, defaultString);
		},
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
