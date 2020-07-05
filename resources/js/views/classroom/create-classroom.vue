<template>
    <div class="row">
        <div class="col-md-8">
            <h1 class="text-black mb-3">
                Create Classroom
            </h1>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-8 pl-2 main-habit-builder">
                    <form autocomplete="off" @submit.prevent="handleSubmit">
                        <div class="form-group pt-0">
                            <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label mt-2">Subject Name</label>
                                            <input type="text" class="form-control" v-model="subject"
                                                name="subject_name" v-validate="'required'">
                                            <span class="error">{{ formErrors('subject_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label mt-2">Classroom Name</label>
                                            <input type="text" class="form-control" name="classroom_name" v-model="name"
                                                v-validate="'required'">
                                            <span class="error">{{ formErrors('classroom_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group pl-0">
                                        <label for="master_template" class="col-form-label mb-0 pt-0">Does this
                                            Classroom belongs to Program ?</label>
                                        <div class="custom-control custom-radio mt-2">
                                            <input id="master_template" v-model="include_program"
                                                v-validate="'required'" name="master" type="radio"
                                                class="custom-control-input" :value="true">
                                            <label for="master_template"
                                                class="custom-control-label">{{ 'YES' }}</label>
                                        </div>
                                        <div class="custom-control custom-radio mt-2">
                                            <input id="master_template_no" v-model="include_program"
                                                v-validate="'required'" name="master" type="radio" :value="false"
                                                class="custom-control-input">
                                            <label for="master_template_no"
                                                class="custom-control-label">{{ 'NO' }}</label>
                                        </div>
                                        <span class="error">{{ formErrors('master') }}</span>
                                    </div>
                                    <div class="col-md-12" v-if="include_program">
                                        <div class="model_input">
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 44px;"> <i
                                                            class="fa fa-certificate" aria-hidden="true"></i></span>
                                                    <auto-complete :items="course_list" :value="'course_name'"
                                                        v-validate="'required'" name="program_name"
                                                        :placeholder="'eg. Bachelor of Arts'" :is-async="true"
                                                        @input="getCourses" @selected="setCourse"
                                                        @selectNew="setNewCourse" :is-loading="courseLoading" />
                                                </div>
                                                <span v-if="no_course_found">Please enter your full Program name
                                                    followed by branch name(if any).Please make sure that program
                                                    details you are entering is correct.</span>
                                                <span class="error">{{ formErrors('program_name') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="model_btn">
                                            <button type="submit" class="btn btn-primary mr-3 mt-2">Create</button>
                                            <a href="/classrooms" class="btn btn-secondary mt-2">Go Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

    export default {
        mixins: [FormMixin],
        props: ['myClassrooms', 'classroomList'],
        components: {
            AutoComplete
        },
        data() {
            return {
                name: '',
                subject: '',
                include_program: true,
                course_list: [],
                courseLoading: false,
                no_course_found: false,
                selected_course: {
                    'id': null,
                    'course_name': '',
                    'category_id': ''
                },
            };
        },
        watch: {
            subject() {

            }
        },
        methods: {
            createClassroom() {
                this.axios.post('/api/classroom/create', {
                    subject: this.subject,
                    name: this.name,
                });
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
        }
    }

</script>
