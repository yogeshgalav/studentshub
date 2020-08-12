<template>
    <div>
        <div class="mt-2">
            <add-button name="Add Assignment" @submit="addAssignment" />
        </div>
        <div class="card mt-5" v-for="(daily,index) in dailyData" :key="index">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <accordion :title="daily.attempt_date" :aria-expanded="true"
                            tab="accordion_status_unit_active">
                            <div class="row add_cl_q">
                                <div class="col-md-3 col-12">
                                    <div class="form-group pl-0">
                                        <label class="text-black mb-1"
                                            :for="'start_date' + index">{{ 'Assignment Date' }}</label>
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
                                                    @change="updateAssignmentDate(daily)"
                                                  />
                                                <span class="error">{{ formErrors('start_date') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row add_cl_q">
                                <div class="col-md-3 col-12">
                                    <div class="form-group pl-0">
                                        <label class="text-black mb-1"
                                            :for="'start_date' + index">{{ 'Assignment Date' }}</label>
                                                  <select v-model="daily.selected_unit" @change="updateAssignmentDate(daily)">
                                                      <option v-for="(unit,index2) in unitList" :key="index2" :value="unit.unit_no">
                                                          {{ 'Unit '+unit.unit_no + ':' +unit.unit_name}}
                                                      </option>
                                                  </select>
                                                <span class="error">{{ formErrors('start_date') }}</span>
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
                            <div class="row add_cl_q" v-for="(question,index) in daily.questions" :key="index">
                                    <div class="col-md-12 mt-2">
                                        <h4>Question {{index+1}}</h4>
                                    </div>
                                    <div class="cl_q_type_text">
                                        <div class="cl_q_text_box">
                                            <label class="col-form-label text-black font-size-14">Question text</label>
                                            <div class="inner-addon left-addon">
                                                <div class="cl_input">
                                                    <input type="text" :value="question.question_text" class="form-control" id="topic_title">
                                                </div>

                                            </div>

                                        </div>
                                        <div class="cl_q_type_box">
                                            <label class="col-form-label text-black font-size-14">Question Type</label>
                                            <div class="cl_q_type">
                                                <select>
                                                    <option>Multiple Choice
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-4" v-for="(choice,index) in question.multiple_choice" :key="index">
                                                <input type="text" v-model="choice.text">
                                            </div>
                                            <div class="mt-2">
                                                <add-button name="Add Option" @submit="addOption(question.id)" />
                                            </div>
                                        </div>
                                        <div class="cl_q_close">
                                            <p><i class="fa fa-times" aria-hidden="true"></i></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2" v-if="daily.selected_unit!==null && daily.attempt_date">
                                    <add-button name="Add Question" @submit="addQuestion(daily.attempt_date)" />
                                </div>
                        </accordion>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
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
                dailyData: [],
                assignment_date:'',
            };
        },
        computed:{
            latestDate(){
                return new Date();
            },
            classroomDetail(){
                return this.$store.state.classroom.classroomDetail;
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
                    this.dailyData = resp.data.success.dailyData
                });
            },
            addAssignment() {
                this.dailyData.unshift({
                    'selected_unit': '',
                    'attempt_date': '',
                    'questions': []
                });
            },
            deleteAssignment(attempt_date) {
                swal
				.confirmDialog('Are you sure you want to Delete Assignment for date '+attempt_date+'?')
				.then(result => {
					if (result.value) {
						this.axios.post('/api/classroom/'+this.classroomDetail.id+'/delete-daily-assignment',{
                            attempt_date: attempt_date
                        });
					}
				});
            },
            addQuestion(attempt_date) {
                let daily = this.dailyData.find(node=>node.attempt_date === attempt_date);
                daily.questions.push({
                    'question_text': '',
                    'answer_type': ''
                });
            },
            updateAssignmentDate(daily) {
                if(!daily.selected_unit || !daily.attempt_date){
                    return false;
                }
                //call api and update field
                daily.questions.forEach(question=>{
                    if(question.id===0){
                        return false;
                    }
                    this.axios.post('/api/classroom/'+this.classroomDetail.id+'/update-daily-questions',{
                        question_id: question.id,
                        unit_no: daily.selected_unit,
                        attempt_date: daily.attempt_date
                    });
                })
            }

        }
    }

</script>
