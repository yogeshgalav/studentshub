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
                    <div 
                      v-if="instituteList.length>1"
                      class="form-group"
                    >
                      <label class="mb-1"> {{ 'Institute' }} </label>
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
                            :items="instituteList"
                            :value="'name'"
                            name="course_level"
                            :placeholder="'Select Program Level'"
                            :is-async="false"
                            :create-new-item="false"
                            @selected="setInstitute"
                          />
                        </div>
                        <span
                          class="error"
                        >{{ formErrors('course_level') }}</span>
                      </div>
                    </div>
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
                            placeholder="2nd Year Section B"
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
                            :create-new-item="false"
                            :is-loading="courseLoading"
                            @input="getCourses"
                            @selected="setCourse"
                            @selectNew="setNewCourse"
                          />
                        </div>
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
                            name="subject_name"
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

                    <div class="form-group d-flex s_register_btn">
                      <button
                        type="submit"
                        class="btn-primary btn-lg m-0-a"
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
import FormMixin from '../../../components/mixins/form-mixin.js';
import AutoComplete from '../../../components/AutoComplete.vue';
import swal from '../../../components/swal';

export default {
	components: {
		AutoComplete,
	},
	mixins: [FormMixin],
	props: ['courseLevels','instituteList'],
	data() {
		return {
			institute_id: '',
			classroom_name: '',
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
				'subject_name': '',
			},
			selected_level: {
				'id': null,
				'subject_name': '',
			},
		};
	},
	mounted(){
		if(this.instituteList.length===1){
			this.institute_id = this.instituteList[0].id; 
		}
	},
	methods: {
		createClassroom() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.form_errors=[];
					this.axios.post('/api/classroom/create', {
						course_id: this.selected_course.id,
						subject_name: this.selected_subject.subject_name,
						classroom_name: this.classroom_name,
						institute_id: this.institute_id,
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
				.get(this.baseUrl + '/api/search-course?searchTerm='+search)
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
				'subject_name': search,
			};
			this.subjectLoading = true;
			this.axios
				.get(this.baseUrl + '/api/search-subject?searchTerm='+search)
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
				'subject_name': name,
			};
		},
		setInstitute(result){
			this.institute_id = result.id;
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
