<template>
<div>
        <loading :active.sync="showLoader" :color="'#10069F'" :width="250" :is-full-page="true" />


        <div class="container pb-100">
            <div class="row justify-content-center register">
                <div class="col-md-8">
                    <div class="logn_right login_card">
                        <div class="card_title text-center">
                            <h3 class="weight-800 text-black font-size-18">{{ 'Create Classroom' }}</h3>
                        </div>

                        <div class="card-body edu_det_page">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <p class="text-grey">Please Enter Following Details to Create Classroom.</p>
                                </div>
                               
                                <div class="col-md-12 mt-2">
                                    <form @submit.prevent="createClassroom">
                                        <div class="form-group">
                                            <label> {{ 'Classroom Name'}} </label>
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 44px;"> <i
                                                            class="fa fa-certificate" aria-hidden="true"></i></span>
                                                    <input type="text" v-model="classroom_name" name="classroom_name" class="form-control" v-validate="'required'">
                                                </div>
                                                <span class="error">{{ formErrors('classroom_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"> {{ 'Program/Course Level.'}} </label>
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 44px;"> <i
                                                            class="fa fa-certificate" aria-hidden="true"></i></span>
                                                    <auto-complete class ="width-100"  :items="courseLevels" :value="'name'" v-validate="'required'"
                                                         name="course_level" :placeholder="'eg. Bachelor of Arts'" :is-async="false"
                                                        @selected="setCourseLevel" :createNewItem="false" />
                                                </div>
                                                <span class="error">{{ formErrors('course_level') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="show_courses">
                                            <label class="mb-1"> {{ 'Program/Course of classroom.'}} </label>
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 44px;"> <i
                                                            class="fa fa-certificate" aria-hidden="true"></i></span>
                                                    <auto-complete class ="width-100"  :items="course_list" :value="'course_name'" v-validate="'required'"
                                                         name="program_name" :placeholder="'eg. Bachelor of Arts'" :is-async="true"
                                                        @input="getCourses" @selected="setCourse"
                                                        @selectNew="setNewCourse" :is-loading="courseLoading" />
                                                </div>
                                                <span v-if="selected_course.totalBatch">{{selected_course.totalBatch }}
                                                    batch found.</span>
                                                <span v-if="no_course_found">Please enter your full Program name
                                                    followed by branch name(if any).Please make sure that program
                                                    details you are entering is correct.</span>
                                                <span class="error">{{ formErrors('program_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="mb-1"> {{ 'Subject of Classroom.'}} </label>
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 44px;"> <i
                                                            class="fa fa-certificate" aria-hidden="true"></i></span>
                                                    <auto-complete  class ="width-100" :items="subject_list" :value="'subject_name'" v-validate="'required'"
                                                         name="program_name" :placeholder="'eg. Biology,Chemistry'" :is-async="true"
                                                        @input="getSubjects" @selected="setSubject"
                                                        @selectNew="setNewSubject" :is-loading="subjectLoading" />
                                                
                                                </div>
                                                <span class="error">{{ formErrors('subject_name') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label> {{ 'Classroom Id.'}} </label>
                                            
                                            <input type="text" v-model="classroom_id" name="classroom_id" class="form-control">
                                        </div>
                                        <div class="form-group d-flex s_register_btn">
                                            <button type="submit" class="login_btn">{{ 'Create' }}</button>
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
        display: none
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
    import FormMixin from "../../components/mixins/form-mixin.js";
    import AutoComplete from "../../components/AutoComplete.vue";
    import swal from '../../components/swal';

    export default {
        mixins: [FormMixin],
        props: ['courseLevels'],
        components: {
            AutoComplete
        },
        data() {
            return {
                classroom_id: '',
                classroom_name: '',
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
        methods: {
            getFirstChar(str){
                var matches = str.match(/\b(\w)/g);
                var acronym = matches.join('');
                return acronym.toUpperCase();
            },
            createClassroom() {
                 this.$validator.validate().then(valid => {
                    if (valid) {
                        this.form_errors=[];
                        this.axios.post('/api/classroom/create', {
                            course: this.selected_course,
                            subject: this.selected_subject,
                            name: this.classroom_name,
                            classroom_id: this.classroom_id,
                        }).then((resp)=>{
                            if (resp.data.success) {
                                swal.successDialog('Classroom create', 'Success!', 'success')
                                window.location.href = '/classroom/'+resp.data.success.id;
                            }
                        }).catch((err)=>{
                            if(err.response.status===422){
                                
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
            getSubjects(search) {
                this.selected_subject = {
                    'id': null,
                    'subject_name': search,
                };
                this.classroom_id = this.getFirstChar(search)+'BY'+this.getFirstChar(this.AuthUser.full_name);
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
                this.classroom_id=this.getFirstChar(result.subject_name)+'BY'+this.getFirstChar(this.AuthUser.full_name);
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
    }

</script>
