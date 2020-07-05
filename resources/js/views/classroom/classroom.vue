<template>
    <div>
        <div class="container">
            <div class="row">
                <div class=" col-md-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 centerr-col">
                                <h3 class="font-size-30 text-black weight-800 mb-0">
                                    {{ classroomDetail.name }}
                                </h3>
                                <p class="font-size-14 text-black mb-1">
                                    <span style="color: #868686;"> {{ classroomDetail.subject_name }} </span>
                                </p>
                                <h3 class="font-size-18">
                                    {{ 'By ' }}: {{ classroomDetail.teacher_name }}
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <NavTabs size="large" :tabs="tabs" :initial-tab="initialTab">
                                    <template slot="tab-heading-Overview">
                                        {{ 'Overview' }}
                                    </template>
                                    <template slot="tab-panel-Overview">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card mt-5">
                                                    <div class="card-body">
                                                        <form>
                                                            <div class="form-group mb-0 row">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-black font-size-14">Name
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <div class="text-black">{{ classroomDetail.name }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 row">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-black font-size-14">Subject
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <div class="text-black">
                                                                        {{ classroomDetail.subject_name }} </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 row">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-black font-size-14">Course
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <div class="text-black">
                                                                        {{ classroomDetail.course_name }} </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group  row">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-black font-size-14">Expected
                                                                    Students </label>
                                                                <div class="col-sm-3">
                                                                    <div class="text-black"> <input type="text"
                                                                            class="form-control" id="expected_students">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group  row">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-black font-size-14">Classroom
                                                                    duration </label>
                                                                <div class="col-sm-3">
                                                                    <div class="text-black"><input type="text"
                                                                            class="form-control" id="duration"> </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-0 row">
                                                                <label
                                                                    class="col-sm-2 col-form-label text-black font-size-14">Total
                                                                    Units </label>
                                                                <div class="col-sm-10">
                                                                    <div class="text-black">3 </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <template slot="tab-heading-Setup">
                                        {{ 'Setup' }}
                                    </template>
                                    <template slot="tab-panel-Setup">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <unit-accordian :classroom-id="classroomDetail.id" />
                                            </div>
                                        </div>
                                    </template>
                                    <template slot="tab-heading-Students">
                                        {{ 'Students' }}
                                    </template>
                                    <template slot="tab-panel-Students">

                                    </template>
                                </NavTabs>
                            </div>
                        </div>
                        <!-- <div class="divider1 mt-2 mb-2" /></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .cls_btn {
        display: flex;
    }

    .cls_btn .login_btn {
        width: inherit;
        margin: 0px 10px;
    }

    .form-group.cl_add_topic .login_btn {
        margin: 0;
        width: auto;
    }

    .cl_input input {
        border-radius: 0;
    }

    .cl_input {
        width: 100%;
    }

    select.form-control {
        border-radius: 0;
    }

    .ac_text p {
        color: #868686;
        font-size: 16px;
    }

    .ac_text {
        padding: 18px 0;
    }

    .add_cl_q {
        padding: 0 20px;
    }

</style>
<script>
    import NavTabs from '../../components/NavTabs.vue';
    import UnitAccordian from './unit-accordian.vue';
    export default {
        components: {
            NavTabs,
            UnitAccordian
        },
        props: ['classroomDetail'],
        data() {
            return {
                tabs: ['Overview', 'Setup', 'Students'],
                initialTab: 'Overview'
            };
        }
    }

</script>
