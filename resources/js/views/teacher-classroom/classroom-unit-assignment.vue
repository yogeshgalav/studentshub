<template>
    <div>
        <classroom-header />
        <div class="card mt-5" v-for="(unit,index) in unitData" :key="index">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <accordion :title="'Unit '+unit.unit_no+': '+unit.unit_name" :aria-expanded="true"
                            tab="accordion_status_unit_active">
                            <div class="row add_cl_q">
                                <div class="col-md-12">
                                        <div class="text-grey">
                                            <p>Students will be asked to answer the following questions on this unit
                                                attempt</p>
                                        </div>
                                </div>
                            </div>
                            <div class="row add_cl_q" v-for="(question,index) in unit.descriptive_questions" :key="index">
                                    <div class="col-md-12 mt-2">
                                        <h4>Question {{index+1}}</h4>
                                    </div>
                                    <div class="cl_q_type_text">
                                        <div class="cl_q_text_box">
                                            <label class="col-form-label text-black font-size-14">Question text</label>
                                            <div class="inner-addon left-addon">
                                                <div class="cl_input">
                                                    <input type="text" :value="question.question_text" class="form-control" id="topic_title" @blur="addOrUpdateQuestion($event,unit.unit_no)">
                                                </div>

                                            </div>

                                        </div>
                                        <div class="cl_q_type_box">
                                            <label class="col-form-label text-black font-size-14">Question Type</label>
                                            <div class="cl_q_type">
                                                <select @change="addOrUpdateQuestion($event,unit.unit_no)">
                                                    <option>Short Answer
                                                    </option>
                                                    <option>Long Answer
                                                    </option>
                                                </select>

                                            </div>
                                        </div>
                                        <div class="cl_q_close">
                                            <p><i class="fa fa-times" aria-hidden="true" @click="removeQuestion($event,unit.unit_no)"></i></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <add-button name="Add Question" @submit="addQuestion(unit.unit_no)" />
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
    
    export default {
        mixins:[FormMixin],
        components: {
            Accordion,
            AddButton
        },
        data() {
            return {
                unitData: [],
            };
        },
        mounted() {
            this.getUnitDetails();
        },
        methods: {
            getUnitDetails(){
                this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/unit-assignment-details').then((resp) => {
                    this.unitData = resp.data.success.unitData;
                });
            },      
            addQuestion(unit_no) {
                let unit = this.unitData.find(node=>node.unit_no === unit_no);
                unit.descriptive_questions.push({
                    'question_text': '',
                    'answer_type': ''
                });
            },
            addOrUpdateQuestion($event,unit_no){

            },
            removeQuestion($event,unit_no){
                
            }
        }
    }

</script>
