<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="row">
      <div class="col-md-12">
        <classroom-header />
      </div>
    </div>
    <div class="mt-2">
      <add-button
        name="Add Assignment"
        @submit="addAssignment"
      />
    </div>
    <div
      v-for="(daily,index) in dailyAssignmentData"
      :key="index"
      class="card mt-5"
    >
      <div>
        <div class="row">
          <div class="col-md-12">
            <accordion
              :title="daily.attempt_date"
              :aria-expanded="true"
              tab="accordion_status_unit_active"
            >
              <div class="row add_cl_q">
                <div class="col-md-12">
                  <div class="col-md-3 col-12 mt-3">
                    <div class="form-group pl-0">
                      <label
                        class="control-label"
                        :for="'start_date' + index"
                      >Assignment Date</label>
                      <div>
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
                          placeholder
                          @change="updateAssignment(daily)"
                        />
                      </div>

                      <div class="error">
                        {{ formErrors('attempt_date') }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row add_cl_q">
                <div class="col-md-12">
                  <div class="col-md-3 col-12">
                    <div class="form-group pl-0">
                      <label
                        class="control-label mb-1"
                        :for="'start_date' + index"
                      >Select Unit</label>
                      <select
                        v-model="daily.unit_id"
                        class="form-control"
                        @change="updateAssignment(daily)"
                      >
                        <option
                          v-for="(unit,index2) in unitList"
                          :key="index2"
                          :value="unit.id"
                        >
                          {{ 'Unit '+unit.unit_no + ':' +unit.unit_name }}
                        </option>
                      </select>
                      <div class="error">
                        {{ formErrors('unit_id') }}
                      </div>
                    </div>
                  </div>
                  <div class="text-grey col-md-12">
                    <p>
                      Students will be asked to answer the following questions on this unit
                      attempt
                    </p>
                  </div>

                  <div
                    v-for="(question,index) in daily.daily_questions"
                    :key="index"
                    class="col-md-6 border-1px ml-3 p-3 mb-3"
                  >
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-9">
                            <div class="weight-800">
                              {{ 'Question' + ' ' + (index+1) }} 
                              <button
                                title="Edit"
                                class="btn btn-link"
                                @click="editQuestion(daily.id,question.id)"
                              >
                                <i class="fa fa-edit" />
                              </button> 
                              <button
                                title="Delete"
                                class="btn btn-link p-0"
                                @click="deleteQuestion(daily.id,question.id)"
                              >
                                <i class="fa fa-trash text-danger" />
                              </button>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <button class="btn btn-white ">
                              {{ 'Marks:'+ ' ' + question.marks }}
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row mt-2">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="mb-2 weight-500">
                              {{ question.question_text }}
                            </div>
                          </div>
                        </div>

                        <div
                          v-for="(choice,index) in question.multiple_choice"
                          :key="index"
                          class="row"
                        >
                          <div class="col-md-9 mb-1 mt-1">
                            <div class="bg-gray p-2">
                              <div class="bg-circle">
                                {{ letters[index] }}
                              </div>
                              <span class="pl-2">  {{ choice.option_text }}  </span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <span
                              v-if="choice.is_correct === 1"
                              class="line-height-55"
                            >   <i class="fa fa-check-circle text-success" />  </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div
                v-if="daily.unit_id!==null && daily.attempt_date && assignmentMarks[index]!==0"
                class="mt-3 mb-2 col-md-12"
              >
                <add-button
                  name="Add Question"
                  @submit="addQuestion(daily.attempt_date)"
                />
              </div>
              
              <div
                v-if="daily.id"
                class="mt-5"
              >
                <hr>
                <button
                  class="btn btn-danger btn-md"
                  @click="deleteDailyAssignment(daily)"
                >
                  Delete Daily Assignment
                </button>
                <button
                  class="btn btn-primary btn-md"
                  @click="activateDailyAssignment(daily)"
                >
                  {{ daily.activated_at ? 'Deactivate Daily Assignment' : 'Activate Daily Assignment' }}
                </button>
              </div>
            </accordion>
          </div>
        </div>
      </div>
    </div>

    <modal
      name="addDailyQuestionModal"
      class="doubt_model model-md"
    >
      <form
        v-slimscroll="options"
        style="padding:25px;"
        @submit.prevent="saveQuestion()"
      >
        <div class="row">
          <div class="col-md-12 mt-2">
            <h4>Question</h4>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label class="control-label font-size-14">Question text</label>
              <div class="inner-addon left-addon">
                <div class="cl_input">
                  <textarea
                    id="topic_title"
                    v-model="current_question_edit.question_text"
                    v-validate="'required'"
                    class="form-control"
                    name="question_text"
                  />
                  <span class="error">{{ formErrors('question_text') }}</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label font-size-14">Question Type</label>
              <div class="cl_q_type">
                <select
                  v-model="current_question_edit.question_type"
                  v-validate="'required'"
                  class="form-control"
                  name="question_type"
                >
                  <option value="multiple_choice">
                    Multiple Choice
                  </option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="control-label font-size-14">Marks</label>
              <select
                v-model="current_question_edit.marks"
                v-validate="'required'"
                class="form-control"
                name="marks"
              >
                <option value="">
                  Select Marks
                </option>
                <option
                  v-for="(mark,index) in marks"
                  :key="index"
                  :value="mark"
                >
                  {{ mark }}
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-12">
            <span class="error">{{ formErrors('marks') }}</span>
          </div>
          <div class="col-md-12 mt-2">
            <div class="row">
              <div class="col-md-12">
                <h4>Answers</h4>

                <div class="row">
                  <div class="col-md-12">
                    <div
                      v-for="(choice,index) in current_question_edit.multiple_choice"
                      :key="index"
                      class="form-group d-flex"
                    >
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span
                            id="basic-addon1"
                            class="input-group-text"
                          ><i class="fa fa-list" /></span>
                        </div>
                        <input
                          v-model="choice.option_text"
                          v-validate="'required'"
                          type="text"
                          name="option_text"
                          class="form-control col-md-12"
                        >
                      </div>

                      <!-- <label class="contol-label col-md-2 mt-2">{{ letters[index] }} :</label> -->
                     
                      <button
                        v-if="current_question_edit.multiple_choice.length>2"
                        class="btn btn-default btn-sm ml-2 delete_btn"
                        @click="removeOption(index)"
                      >
                        <i class="fa fa-trash-alt" />
                      </button>

                      <div class="form-check ml-3 mt-2">
                        <input
                          :id="'correctAnswer'+index"
                          v-model="choice.is_correct"
                          v-validate="'required'"
                          class="form-check-input"
                          type="radio"
                          name="correct_answer"
                          :value="true"
                        >
                        <label class="form-check-label">Mark as correct answer</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <span class="error">{{ formErrors('option_text') }}</span>
                    <span class="error">{{ formErrors('correct_answer') }}</span>
                  </div>
                  <div class="col-md-12">
                    <button
                      type="button"
                      class="btn btn-success btn-lg"
                      @click="addOption()"
                    >
                      <i class="fa fa-plus" /> Add More
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-1 row text-right">
          <div class="col-md-12">
            <hr>
            <button
              type="submit"
              class="btn btn-outline-primary mb-2"
            >
              Submit
            </button>
          </div>
        </div>
      </form>
    </modal>
  </div>
</template>
<style scoped>
.delete_btn {
  padding: 0 22px 0 22px;
  font-size: 18px;
}
.btn-white {
  border-radius: 15px;
  border: 1px solid #000;
}
.border-1px  {
  border:1px solid #ccc;
}
.bg-gray {
  background-color: #eee;display: flex;
  line-height: 30px;
  
}
.bg-circle {
  border-radius: 50%;
    border: 1px solid #000;
    width: 30px;
    height: 30px;
    text-align: center;
    vertical-align: middle;
    line-height: 30px;
    font-weight: 700;
}
.line-height-55  {
  line-height: 55px;
}
</style>
<script>
import Vue from 'vue';

import FormMixin from '../../components/mixins/form-mixin.js';
import Accordion from '../../components/accordion';
import AddButton from '../../components/AddButton';
import swal from '../../components/swal.js';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: {
		Accordion,
		AddButton,
		DatePicker,
		ClassroomHeader
	},
	mixins: [FormMixin],
	data() {
		return {
			showLoader:true,
			dailyAssignmentData: {},
			current_question_edit: {
				id:0,
				daily_assignment_id: null,
				question_text: null,
				marks: '',
				question_type: 'multiple_choice',
				question_order: 0,
				multiple_choice: [
					{
						id:0,
						option_text: null,
						is_correct: false,
					},
					{
						id:0,
						option_text: null,
						is_correct: false,
					},
				],
			},
			options: {
				height: '400px',
			},
			marks: 10,
		};
	},
	computed: {
		latestDate() {
			return new Date();
		},
		classroomDetail() {
			return this.$store.state.classroom.classroomDetail;
		},
		letters() {
			let letters = [];
			for (let i = 'A'.charCodeAt(0); i <= 'Z'.charCodeAt(0); i++) {
				letters.push(String.fromCharCode([i]));
			}
			return letters;
		},
		assignmentMarks(){
			return this.dailyAssignmentData.map(node=>{
				if(!node.daily_questions){
					return 10;
				}
				return (10 - node.daily_questions.reduce((acc,currVal)=>{
					return acc+currVal.marks;
				},0));
			});
		}
	},
	mounted() {
		this.getDailyDetails();
	},
	methods: {
		getDailyDetails() {
			this.axios
				.get('/api/classroom/' + this.$route.params.classroomId + '/daily-questions')
				.then((resp) => {
					this.unitList = resp.data.success.unitList;
					this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
					this.showLoader=false;
				});
		},
		addAssignment() {
			this.dailyAssignmentData.unshift({
				unit_id: '',
				attempt_date: '',
				daily_questions: [],
			});
		},
		updateAssignment(daily) {
			this.form_errors = [];
			if (!daily.unit_id || !daily.attempt_date) {
				return false;
			}

			this.axios
				.post('/api/update-daily-assignment', {
					assignment_id: daily.id,
					unit_id: daily.unit_id,
					attempt_date: daily.attempt_date,
				})
				.then((resp) => {
					this.current_question_edit.daily_assignment_id =
            resp.data.success.assignment.id;
					let dailyIndex=this.dailyAssignmentData.findIndex(node=>node.attempt_date===daily.attempt_date);
					this.dailyAssignmentData[dailyIndex]['id']=resp.data.success.assignment.id;
				})
				.catch((error) => {
          
				});
		},
		deleteDailyAssignment(daily) {
			swal
				.confirmDialog(
					'Are you sure you want to Delete Assignment for date ' +
            daily.attempt_date +
            '?'
				)
				.then((result) => {
					if (result.value) {
						this.axios.post('/api/delete-daily-assignment', {
							daily_assignment_id: daily.id,
						}).then(()=>{
							let assignmentIndex = this.dailyAssignmentData.findIndex(
								(node) => node.id === daily.id
							);
							this.dailyAssignmentData.splice(assignmentIndex,1);
						});
					}
				});
		},
		activateDailyAssignment(daily) {
			let total_marks=daily.daily_questions.reduce((acc,currVal)=>{
				return acc+currVal.marks;
			},0);
			if(total_marks!==10){
				swal
					.infoDialog('Total marks for Daily Assignment should be 10.');
				return false;
			}
			swal
				.confirmDialog(
					'Are you sure you want to Activate Assignment for date ' +
            daily.attempt_date +
            '?'
				)
				.then((result) => {
					if (result.value) {
						this.axios.post('/api/activate-daily-assignment', {
							daily_assignment_id: daily.id,
							status:daily.activated_at ? 'deactivate' : 'activate' 
						}).then(()=>{
							let assignment = this.dailyAssignmentData.find(
								(node) => node.id === daily.id
							);
							assignment.activated_at = new Date();
						});
					}
				});
		},
		addQuestion(attempt_date) {
			let assignment = this.dailyAssignmentData.find(
				(node) => node.attempt_date === attempt_date
			);
			if (assignment && assignment.id) {
				this.current_question_edit.daily_assignment_id = assignment.id;
				this.marks= (10 - assignment.daily_questions.reduce((acc,currVal)=>{
					return acc+currVal.marks;
				},0));
				// this.current_question_edit.question_order = assignment.questions.length;
			}
			this.$modal.show('addDailyQuestionModal');
		},
		saveQuestion() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.axios.post('/api/classroom/update-daily-question', {
						question: this.current_question_edit,
					}).then((resp)=>{
						const question = resp.data.success.question;
						let assignmentIndex = this.dailyAssignmentData.findIndex(
							(node) => node.id === question.daily_assignment_id
						);
						if(!this.current_question_edit.id){
							this.dailyAssignmentData[assignmentIndex].daily_questions.push(question);
						}else{
							this.dailyAssignmentData[assignmentIndex].daily_questions.map(node=>{
								if(node.id===question.id){
									return question;
								}
								return node;
							});
						}
						this.resetEditQuestion();
					});

					this.$modal.hide('addDailyQuestionModal');
				}});
                    
		},
		editQuestion(assignment_id,question_id){
			let assignment = this.dailyAssignmentData.find(
				(node) => node.id === assignment_id
			);
			let question_to_edit = assignment.daily_questions.find(node=>node.id===question_id);
			this.marks= (10 - assignment.daily_questions.reduce((acc,currVal)=>{
				if(currVal.id===question_id){
					return acc;
				}
				return acc+currVal.marks;
			},0));
			this.current_question_edit =Object.assign(question_to_edit,{});
			// this.current_question_edit.question_order = assignment.questions.length;
			this.$modal.show('addDailyQuestionModal');
		},
		deleteQuestion(assignment_id,question_id){
			this.axios.post('/api/classroom/delete-daily-question',{
				classroom_id:this.classroomDetail.id,
				question_id:question_id,
			}).then((resp)=>{
				let assignment = this.dailyAssignmentData.find(
					(node) => node.id === assignment_id
				);
				let questionIndex = assignment.daily_questions.findIndex(node=>node.id===question_id);
				assignment.daily_questions.splice(questionIndex,1);

			});
		},
		resetEditQuestion(){
			this.current_question_edit= {
				daily_assignment_id: null,
				question_text: null,
				marks: '',
				question_type: 'multiple_choice',
				question_order: 0,
				multiple_choice: [
					{
						option_text: null,
						is_correct: false,
					},
					{
						option_text: null,
						is_correct: false,
					},
				],
			};
		},
		addOption() {
			let data = this.current_question_edit.multiple_choice;
			data.push({
				text: null,
				answer: false,
			});

			this.current_question_edit.multiple_choice = data;
		},
		removeOption(index) {
			let data = this.current_question_edit.multiple_choice;
			data.splice(index, 1);

			this.current_question_edit.multiple_choice = data;
		},
	},
};
</script>
