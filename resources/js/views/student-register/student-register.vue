<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="container pb-100">
      <div class="row justify-content-center register">
        <div class="col-md-8">
          <div class="logn_right login_card">
            <div class="card_title text-center">
              <h3 class="weight-800 text-black font-size-18">
                {{ trans('Check-In') }}
              </h3>
            </div>

            <div class="card-body edu_det_page">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <p class="text-grey">
                    Please enter Education details of your preferred Program and Batch to avail
                    full benefits from our platform.
                  </p>
                </div>
                <div class="col-md-12 mt-2">
                  <form @submit.prevent="handleSubmit">
                    <div class="form-group">
                      <label> {{ trans('Institute Name') }} </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 43px;"
                          ><i
                            class="fa fa-university"
                            aria-hidden="true"
                          /></span>
                          <auto-complete
                            :key="'institute'"
                            v-validate="'required'"
                            :items="institute_list"
                            :value="'name'"
                            name="institute_name"
                            :is-async="true"
                            :initial-value="selected_institute"
                            :is-loading="instituteLoading"
                            @input="getInstitutes"
                            @selected="setInstitute"
                          />
                        </div>
                        <span
                          v-if="selected_institute.totalBatch"
                        >{{ selected_institute.totalBatch }} batch found.</span>
                        <span
                          v-if="selected_institute.id===0"
                        >{{ selected_institute.description }}</span>
                        <span v-if="institute_list.length===0 && selected_institute.id===0">Please Enter Full Institute name.</span>
                        <span class="text-danger">{{ formErrors('institute_name') }}</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="mb-1"> {{ 'Program/Course Level' }} </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 44px;"
                          > <i
                            class="fa fa-certificate"
                            aria-hidden="true"
                          /></span>
                          <auto-complete
                            :key="'courseLevel'"
                            v-validate="'required'"
                            :initial-value="selected_level"
                            class="width-100"
                            :items="courseLevels"
                            :value="'name'"
                            name="course_level"
                            :is-async="false"
                            :create-new-item="false"
                            @selected="setCourseLevel"
                          />
                        </div>
                        <span class="error">{{ formErrors('course_level') }}</span>
                      </div>
                    </div>
                    <div
                      v-if="show_courses"
                      class="form-group"
                    >
                      <label> {{ 'Degree/Program in which you Enroll' }} </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 44px;"
                          > <i
                            class="fa fa-certificate"
                            aria-hidden="true"
                          /></span>
                          <auto-complete
                            :key="'courseList'"
                            ref="courseList"
                            v-validate="'required'"
                            :items="course_list"
                            :value="'course_name'"
                            name="program_name"
                            :placeholder="'eg. Bachelor of Arts'"
                            :is-async="true"
                            :initial-value="selected_course"
                            :is-loading="courseLoading"
                            @input="getCourses"
                            @selected="setCourse"
                            @selectNew="setNewCourse"
                          />
                        </div>
                        <span v-if="selected_course.totalBatch">{{ selected_course.totalBatch }}
                          batch found.</span>
                        <span v-if="no_course_found">Please enter your full Program name
                          followed by branch name(if any).Please make sure that program
                          details you are entering is correct.</span>
                        <span class="error">{{ formErrors('program_name') }}</span>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 form-group">
                        <label for="college_id">Unique Institute Id/Registration no.</label>
                        <div class="input_icon_frm">
                          <span
                            id="basic-addon1"
                            class="icon_design_input"
                          ><i
                            class="fa fa-id-card"
                            aria-hidden="true"
                          /></span>
                          <input
                            id="college_id"
                            v-model="college_id"
                            v-validate="'required'"
                            name="institute_id"
                            type="text"
                            class="form-control u_input"
                          >
                          <span class="error">{{ formErrors('institute_id') }}</span>
                        </div>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label
                            class="text-black"
                            for="event_date_input"
                          >
                            {{ trans('Batch Starting Year') }}
                          </label>
                          <div class="input-group-prepend ">
                            <div
                              class="input-group-prepend date"
                              data-provide="datepicker"
                            />
                            <div class="input_icon_frm">
                              <span
                                id="basic-addon1"
                                class="icon_design_input"
                              ><i
                                class="fa fa-calendar"
                              /></span>

                              <date-picker
                                id="start_year"
                                v-model="start_year"
                                v-validate="'required'"
                                name="start_year"
                                value-type="format"
                                :typeable="true"
                                :type="'year'"
                                :lang="'en'"
                                :input-attr="{id: 'start_year_input', value: start_year}"
                                placeholder="Start Year"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <label
                          class="text-black"
                          for="event_date_input"
                        >
                          {{ trans('Batch Ending Year') }}
                        </label>
                        <div class="input-group-prepend ">
                          <div
                            class="input-group-prepend date"
                            data-provide="datepicker"
                          />
                          <div class="input_icon_frm">
                            <span
                              id="basic-addon1"
                              class="icon_design_input"
                            ><i
                              class="fa fa-calendar"
                            /></span>
                            <date-picker
                              id="end_year"
                              v-model="end_year"
                              v-validate="'required'"
                              value-type="format"
                              name="end_year"
                              :typeable="true"
                              :type="'year'"
                              :lang="'en'"
                              :input-attr="{id: 'end_year_input', value: end_year}"
                              placeholder="End Year"
                            />
                          </div>
                        </div>
                      </div>
                      <span class="error">{{ formErrors('start_year') }}</span>
                      <span class="error">{{ formErrors('end_year') }}</span>
                      <span class="error">{{ yearError }}</span>
                    </div>
                    <div class="form-group d-flex s_register_btn">
                      <button
                        type="submit"
                        class="login_btn"
                      >
                        {{ trans('Submit') }} <span><i
                          class="fa fa-arrow-right"
                          aria-hidden="true"
                        /></span>
                      </button>
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

    .autocomplete {
        position: relative;
        width: 100%;
    }

    .autocomplete input {
        border-radius: 0;
    }

    .register .btn {
        width: 100%;
        border-radius: 0;
    }

    /* enable absolute positioning */
    .inner-addon {
        position: relative;
    }

    .login_card .form-control {
        color: black !important;
        border-radius: 0 !important;
    }

    /* style glyph */

    /* align glyph */
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

    .s_register_btn button {
        margin: 0px 0px 0 15px;
    }

    .select_box {
        width: 100%;
        border-radius: 0;
        border: solid 1px#ccc;
    }

    .register .input-group-text {
        border-radius: 0;
    }

    .form-group.d-flex.s_register_btn {
        margin: 20px 0 0;
    }

    a.skip_btn {
        width: 50%;
        background-color: white;
        border: solid 1px #ccc;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        color: black;
        border-radius: 5px;
    }
    a.skip_btn span {
    margin-right: 10px;
    color: r;
    }
    button.login_btn i {
        color: white;
    }
    button.login_btn span {
        color: white;
        margin-left: 10px;
    }

