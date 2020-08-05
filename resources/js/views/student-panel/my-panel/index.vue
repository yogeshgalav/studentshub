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
                                    <template slot="tab-heading-unit-attempt">
                                        {{ 'Unit Attempt' }}
                                    </template>
                                    <template slot="tab-panel-unit-attempt">
                                        <current-unit :current-unit-data="currentUnitData" v-if="currentUnitData"/>
                                        <p v-if="!currentUnitData">Currently there is no unit activated in this classroom.</p>
                                    </template>
                                    <template slot="tab-heading-previous-units">
                                        {{ 'Completed Units' }}
                                    </template>
                                    <template slot="tab-panel-previous-units">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <previous-unit-accordians :previous-unit-data="previousUnitData" />
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
    import NavTabs from '../../../components/NavTabs.vue';
    import CurrentUnit from './current-unit.vue';
    import PreviousUnitAccordians from './previous-unit-accordians.vue';
    export default {
        components: {
            NavTabs,
            CurrentUnit,
            PreviousUnitAccordians
        },
        props: ['classroomDetail'],
        data() {
            return {
                tabs: ['unit-attempt','previous-units','classmates'],
                initialTab: 'unit-attempt',
                currentUnitData:[],
                previousUnitData:[]
            };
        },
        mounted() {
            this.axios.get('/api/classroom/' + this.classroomDetail.id + '/unit-details').then((resp) => {
                let unitData = resp.data.success.unitData;
                let activated_unit = this.classroomDetail.activated_unit;
                this.currentUnitData = unitData.find(node => activated_unit === node.unit_no);
                this.previousUnitData = unitData.filter(node => node.deactivated_at !== null);
            });
        },
        
    }

</script>
