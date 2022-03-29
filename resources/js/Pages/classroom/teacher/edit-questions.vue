<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="false"
      loader="dots"
    />
    <div class="text-grey col-md-12 pl-0">
      <p class="mt-2">
        Students will be asked to answer the following questions on this unit
        attempt
      </p>
    </div>
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
                  type="button"
                  title="Edit"
                  class="btn btn-link"
                  data-toggle="modal"
                  :data-target="'#addDailyQuestionModal'+assignmentId"
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
            v-for="(choice, index2) in question.multiple_choice"
            :key="index2"
            class="row"
          >
            <div class="col-md-9 mb-1 mt-1 ">
              <div :class="['row line-height-30', choice.is_correct ? 'bg-card-green text-white' : 'bg-card-gray', 'p-2']">
                <div class="bg-circle">
                  {{ letters[index2] }}
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
      class="mt-3 mb-2 col-md-12 pl-0"
    >
      <button
        class="btn btn-success"
        data-toggle="modal"
        :data-target="'#addDailyQuestionModal'+assignmentId"
        @click="addQuestion"
      >
        <i class="fas fa-plus" />&nbsp;&nbsp;Add Question
      </button>
    </div>
    <modal
      :ref="'addDailyQuestionModal'+assignmentId"
      :name="'addDailyQuestionModal'+assignmentId"
      :heading="(current_question_edit.id ? 'Edit' : 'Add')+' Question'"
      classes="modal-lg"
      @submit="saveQuestion"
    >
      <template slot="modalBody">
        <form>
          <div class="row">
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
                    <div v-if="!current_question_edit.id && filter_available">
                      <button
                        v-if="filter_recovery_text"
                        type="button"
                        class="btn-link"
                        @click="undoFilterOptions"
                      >
                        Undo
                      </button>
                      <button
                        v-else
                        type="button"
                        class="btn-link"
                        @click="filterOptions"
                      >
                        Filter Options
                      </button>
                    </div>
                    <span class="error">{{ formErrors('question_text') }}</span>
                  </div>
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
                  <h4>Options</h4>

                  <div class="row">
                    <div class="col-md-12 col-12">
                      <div
                        v-for="(choice,index) in current_question_edit.multiple_choice"
                        :key="index"
                        class="form-group row"
                      >
                        <div class="input-group col-12 col-md-7 mr-0">
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
                            class="form-control col-12"
                          >
                        </div>
                        <div class="form-check ml-0 mt-2 col-12 col-md-5">
                          <input
                            :id="'correctAnswer'+index"
                            v-validate="'required'"
                            :checked="choice.is_correct"
                            class="form-check-input mt-2"
                            type="radio"
                            name="correct_answer"
                            @change="setCurrectAnswer(choice)"
                          >
                          <label class="form-check-label">Mark as correct answer</label>
                          <button
                            v-if="current_question_edit.multiple_choice.length>2"
                            cla
                            type="button"
                            class="btn btn-white btn-md mt-1 ml-2"
                            @click="removeOption(index)"
                          >
                            <i class="fa fa-trash-alt" />
                          </button>
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
                        class="btn btn-sm btn-success"
                        @click="addOption()"
                      >
                        <i class="fas fa-plus" />&nbsp;&nbsp;Add Option
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </template>
    </modal>
  </div>
