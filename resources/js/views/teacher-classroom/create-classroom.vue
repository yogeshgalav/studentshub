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
                {{ 'Create Classroom' }}
              </h3>
            </div>

            <div class="card-body edu_det_page">
              <div class="row justify-content-center">
                <div class="col-md-12">
                  <p class="text-grey">
                    Please Enter Following Details to Create Classroom.
                  </p>
                </div>

                <div class="col-md-12 mt-2">
                  <form @submit.prevent="createClassroom">
                    <div class="form-group">
                      <label> {{ 'Classroom Name' }} </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 44px"
                          >
                            <i
                              class="fa fa-certificate"
                              aria-hidden="true"
                            /></span>
                          <input
                            v-model="classroom_name"
                            v-validate="'required'"
                            type="text"
                            name="classroom_name"
                            class="form-control"
                          >
                        </div>
                        <span
                          class="error"
                        >{{ formErrors('classroom_name') }}</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="mb-1"> {{ 'Program/Course Level' }} </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 44px"
                          >
                            <i
                              class="fa fa-certificate"
                              aria-hidden="true"
                            /></span>
                          <auto-complete
                            v-validate="'required'"
                            class="width-100"
                            :items="courseLevels"
                            :value="'name'"
                            name="course_level"
                            :placeholder="'Select Program Level'"
                            :is-async="false"
                            :create-new-item="false"
                            @selected="setCourseLevel"
                          />
                        </div>
                        <span
                          class="error"
                        >{{ formErrors('course_level') }}</span>
                      </div>
                    </div>
                    <div
                      v-if="show_courses"
                      class="form-group"
                    >
                      <label class="mb-1">
                        {{ 'Program/Course of classroom' }}
                      </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 44px"
                          >
                            <i
                              class="fa fa-certificate"
                              aria-hidden="true"
                            /></span>
                          <auto-complete
                            v-validate="'required'"
                            class="width-100"
                            :items="course_list"
                            :value="'course_name'"
                            name="program_name"
                            :placeholder="'eg. Bachelor of Arts'"
                            :is-async="true"
                            :is-loading="courseLoading"
                            @input="getCourses"
                            @selected="setCourse"
                            @selectNew="setNewCourse"
                          />
                        </div>
                        <span
                          v-if="selected_course.totalBatch"
                        >{{ selected_course.totalBatch }} batch found.</span>
                        <span
                          v-if="no_course_found"
                        >Please enter your full Program name followed by
                          branch name(if any).Please make sure that program
                          details you are entering is correct.</span>
                        <span
                          class="error"
                        >{{ formErrors('program_name') }}</span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="mb-1"> {{ 'Subject of Classroom' }} </label>
                      <div class="inner-addon left-addon">
                        <div class="input_icon_frm">
                          <span
                            class="icon_design_input"
                            style="height: 44px"
                          >
                            <i
                              class="fa fa-certificate"
                              aria-hidden="true"
                            /></span>
                          <auto-complete
                            v-validate="'required'"
                            class="width-100"
                            :items="subject_list"
                            :value="'subject_name'"
                            name="program_name"
                            :placeholder="'eg. Biology,Chemistry'"
                            :is-async="true"
                            :is-loading="subjectLoading"
                            @input="getSubjects"
                            @selected="setSubject"
                            @selectNew="setNewSubject"
                          />
                        </div>
                        <span
                          class="error"
                        >{{ formErrors('subject_name') }}</span>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label
                            class="text-black"
                            for="event_date_input"
                          >
                            {{ ('Batch Starting Year') }}
                          </label>
                          <div class="input-group-prepend">
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
                                default-value="2019"
                                :input-attr="{id: 'start_year_input', value: start_year}"
                                placeholder="Start Year"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label
                            class="text-black"
                            for="event_date_input"
                          >
                            {{ ('Batch Ending Year') }}
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
                                default-value="2019"
                                :input-attr="{id: 'end_year_input', value: end_year}"
                                placeholder="End Year"
                              />
                            </div>
                          </div>
                        </div>
                      </div>
                      <span class="error">{{ yearError }}</span>
                    </div>
                    <div class="form-group d-flex s_register_btn">
                      <button
                        type="submit"
                        class="login_btn"
                      >
                        {{ 'Create' }}
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
.form-group label,
.form-check label {
  margin-bottom: 0rem;
}
.width-100 {
  width: 100% !important;
}

