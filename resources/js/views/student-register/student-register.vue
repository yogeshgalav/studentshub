<template>
    <div>
        <loading :active.sync="showLoader" :color="'#10069F'" :width="250" :is-full-page="true" />


        <div class="container pb-100">
            <div class="row justify-content-center register">
                <div class="col-md-8">
                    <div class="logn_right login_card">
                        <div class="card_title text-center">
                            <h3 class="weight-800 text-black font-size-18">{{ trans('Check-In') }}</h3>
                        </div>

                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <p class="text-grey">Please Enter Education details of your Prefferred Program and Batch to avail
                                        full benifits of our platform.</p>
                                </div>
                                <div class="col-md-10 mt-2">
                                    <form @submit.prevent="handleSubmit">
                                        <div class="form-group">
                                            <label> {{ trans('Institute Name') }} </label>
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 43px;"><i
                                                            class="fa fa-user" aria-hidden="true"></i></span>
                                                    <auto-complete :items="institute_list" :value="'name'"  name="institute_name" v-validate="'required'"
                                                        :is-async="true" @input="getInstitutes"
                                                        @selected="setInstitute" :is-loading="instituteLoading" />
                                                </div>
                                                <span
                                                    v-if="selected_institute.totalBatch">{{selected_institute.totalBatch }}
                                                    batch found.</span>
                                                <span
                                                    v-if="selected_institute.id===0">{{selected_institute.description}}</span>
                                                <span v-if="institute_list.length===0">Please Enter Full Institute
                                                    name.</span>
                                                <span class="text-danger">{{ formErrors('institute_name')}}</span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label> {{ 'Degree/Program in which you Enroll.'}} </label>
                                            <div class="inner-addon left-addon">
                                                <div class="input_icon_frm">
                                                    <span class="icon_design_input" style="height: 44px;"> <i
                                                            class="fa fa-certificate" aria-hidden="true"></i></span>
                                                    <auto-complete :items="course_list" :value="'course_name'" v-validate="'required'"
                                                         name="program_name" :placeholder="'eg. Bachelor of Arts'" :is-async="true"
                                                        @input="getCourses" @selected="setCourse"
                                                        @selectNew="setNewCourse" :is-loading="courseLoading" />
                                                </div>
                                                <span v-if="selected_course.totalBatch">{{selected_course.totalBatch }}
                                                    batch found.</span>
                                                <span v-if="selected_course.id===0">Please enter your full Program name
                                                    followed by branch name(if any).Please make sure that program
                                                    details you are entering is correct.</span>
                                                <span class="error">{{ formErrors('program_name') }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label> {{ trans('Category of selected Program:') }} </label><br />
                                                    <div class="input_icon_frm">
                                                        <span id="basic-addon1" class="icon_design_input"><i
                                                                class="fa fa-list-alt" aria-hidden="true" /></span>
                                                        <select name="category" id="category"
                                                            v-model="selected_course.category_id"
                                                            :disabled="categoryDisabled"
                                                            class="inner-addon left-addon select_box">
                                                            <option value="">Select Category</option>
                                                            <option value="1">Technology</option>
                                                            <option value="2">Management</option>
                                                            <option value="3">Healthcare</option>
                                                            <option value="4">Arts</option>
                                                            <option value="5">Science</option>
                                                            <option value="6">Economics</option>
                                                            <option value="7">Education</option>
                                                            <option value="8">Pharmacy</option>
                                                            <option value="9">Journalism</option>
                                                            <option value="10">Humanity</option>
                                                            <option value="11">Hospitality</option>
                                                            <option value="12">Fashion</option>
                                                            <option value="13">Computer</option>
                                                        </select></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label for="college_id">Unique College Id/Registration no.</label>
                                                <div class="input_icon_frm">
                                                    <span id="basic-addon1" class="icon_design_input"><i
                                                            class="fa fa-id-card" aria-hidden="true" /></span>
                                                    <input type="text" v-model="college_id" id="college_id"
                                                        class="form-control u_input">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="text-black" for="event_date_input">
                                                    {{ trans('Batch Starting Year') }}
                                                </label>
                                                <div class="input-group-prepend ">
                                                    <div class="input-group-prepend date" data-provide="datepicker">
                                                    </div>
                                                    <div class="input_icon_frm">
                                                        <span id="basic-addon1" class="icon_design_input"><i
                                                                class="fa fa-calendar"></i></span>

                                                        <date-picker id="start_year" name="start_year" v-validate="'required'"
                                                            value-type="format" v-model="start_year"
                                                            :not-after="current_date" :typeable="true" :type="'year'"
                                                            :lang="'en'" :input-attr="{id: 'start_year_input'}"
                                                            placeholder="Start Year" />
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{ formErrors('start_year') }}</span>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="text-black" for="event_date_input">
                                                    {{ trans('Batch Ending Year') }}
                                                </label>
                                                <div class="input-group-prepend ">
                                                    <div class="input-group-prepend date" data-provide="datepicker">

                                                    </div>
                                                    <div class="input_icon_frm">
                                                        <span id="basic-addon1" class="icon_design_input"><i
                                                                class="fa fa-calendar" /></span>
                                                        <date-picker id="end_year" v-validate="'required'"
                                                            value-type="format"  name="end_year" v-model="end_year"
                                                            :not-before="start_year_date" :typeable="true" :type="'year'"
                                                            :lang="'en'" :input-attr="{id: 'end_year_input'}"
                                                            placeholder="End Year" />
                                                    </div>
                                                </div>
                                                <span class="error">{{ formErrors('end_year') }}</span>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex s_register_btn">
                                            <a href="/" class="skip_btn"> {{ trans('Skip') }}</a>
                                            <button type="submit" class="login_btn">{{ trans('Register') }} <span><i
                                                        class="fa fa-arrow-right"
                                                        aria-hidden="true"></i></span></button>

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
    import FormMixin from "../../components/mixins/form-mixin.js";
    import AutoComplete from "../../components/AutoComplete.vue";
    import swal from '../../components/swal';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        mixins: [FormMixin],
        components: {
            DatePicker,
            AutoComplete
        },
        data() {
            return {
                showLoader: false,
                course_list: [],
                courseLoading: false,
                categoryDisabled: true,
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
                end_year: '',
                start_year: '',
                is_prefferred: true,
                college_id: '',
                current_date:new Date(),
            };
        },
        methods: {
            trans: function (string, defaultString) {
                return this.$trans("auth", string, defaultString);
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
                this.showLoader = true;
                axios.post('/api/checkin', {
                    course_id: this.selected_course.id,
                    course_name: this.selected_course.course_name,
                    category_id: this.selected_course.category_id,
                    institute_name: this.selected_institute.name,
                    institute_place_id: this.selected_institute.place_id,
                    institute_address: this.selected_institute.address,
                    institute_description: this.selected_institute.description,
                    is_prefferred: this.is_prefferred,
                    college_id: this.college_id,
                    start_year: this.start_year,
                    end_year: this.end_year,
                }).then((resp) => {
                    this.showLoader = false;
                    if (resp.data.success) {
                        swal.successDialog('Check-In', 'Success!', 'success')
                        window.location.href = resp.data.success.redirectUrl;
                    }
                }).catch(() => {
                    this.showLoader = false;
                });
            },
        },
    };

</script>
