<template>
  <div>
    <div
      v-for="(question,index) in daily_questions"
      :key="index"
      class="col-md-6 border-bottom-1px ml-3 p-3 mb-3"
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
                  @click="editQuestion(question.id)"
                >
                  <i class="fa fa-edit" />
                </button> 
                <button
                  title="Delete"
                  class="btn btn-link p-0"
                  @click="deleteQuestion(question.id)"
                >
                  <i class="fa fa-trash text-danger" />
                </button>
              </div>
            </div>
            <div class="col-md-3">
              <label class="btn btn-white ">
                {{ 'Marks:'+ ' ' + question.marks }}
              </label>
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
            <div class="col-md-9 mb-1 mt-1 ">
              <div :class="['row line-height-30', choice.option_order === question.correct_answer ? 'bg-card-green text-white' : 'bg-card-gray', 'p-2']">
                <div :class="[choice.option_order === question.correct_answer ? 'bg-circle-white' : 'bg-circle']">
                  {{ letters[index] }}
                </div>
                <span class="pl-2">  {{ choice.option_text }}  </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
        
    <div
      v-if="assignmentId && total_marks<10"
      class="mt-3 mb-2 col-md-12"
    >
      <add-button
        name="Add Question"
        size="md"
        @submit="addQuestion"
      />
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
                  v-for="mark in avail_marks"
                  :key="mark"
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
                    <add-button
                      type="button"
                      size="sm"
                      name="Add Option"
                      @submit="addOption()"
                    />
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

.border-bottom-1px  {
  border-bottom:1px dashed #ccc !important;
}
.line-height-30 {
   line-height: 30px !important;
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
.bg-circle-white {
   border-radius: 50%;
    border: 1px solid black;
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
import AddButton from '../../../components/AddButton';
import FormMixin from '../../../components/mixins/form-mixin.js';

export default {
	components: {
		AddButton,
	},
	mixins: [FormMixin],
	props:['assignmentId','dailyQuestions'],
	data() {
		return {
			daily_questions:[],
			options: {
				height: '400px',
			},
			avail_marks:10,
			current_question_edit: {
				id: 0,
				question_text: null,
				marks: null,
				question_type: 'multiple_choice',
				question_order: 0,
				multiple_choice: [{
					id: 0,
					option_text: null,
					is_correct: false,
				},
				{
					id: 0,
					option_text: null,
					is_correct: false,
				},
				],
			},
		};
	},
	computed:{
		total_marks(){
			return this.daily_questions.reduce((acc, currVal) => {
				return acc + currVal.marks;
			}, 0);
		}
	},
	mounted(){
		this.daily_questions =this.dailyQuestions ? this.dailyQuestions :[];
	},
	methods: {
		addQuestion() {
			this.resetEditQuestion();
			this.avail_marks = this.total_marks<11 ? (10-this.total_marks) : 0;
			this.$modal.show('addDailyQuestionModal');
		},
		saveQuestion() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.axios.post('/api/classroom/update-daily-question', {
						daily_assignment_id:this.assignmentId,
						question: this.current_question_edit,
					}).then((resp)=>{
						const question = resp.data.success.question;
						if(!this.current_question_edit.id){
							this.daily_questions.push(question);
						}else{
							this.daily_questions.map(node=>{
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
		editQuestion(question_id) {
			this.current_question_edit = this.daily_questions.find(node => node.id === question_id);
			this.avail_marks = (10 - this.daily_questions.reduce((acc, currVal) => {
				if(currVal.id === question_id){
					return acc;
				}
				return acc + currVal.marks;
			}, 0));
			this.$modal.show('addDailyQuestionModal');
		},
		deleteQuestion(question_id) {
			this.axios.post('/api/classroom/delete-daily-question', {
				question_id: question_id,
			}).then((resp) => {
				let questionIndex=this.daily_questions.findIndex(node => node.id === question_id);
				this.daily_questions.splice(questionIndex, 1);

			});
		},
		resetEditQuestion() {
			this.current_question_edit = {
				daily_assignment_id: null,
				question_text: null,
				marks: null,
				question_type: 'multiple_choice',
				question_order: 0,
				multiple_choice: [{
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
	}
};

</script>