.hide-program {
  display: none;
}

.main-habit-builder li {
  list-style: none;
  padding: 5px;
}

.main-habit-builder ul {
  padding-left: 0px;
}

.main-habit-builder .card {
  padding: 20px !important;
}

.main-habit-builder .form-group {
  padding-bottom: 5px;
  padding-top: 5px;
}

@media (max-width: 768px) {
  .btn-footer .btn {
    width: 100%;
  }
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
		AutoComplete,
		DatePicker
	},
	mixins: [FormMixin],
	props: ['courseLevels'],
	data() {
		return {
			classroom_name: '',
			start_year: '',
			end_year: '',
			step: 'step1',
			show_courses: false,
			showLoader: false,
			course_list: [],
			courseLoading: false,
			no_course_found: false,
			selected_course: {
				'id': null,
				'course_name': '',
				'category_id': ''
			},
			subject_list: [],
			subjectLoading: false,
			selected_subject: {
				'id': null,
				'subject_name': '',
			},
			selected_level: {
				'id': null,
				'subject_name': '',
			},
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
	methods: {
		createClassroom() {
			if(this.yearError!==''){
				return false;
			}
			this.$validator.validate().then(valid => {
				if (valid) {
					this.form_errors=[];
					this.axios.post('/api/classroom/create', {
						course: this.selected_course,
						subject: this.selected_subject,
						name: this.classroom_name,
						start_year: this.start_year,
						end_year: this.end_year,
					}).then((resp)=>{
						if (resp.data.success) {
							swal.successDialog('Classroom create', 'Success!', 'success');
							window.location.href = '/classroom/'+resp.data.success.id;
						}
					}).catch((err)=>{
						if(err.response.status===422){
							let error_data = err.response.data.error;
							// this.form_errors[error_data.field]=[];
							// this.form_errors[error_data.field][0] = error_data.message;
							// console.log(error_data,this.form_errors);
						}
					});
				}
			});
			return true;
		},
		getCourses(search) {
			this.selected_course = {
				'id': null,
				'course_name': search,
				'category_id': ''
			};
			this.courseLoading = true;
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
					this.no_course_found = this.course_list.length === 0 ? true : false;
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
			this.categoryDisabled = false;
		},
		getSubjects	(search) {
			this.selected_subject = {
				'id': null,
				'subject_name': search,
			};
			this.subjectLoading = true;
			this.axios
				.post(this.baseUrl + '/api/search-subject', {
					searchTerm: search
				})
				.then(resp => {
					this.subject_list = resp.data.success.subjects;
					this.subject_list.find(node => {
						if (node.subject_name.toLowerCase() === this.selected_subject.subject_name
							.toLowerCase()) {
							this.selected_subject = node;
							return true;
						}
					});
					this.subjectLoading = false;
				}).catch(() => {
					this.subjectLoading = false;
				});

		},
		setSubject(result) {
			this.selected_subject = result;
		},
		setNewSubject(name) {
			this.selected_subject = {
				'id': 0,
				'subject_name': name,
			};
		},
		setCourseLevel(result){
			this.selected_level = result;
			this.show_courses=false;
			if(this.selected_level.level===2){
				this.selected_course = {
					'id': 1001,
					'course_name': this.selected_level.name,
					'category_id': null
				};
			}else if(this.selected_level.level===3){
				this.selected_course = {
					'id': 1002,
					'course_name': this.selected_level.name,
					'category_id': null
				};
			}else if(this.selected_level.level===4){
				this.selected_course = {
					'id': 1003,
					'course_name': this.selected_level.name,
					'category_id': null
				};
			}else{
				this.show_courses=true;
			}

		}
	}
};
</script>
