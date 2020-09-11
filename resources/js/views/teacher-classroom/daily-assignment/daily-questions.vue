<template>
    <div>
        <div v-for="(question,index) in daily_questions" :key="index" class="col-md-12">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="weight-800">{{'Question' + (index+1)}}
                                <button title="Edit" class="btn btn-link" @click="editQuestion(question.id)"><i
                                        class="fa fa-edit"></i> </button>
                                <button title="Delete" class="btn btn-link p-0"
                                    @click="deleteQuestion(question.id)"><i
                                        class="fa fa-trash text-danger"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-success">{{'Marks'+ ' ' + question.marks}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <hr class="mt-0" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-2 weight-800">{{question.question_text}}</div>
                        </div>
                    </div>

                    <div class="row" v-for="(choice,index) in question.multiple_choice" :key="index">
                        <div class="col-md-3">{{'Option ' + letters[index]}}</div>
                        <div class="col-md-3">{{choice.option_text}}</div>
                        <div class="col-md-1" v-if="choice.is_correct === 1"><i
                                class="fa fa-check-circle text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-3 mb-2 col-md-12" v-if="assignmentId && total_marks!==0">
            <add-button name="Add Question" @submit="addQuestion" />
        </div>
        <modal name="addDailyQuestionModal" class="doubt_model model-md">
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
                                    <input type="text" v-model="current_question_edit.question_text"
                                        class="form-control" id="topic_title" />
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
                                <option :value="mark" v-for="(mark,index) in total_marks" :key="index">{{ mark }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Answers</h4>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group d-flex"
                                            v-for="(choice,index) in current_question_edit.multiple_choice"
                                            :key="index">
                                            <label class="contol-label col-md-2 mt-2">{{ letters[index] }} :</label>
                                            <input type="text" class="form-control col-md-10"
                                                v-model="choice.option_text" />
                                            <button class="btn btn-danger btn-sm ml-2 delete_btn"
                                                v-if="current_question_edit.multiple_choice.length>2"
                                                @click="removeOption(index)">
                                                <i class="fa fa-times"></i>
                                            </button>

                                            <div class="form-check ml-3 mt-2">
                                                <input class="form-check-input" type="radio" name="correctAnswer"
                                                    v-model="choice.is_correct" :id="'correctAnswer'+index"
                                                    :value="true" />
                                                <label class="form-check-label">Mark as correct answer</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success btn-lg" @click="addOption()">
                                            <i class="fa fa-plus"></i> Add More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-1 row text-right">
                    <div class="col-md-12">
                        <hr />
                        <button type="submit" class="btn btn-outline-primary mb-2">Submit</button>
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>
<script>
import AddButton from "../../../components/AddButton";

    export default {
        props:['assignmentId','dailyQuestions'],
        components: {
            AddButton,
        },
        data() {
            return {
                daily_questions:[],
                options: {
                    height: "400px",
                },
                current_question_edit: {
                    id: 0,
                    question_text: null,
                    marks: null,
                    question_type: "multiple_choice",
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
            letters() {
                let letters = [];
                for (let i = "A".charCodeAt(0); i <= "Z".charCodeAt(0); i++) {
                    letters.push(String.fromCharCode([i]));
                }
                return letters;
            },
            total_marks(){
                let marks = (10- this.daily_questions.reduce((acc, currVal) => {
                                    return acc + currVal.marks;
                                }, 0));
                                console.log(marks,'marks')
                if(this.current_question_edit.id){
                    marks = marks + this.current_question_edit.marks;
                    console.log(this.current_question_edit.marks,marks);
                }

                return marks; 
            }
        },
        mounted(){
            this.daily_questions =this.dailyQuestions
        },
        methods: {
            addQuestion() {
                this.resetEditQuestion();
                this.$modal.show("addDailyQuestionModal");
            },
            saveQuestion() {
                let question = this.current_question_edit 
                this.axios.post("/api/classroom/update-daily-question", {
                    daily_assignment_id:this.assignmentId,
                    question
                }).then((resp) => {
                    question.id = resp.data.success.question_id;
                    if(!this.current_question_edit.id){
                        this.daily_questions.push(question);
                    }
                    this.resetEditQuestion();
                });

                this.$modal.hide("addDailyQuestionModal");
            },
            editQuestion(question_id) {
                this.current_question_edit = this.daily_questions.find(node => node.id === question_id);
                this.$modal.show("addDailyQuestionModal");
            },
            deleteQuestion(question_id) {
                this.axios.post('/api/classroom/delete-daily-question', {
                    question_id: question_id,
                }).then((resp) => {
                    this.daily_questions.findIndex(node => node.id === question_id);
                    this.daily_questions.splice(questionIndex, 1);

                })
            },
            resetEditQuestion() {
                this.current_question_edit = {
                    daily_assignment_id: null,
                    question_text: null,
                    marks: null,
                    question_type: "multiple_choice",
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
    }

</script>
