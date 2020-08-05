<template>
    <div>
        <div class="card mt-5" v-for="(unit,index) in previousUnitData" :key="index">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <accordion :title="'Unit '+unit.unit_no+': '+unit.unit_name" :aria-expanded="true"
                            tab="accordion_status_unit_active">
                            <div class="row add_cl_q" v-for="(question,index) in unit.questions" :key="index">
                                    <div class="col-md-12 mt-2">
                                        <h4>Question {{index+1}}</h4>
                                    </div>
                                    <div class="cl_q_type_text">
                                        <div class="cl_q_text_box">
                                            <label class="col-form-label text-black font-size-14">Question text</label>
                                            {{question.question_text}}
                                        </div>
                                    </div>
                                    <a :href="'/classroom/'+unit.classroom_id+'/question/'+question.id">View all Answers</a>
                                </div>
                        </accordion>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Accordion from '../../../components/accordion';
    import swal from '../../../components/swal.js';
    
    export default {
        components: {
            Accordion,
        },
        props: ['previousUnitData'],
        data() {
            return {
                answers:[],
            };
        },
        mounted(){
            this.axios.get('/api/get-previous-unit-answers').then((resp)=>{
                this.answers=resp.data.success.answers;
            })
        },
        methods: {
            
        }
    }

</script>
