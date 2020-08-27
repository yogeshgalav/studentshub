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
                                
                                <div class="mt-5">
                                    <hr />
                                    <button class="btn btn-danger btn-md" @click="deleteUnit(unit.unit_no)"> Delete Unit Assignment
                                    </button>
                                    <button class="btn btn-primary btn-md" @click="activateUnit(unit.unit_no)">{{ activated_unit===unit.unit_no ? 'Deactivate Unit Assignment' : 'Activate Unit Assignment'}}
                                    </button>
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
    import ClassroomHeader from '../../components/ClassroomHeader';

    export default {
        mixins:[FormMixin],
        components: {
            Accordion,
            AddButton,
            ClassroomHeader
        },
        data() {
            return {
                unitData: [],
                activated_unit:null,
            };
        },
        computed:{  
            classroomDetail(){
                return this.$store.state.classroom.classroomDetail;
            }
        },
        mounted() {
            this.getUnitDetails();
        },
        methods: {
            getUnitDetails(){
                this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/unit-assignment-details').then((resp) => {
                    this.unitData = resp.data.success.unitData;
                    this.activate_unit=this.classroomDetail.activated_unit;
                });
            },      
            activateUnit(unit_no) {
                let activation_text='';
                if(this.activated_unit===unit_no){
                    activation_text='Are you sure you want to Deactivate Unit '+unit_no;
                }else{
                    activation_text='Are you sure you want to Activate Unit '+unit_no;
                    activation_text += (this.activated_unit ? 'and Deactivate Unit '+this.activated_unit : '');
                }
                activation_text += ' ?';

                swal
				.confirmDialog(activation_text)
				.then(result => {
					if (result.value) {
						this.axios.post('/api/classroom/'+this.classroomDetail.id+'/activate-unit',{
                            unit_no: unit_no
                        }).then((resp)=>{
                            this.activated_unit = resp.data.success.activated_unit;
                        });
					}
				});
            },
            deleteUnit(unit_no) {
                swal
				.confirmDialog('Are you sure you want to Delete Unit '+unit_no+'?')
				.then(result => {
					if (result.value) {
						this.axios.post('/api/classroom/'+this.classroomDetail.id+'/delete-unit',{
                            unit_no: unit_no
                        });
                        
                        let deleteIndex = this.unitData.findIndex(node=>node.unit_no===unit_no);
                        this.unitData.slice(deleteIndex,1);
					}
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
