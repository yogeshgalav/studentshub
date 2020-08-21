<template>
    <div>
        <div class="mt-2">
            <add-button name="Add Assignment" @submit="addAssignment" />
        </div>
        <div class="card mt-5" v-for="(daily,index) in dailyAssignmentData" :key="index">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <accordion :title="daily.attempt_date" :aria-expanded="true"
                            tab="accordion_status_unit_active">
                            <div class="row add_cl_q">
                               <div class="col-md-12">
                                    <div class="col-md-3 col-12 mt-3">
                                    <div class="form-group pl-0">
                                        <label class="control-label"
                                            :for="'start_date' + index">Assignment Date</label>
                                                  <date-picker
                                                    id="start_date_create"
                                                    ref="start_date"
                                                    v-model="daily.attempt_date"
                                                    v-validate="'required'"
                                                    name="start_date"
                                                    value-type="format"
                                                    :typeable="true"
                                                    :type="'date'"
                                                    :format="'YYYY-MM-DD'"
                                                    :lang="'en'"
                                                    :input-attr="{id: 'start_date_input'}"
                                                    placeholder=""
                                                    @change="updateAssignment(daily)"
                                                  />
                                                <div class="error">{{ formErrors('attempt_date') }}</div>
                                    </div>
                                </div>
                               </div>
                            </div>
                            <div class="row add_cl_q">
                               <div class="col-md-12">
                                    <div class="col-md-3 col-12">
                                    <div class="form-group pl-0">
                                        <label class="control-label mb-1"
                                            :for="'start_date' + index">Select Unit</label>
                                                  <select v-model="daily.unit_id" class="form-control" @change="updateAssignment(daily)">
                                                      <option v-for="(unit,index2) in unitList" :key="index2" :value="unit.id">
                                                          {{ 'Unit '+unit.unit_no + ':' +unit.unit_name}}
                                                      </option>
                                                  </select>
                                                <div class="error">{{ formErrors('unit_id') }}</div>
                                    </div>
                                </div>
                               </div>
                            </div>
                            <div class="row add_cl_q">
                                <div class="col-md-12">
                                        <div class="text-grey">
                                            <p>Students will be asked to answer the following questions on this unit
                                                attempt</p>
                                        </div>
                                </div>
                            </div>
                                <div class="mt-2" v-if="daily.unit_id!==null && daily.attempt_date">
                                    <add-button name="Add Question" @submit="addQuestion(daily.attempt_date)" />
                                </div>
                        </accordion>
                    </div>
                </div>
            </div>
        </div>

        <modal  name="addDailyQuestionModal" class="doubt_model">
            <form @submit.prevent="saveQuestion()" style="padding:25px;" v-slimscroll="options">
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <h4>Question</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label font-size-14">Question text</label>
                            <div class="inner-addon left-addon">
                                <div class="cl_input">
                                    <input type="text" v-model="current_question_edit.question_text" class="form-control" id="topic_title">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label font-size-14">Question Type</label>
                            <div class="cl_q_type">
                                <select class="form-control" v-model="current_question_edit.question_type">
                                    <option value="multiple_choice">Multiple Choice</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label font-size-14">Marks</label>
                            <select class="form-control" name="marks" v-model="current_question_edit.marks">
                                <option :value="mark" v-for="(mark,index) in marks" :key="index">{{ mark }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Answers</h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group d-flex" v-for="(choice,index) in current_question_edit.multiple_choice" :key="index">
                                            <label class="contol-label col-md-2 mt-2">{{ letters[index] }} : </label>
                                            <input type="text" class="form-control col-md-10" v-model="choice.text">
                                            <button class="btn btn-danger btn-sm ml-2" v-if="current_question_edit.multiple_choice.length>2" @click="removeAnswer(index)">
                                                <i class="fa fa-times"></i>
                                            </button>

                                            <div class="form-check ml-3 mt-2">
                                                <input class="form-check-input" type="radio" name="correctAnswer" v-model="choice.answer" :id="'correctAnswer'+index" value="true">
                                                <label class="form-check-label">
                                                    Mark as correct answer
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success btn-sm" @click="addAnswer()">
                                            <i class="fa fa-plus"></i> Add More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-3 row text-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>
<script>
    import Vue from 'vue';

    import FormMixin from '../../components/mixins/form-mixin.js';
    import Accordion from '../../components/accordion';
    import AddButton from '../../components/AddButton';
    import swal from '../../components/swal.js';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        mixins:[FormMixin],
        components: {
            Accordion,
            AddButton,
            DatePicker
        },
        data() {
            return {
                dailyAssignmentData: {},
                current_question_edit:{
                    assignment_id:null,
                    question_text:null,
                    marks:null,
                    question_type:"multiple_choice",
                    question_order:0,
                    multiple_choice:[{
                        text:null,
                        answer:false,
                    },{
                        text:null,
                        answer:false,
                    }]
                
                },
                options:{
                    height:"400px"
                },
                marks:10
            };
        },
        computed:{
            latestDate(){
                return new Date();
            },
            classroomDetail(){
                return this.$store.state.classroom.classroomDetail;
            },
            letters() {
                let letters = []
                for(let i = "A".charCodeAt(0); i <= "Z".charCodeAt(0); i++) {letters.push(String.fromCharCode([i]))}
                return letters
            }
        },
        mounted() {
            if(!this.classroomDetail.id){
                this.$store.dispatch('classroom/getClassroomDetail',this.$route.params.classroomId).then(()=>{
                    this.getDailyDetails();
                });
            }else{
                this.getDailyDetails();
            }
        },
        methods: {
            getDailyDetails(){
                this.axios.get('/api/classroom/' + this.classroomDetail.id + '/daily-questions').then((resp) => {
                    this.unitList = resp.data.success.unitList
                    this.dailyAssignmentData = resp.data.success.unitList.reduce((acc,currVal)=>acc.concat(currVal.daily_assignment),[]);
                });
            },
            addAssignment() {
                this.dailyAssignmentData.unshift({
                    'unit_id': '',
                    'attempt_date': '',
                    'questions': []
                });
            },
            updateAssignment(daily) {
                this.form_errors = [];
                if(!daily.unit_id || !daily.attempt_date){
                    return false;
                }

                this.axios.post('/api/update-daily-assignment',{
                    unit_id: daily.unit_id,
                    attempt_date: daily.attempt_date
                }).then((res) => {
                    this.current_question_edit.assignment_id=resp.data.success.assignment.id;
                }).catch((error) => {
                    if(typeof error.response.data.errors == 'object') {
                        this.form_errors = error.response.data.errors;
                    }
                });
            },
            deleteAssignment(attempt_date) {
                swal
				.confirmDialog('Are you sure you want to Delete Assignment for date '+attempt_date+'?')
				.then(result => {
					if (result.value) {
						this.axios.post('/api/delete-daily-assignment',{
                            attempt_date: attempt_date
                        });
					}
				});
            },
            addQuestion(attempt_date) {
                let assignment = this.dailyAssignmentData.find(node=>node.attempt_date===attempt_date);
                if(assignment && assignment.id){
                    this.current_question_edit.assignment_id = assignment.id;
                    this.current_question_edit.question_order = assignment.questions.length;
                }
                this.$modal.show('addDailyQuestionModal');
            },
            saveQuestion() {
                this.axios.post('/api/update-daily-question',{
                    question:this.current_question_edit
                });
                this.$modal.hide('addDailyQuestionModal');
            },
            addAnswer() {
                let data = this.current_question_edit.multiple_choice;
                data.push({
                    text:null,
                    answer:false,
                });

                this.current_question_edit.multiple_choice = data;
            },
            removeAnswer(index) {
                let data = this.current_question_edit.multiple_choice;
                data.splice(index, 1);

                this.current_question_edit.multiple_choice = data;
            }
        }
    }

</script>