</template>
<style scoped>
.btn-white {
  border-radius: 0.25rem;
  border:1px solid #d2d2d2d2;
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
@media (max-width: 768px){
  .form-check{
    padding-left: 10%;
  }
}
</style>
<script>
import FormMixin from '../../../components/mixins/form-mixin.js';
import Modal from '../../../components/VueNiceModal.vue';

export default {
	components: {
		Modal
	},
	mixins: [FormMixin],
	props:['assignmentId'],
	data() {
		return {
			showLoader:false,
			filter_recovery_text:'',
			daily_questions:[],
			options: {
				height: '400px',
				overflow:scroll
			},
			avail_marks:10,
			removed_options:[],
			current_question_edit: {
				id: 0,
				question_text: '',
				marks: null,
				question_type: 'multiple_choice',
				question_order: 0,
				multiple_choice: [{
					id: 0,
					option_order: 0,
					option_text: null,
					is_correct: true,
				},
				{
					id: 1,
					option_order: 1,
					option_text: null,
					is_correct: false,
				},
				],
			},
		};
	},
	computed:{
		total_marks(){
			let total = this.daily_questions.reduce((acc, currVal) => {
				return acc + currVal.marks;
			}, 0);
			this.$emit('totalUpdate',total);
			return total;
		},
		filter_available(){
			return this.current_question_edit.question_text.match(/\n+/g);
		}
	},
	mounted(){
		this.getQuestions();
	},
	methods: {
		getQuestions() {
			this.axios
				.get('/api/classroom/' + this.$route.params[0] + '/assignment/'+this.assignmentId+'/questions')
				.then((resp) => {
					this.daily_questions =resp.data.success.daily_questions;
				});
		},
		addQuestion() {
			this.resetEditQuestion();
			this.avail_marks = this.total_marks<11 ? (10-this.total_marks) : 0;
		},
		filterOptions(){
			const text = this.current_question_edit.question_text;
			this.filter_recovery_text = text;
			let question_array = text.replace(/\n\((.)\)\s/g, '#--#').replace(/\n.\.\s/g, '#--#').split('#--#');
			if(typeof question_array[1] ==='undefined'){
				question_array = text.replace(/\n+/g,  '#--#').split('#--#');
			}
			this.current_question_edit.question_text = question_array[0];
			this.current_question_edit.multiple_choice = [];
			question_array.forEach((element, index) => {
				if(index===0){
					return true;
				}
				this.current_question_edit.multiple_choice.push({
					id:0,
					option_order: index-1,
					option_text: element,
					is_correct:false,
				});
			});
		},
		undoFilterOptions(){
			this.current_question_edit.question_text = this.filter_recovery_text;
			this.current_question_edit.multiple_choice =[{
				id:0,
				option_order: 0,
				option_text: null,
				is_correct:false,
			},
			{
				id:0,
				option_order: 1,
				option_text: null,
				is_correct:false,
			},
			];
			this.filter_recovery_text = '';
		},
		saveQuestion() {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.$emit('loader',true);
					this.axios.post('/api/classroom/update-daily-question', {
						daily_assignment_id:this.assignmentId,
						question: this.current_question_edit,
						removed_options: this.removed_options,
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
						this.$emit('loader',false);
						this.resetEditQuestion();
					});
					this.$refs['addDailyQuestionModal'+this.assignmentId].closeModal();
				}});
		},
		editQuestion(question_id) {
			this.current_question_edit = this.daily_questions.find(node => node.id === question_id);
			this.removed_options = [];
			this.avail_marks = (10 - this.daily_questions.reduce((acc, currVal) => {
				if(currVal.id === question_id){
					return acc;
				}
				return acc + currVal.marks;
			}, 0));
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
			this.removed_options=[];
			this.current_question_edit = {
				daily_assignment_id: null,
				question_text: '',
				marks: null,
				question_type: 'multiple_choice',
				question_order: 0,
				multiple_choice: [{
					id:0,
					option_order: 0,
					option_text: null,
					is_correct: true,
				},
				{
					id:0,
					option_order: 1,
					option_text: null,
					is_correct: false,
				},
				],
			};
			this.filter_recovery_text = '';
			this.errors.clear();
		},
		setCurrectAnswer(choice){
			this.current_question_edit.multiple_choice.map(node=>{
				node.is_correct = (node.option_order === choice.option_order) ? true :false;
				return node;
			});
		},
		addOption() {
			let data = this.current_question_edit.multiple_choice;
			data.push({
				id:0,
				option_order: data.length,
				option_text: null,
				is_correct: false,
			});

			this.current_question_edit.multiple_choice = data;
		},
		removeOption(index) {
			let data = this.current_question_edit.multiple_choice;
			if(data[index].id){
				this.removed_options.push(data[index].id);
			}
			data.splice(index, 1);
			this.current_question_edit.multiple_choice = data;
		},
	}
};

</script>
