<template>
    <div>
        <div class="card mt-5">
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <accordion :title="'Unit '+currentUnitData.unit_no+': '+currentUnitData.unit_name" :aria-expanded="true"
                            tab="accordion_status_unit_active">
                            <div class="row add_cl_q">
                                <div class="col-md-12">
                                        <div class="text-grey">
                                            <p>Students will be asked to answer the following questions on this unit
                                                attempt</p>
                                        </div>
                                </div>
                            </div>
                            <div class="row add_cl_q" v-for="(question,index) in currentUnitData.questions" :key="index">
                                    <div class="col-md-12 mt-2">
                                        <h4>Question {{index+1}}</h4>
                                    </div>
                                    <div class="cl_q_type_text">
                                        <div class="cl_q_text_box">
                                            <label class="col-form-label text-black font-size-14">Question text</label>
                                            {{question.question_text}}
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5">
                                    <hr />
                                    <a href="#" class="btn btn-primary btn-lg" > Attempt Unit
                                    </a>
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
        props: ['currentUnitData'],
        data() {
            return {
            };
        },
        methods: {
            
        }
    }

</script>