</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import AutoComplete from '../../components/AutoComplete.vue';
import swal from '../../components/swal';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
	components: {
		DatePicker,
		AutoComplete
	},
	mixins: [FormMixin],
	props: ['courseLevels','studentDetails', 'batches'],
	data() {
		return {
			showLoader: false,
			show_courses: false,
			course_list: [],
			courseLoading: false,
			no_course_found: false,
			institute_list: [],
			instituteLoading: false,
			selected_course: {
				'id': null,
				'course_name': '',
				'category_id': ''
			},
			selected_institute: {
				'id': null,
				'name': name,
				'place_id': '',
				'address': '',
				'description': ''
			},
			selected_level: {
				'id': null,
				'subject_name': '',
			},
			end_year: '',
			start_year: '',
			is_prefferred: true,
			college_id: '',
			current_date:new Date(),
		};
	},
	computed:{
		yearError(){
			var d = new Date();
			var n = d.getFullYear();
			if(this.start_year>n){
				return 'Please enter currect start year.';
			}else if(this.end_year && this.end_year<this.start_year){
				return 'Please enter currect start and end year.';
			}
			return '';
		}
	},
	mounted(){
		if(this.studentDetails){
			this.selected_course['id']=this.studentDetails.courseId;
			this.selected_course['course_name']=this.studentDetails.courseName;
			this.selected_institute['id']=this.studentDetails.instituteId;
			this.selected_institute['name']=this.studentDetails.instituteName;
			this.college_id = this.studentDetails.college_id;
			this.start_year = this.studentDetails.start_year;
			this.end_year = this.studentDetails.end_year;
			if(this.selected_course.id===1001){
				this.selected_level={
					id:1,
					level:2,
					name:'Preparatory Stage (3-5)'
				};
			}else if(this.selected_course.id===1002){
				this.selected_level={
					id:2,
					level:3,
					name:'"Middle Stage (6-8)"'
				};
			}else if(this.selected_course.id===1003){
				this.selected_level={
					id:3,
					level:4,
					name:'"Secondary Stage (9-12)"'
				};
			}else{
				this.selected_level={
					id:4,
					level:5,
					name:'Bachelor'
				};
				this.show_courses=true;
			}
		}
	},
	methods: {
		trans: function (string, defaultString) {
			return this.$trans('auth', string, defaultString);
		},
		getCourses(search) {
			this.selected_course = {
				'id': null,
				'course_name': search,
				'category_id': ''
			};
			this.courseLoading = true;
			this.$refs.courseList.$el.focus();
			this.axios
				.post(this.baseUrl + '/api/search-course', {
					searchTerm: search
				})
				.then(resp => {
					this.course_list = resp.data.success.courses;
					this.course_list.find(node => {
						if (node.course_name.toLowerCase() === this.selected_course.course_name
							.toLowerCase()) {
							this.selected_course = node;
							return true;
						}
					});
					this.no_course_found= this.course_list.length===0 ? true :false;
					this.courseLoading = false;
				}).catch(() => {
					this.courseLoading = false;
				});

		},
		setCourse(result) {
			this.selected_course = result;
		},
		setNewCourse(name) {
			this.selected_course = {
				'id': 0,
				'course_name': name,
				'category_id': 0
			};
		},
		getInstitutes(search) {
			this.selected_institute = {
				'id': null,
				'name': search,
				'place_id': '',
				'address': '',
				'description': ''
			};
			this.instituteLoading = true;
			this.axios
				.post(this.baseUrl + '/api/search-institute', {
					searchTerm: search
				})
				.then(resp => {
					this.institute_list = resp.data.success.institutes;
					this.institute_list.find(node => {
						if (node.name.toLowerCase() === this.selected_institute.name.toLowerCase()) {
							this.selected_institute = node;
							return true;
						}
					});
					this.instituteLoading = false;
				}).catch(() => {
					this.instituteLoading = false;
				});

		},
		setInstitute(result) {
			this.selected_institute = result;
		},
		handleSubmit(e) {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.form_errors=[];
					this.register();
				}
			});
			return true;
		},
		register() {
			// if (this.selected_institute.name.trim() === '') {
			//     this.errors.institute_name = 'Institute Name is required.';
			//     return false;
			// }
			// if (this.selected_course.course_name.trim() === '') {
			//     this.errors.program_name = 'Program Name is required.';
			//     return false;
			// }
			if(this.yearError!==''){
				return false;
			}
			this.showLoader = true;
			axios.post('/api/checkin', {
				course_id: this.selected_course.id,
				course_name: this.selected_course.course_name,
				category_id: this.selected_course.category_id,
				institute_id: this.selected_institute.id,
				institute_name: this.selected_institute.name,
				is_prefferred: this.is_prefferred,
				college_id: this.college_id,
				start_year: this.start_year,
				end_year: this.end_year,
			}).then((resp) => {
				this.showLoader = false;
				if (resp.data.success) {
					swal.successDialog('Check-In', 'Success!', 'success');
					window.location.href = resp.data.success.redirectUrl;
				}
			}).catch(() => {
				this.showLoader = false;
			});
		},
		setCourseLevel(result){
			this.selected_level = result;
			this.show_courses=false;
			switch(this.selected_level.level) {
			case 2:
				this.selected_course = {
					'id': 1001,
					'course_name': this.selected_level.name,
					'category_id': null
				};
				break;
			case 3:
				this.selected_course = {
					'id': 1002,
					'course_name': this.selected_level.name,
					'category_id': null
				};
				break;
			case 4:
				this.selected_course = {
					'id': 1003,
					'course_name': this.selected_level.name,
					'category_id': null
				};
			default:
				this.show_courses=true;
				break;
			}
		}
	},
};

</script>
