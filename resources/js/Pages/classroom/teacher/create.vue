<template>
  <div>
    <Head>
      <title>Create Classrooms</title>
    </Head>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="">
      <h1 class="weight-800 text-black mb-3">
        Create Classroom
      </h1>
    </div>            
    <div class="pb-100">
      <div class="row">
        <div class="col-md-8">
          <div class="card p-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 mt-0">
                  <p class="text-black mb-0">
                    Please Enter Following Details to Create Classroom.
                  </p>
                </div>
                <div class="col-md-12 mt-2">
                  <form @submit.prevent="createClassroom">
                    <div 
                      class="form-group"
                    >
                      <select-institute
                        v-model="selected_institute"
                      />
  
                      <span
                        class="error"
                      >{{ formErrors('institute_name') }}</span>
                    </div>
                    <div class="form-group">
                      <label class="mb-1"> {{ 'Classroom Name' }} </label>
					  
                      <!-- <auto-complete
                        v-model="classroom_name"
                        :placeholder="'2nd Year Sections B'"
                        :items="classroom_list"
                        name="classroom_name"
                      /> -->
                      <input
                        v-model="classroom_name"
                        type="text"
                        class="form-control"
                        name="classroom_name"
                      ></input>
                      <span
                        class="error"
                      >{{ formErrors('classroom_name') }}</span>
                    </div>
                    <div class="form-group">
                      <select-course
                        v-model="selected_course"
                      />
                    </div>
                    
                    <div class="form-group">
                      <label class="mb-1"> {{ 'Subject of Classroom' }} </label>
                      <auto-complete
                        v-model="selected_subject"
                        v-validate="'required'"
                        class="width-100"
                        :items="subject_list"
                        :label="'subject_name'"
                        name="subject_name"
                        :placeholder="'eg. Biology,Chemistry'"
                        :is-async="true"
                        :is-loading="subjectLoading"
                        @search="getSubjects"
                        @selected="setSubject"
                      />
                      <span
                        class="error"
                      >{{ formErrors('subject_name') }}</span>
                    </div>

                    <div class="mt-5">
                      <button
                        type="create"
                        class="btn btn-primary btn-md"
                      >
                        Create
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
import SelectInstitute from '../../../components/SelectInstitute.vue';
import SelectCourse from '../../../components/SelectCourse.vue';

export default {
	components: {
		AutoComplete,SelectInstitute,SelectCourse
	},
	mixins: [FormMixin],
	props: ['courseLevels','instituteList'],
	data() {
		return {
			classroom_name: '',
			show_courses: false,
			showLoader: false,
			course_list: [],
			instituteLoading: false,
			courseLoading: false,
			no_course_found: false,
			selected_institute: {
				'id': null,
				'name': '',
			},
			selected_course: {
				'id': null,
				'course_name': '',
				'category_id': ''
			},
			subject_list: [],
			classroom_list:[],
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
			this.selected_institute = this.instituteList[0];
		}
	},
	methods: {
		createClassroom() {
			this.validateForm().then(valid => {
				if (valid) {
					let loader = this.$loading.show();
					this.form_errors=[];
					this.$gtag('event','Classroom Create');
					this.axios.post('/api/classroom/create', {
						course_id: this.selected_course.id,
						subject_name: this.selected_subject.subject_name,
						classroom_name: this.classroom_name,
						institute_name: this.selected_institute.name,
					}).then((resp)=>{
					  loader.hide();
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
