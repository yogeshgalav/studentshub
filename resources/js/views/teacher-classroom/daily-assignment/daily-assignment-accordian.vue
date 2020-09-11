<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <accordion :title="daily.attempt_date" :aria-expanded="true" tab="accordion_status_unit_active">
                    <div class="row add_cl_q">
                        <div class="col-md-12">
                            <div class="col-md-3 col-12 mt-3">
                                <div class="form-group pl-0">
                                    <label class="control-label" :for="'start_date'">Assignment Date</label>
                                    <div>
                                        <date-picker id="start_date_create" ref="start_date"
                                            v-model="daily.attempt_date" v-validate="'required'" name="start_date"
                                            value-type="format" :typeable="true" :type="'date'" :format="'YYYY-MM-DD'"
                                            :lang="'en'" :input-attr="{id: 'start_date_input'}" placeholder
                                            @change="updateAssignment(daily)" />
                                    </div>

                                    <div class="error">{{ formErrors('attempt_date') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row add_cl_q">
                        <div class="col-md-12">
                            <div class="col-md-3 col-12">
                                <div class="form-group pl-0">
                                    <label class="control-label mb-1" :for="'start_date'">Select Unit</label>
                                    <select v-model="daily.unit_id" class="form-control"
                                        @change="updateAssignment(daily)">
                                        <option v-for="(unit,index2) in unitList" :key="index2" :value="unit.id">
                                            {{ 'Unit '+unit.unit_no + ':' +unit.unit_name}}</option>
                                    </select>
                                    <div class="error">{{ formErrors('unit_id') }}</div>
                                </div>
                            </div>
                            <div class="text-grey col-md-12">
                                <p>
                                    Students will be asked to answer the following questions on this unit
                                    attempt
                                </p>
                            </div>

                            <daily-questions :daily-questions="daily.daily_questions" :assignment-id="daily.id"></daily-questions>
                        </div>
                    </div>

                    <div class="mt-5" v-if="daily.id">
                        <hr />
                        <button class="btn btn-danger btn-md" @click="deleteDailyAssignment(daily)"> Delete Daily
                            Assignment
                        </button>
                        <button class="btn btn-primary btn-md"
                            @click="activateDailyAssignment(daily)">{{ daily.activated_at ? 'Deactivate Daily Assignment' : 'Activate Daily Assignment'}}
                        </button>
                    </div>
                </accordion>
            </div>
        </div>
    </div>
</template>
<script>
    import FormMixin from "../../../components/mixins/form-mixin.js";
    import Accordion from "../../../components/accordion";
    import AddButton from "../../../components/AddButton";
    import swal from "../../../components/swal.js";
    import DailyQuestions from "./daily-questions";
    import DatePicker from "vue2-datepicker";
    import "vue2-datepicker/index.css";
    export default {
        props: ['assignment','unitList'],
        mixins: [FormMixin],
        components: {
            Accordion,
            AddButton,
            DatePicker,
            DailyQuestions
        },
        data() {
            return {
                daily: this.assignment,
            };
        },
        methods: {
            updateAssignment(daily) {
                this.form_errors = [];
                if (!daily.unit_id || !daily.attempt_date) {
                    return false;
                }

                this.axios
                    .post("/api/update-daily-assignment", {
                        assignment_id: daily.id,
                        unit_id: daily.unit_id,
                        attempt_date: daily.attempt_date,
                    })
                    .then((resp) => {
                        this.daily = resp.data.success.assignment;            
                        this.daily['daily_questions']=[];

                    })
                    .catch((error) => {

                    });
            },
            
    deleteDailyAssignment() {
      swal
        .confirmDialog(
          "Are you sure you want to Delete Assignment for date " +
            this.daily.attempt_date +
            "?"
        )
        .then((result) => {
          if (result.value) {
            this.axios.post("/api/delete-daily-assignment", {
              daily_assignment_id: this.daily.id,
            }).then(()=>{
              this.$emit('deleteAssignment');
            });
          }
        });
    },
            activateDailyAssignment() {
                let total_marks = this.daily.daily_questions.reduce((acc, currVal) => {
                    return acc + currVal.marks;
                }, 0);
                if (total_marks !== 10) {
                    swal
                        .infoDialog("Total marks for Daily Assignment should be 10.");
                    return false;
                }
                swal
                    .confirmDialog(
                        "Are you sure you want to Activate Assignment for date " +
                        this.daily.attempt_date +
                        "?"
                    )
                    .then((result) => {
                        if (result.value) {
                            this.axios.post("/api/activate-daily-assignment", {
                                daily_assignment_id: this.daily.id,
                                status: daily.activated_at ? 'deactivate' : 'activate'
                            }).then(() => {
                                this.daily.activated_at = new Date();
                            });
                        }
                    });
            },
        }
    }

</script>
