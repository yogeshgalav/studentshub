<template>
<div>
    <div class="mt-2">
        <add-button name="Add Unit"/>
    </div>
    <div class="card mt-5">
        <div>
            <div class="row">
                <div class="col-md-12">
                    <accordion title="Reflection Question" :aria-expanded="true" tab="accordion_status_unit_active">
                        <div class="row add_cl_q">
                            <div class="col-md-12">
                                <div class="ac_text">
                                    <p>Students will be asked to answer the following questions on this unit attempt</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4>Question 1</h4>
                            </div>
                            <div class="cl_q_type_text">
                                <div class="cl_q_text_box">
                                    <label class="col-form-label text-black font-size-14">Question text</label>
                                    <div class="inner-addon left-addon">
                                        <div class="cl_input">
                                            <input type="text" class="form-control" id="topic_title">
                                        </div>

                                    </div>

                                </div>
                                <div class="cl_q_type_box">
                                    <label class="col-form-label text-black font-size-14">Question Type</label>
                                    <div class="cl_q_type">
                                        <select>
                                            <option>Text
                                            </option>
                                            <option>Multiple
                                            </option>
                                            <option>Scale
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <div class="cl_q_close">
                                    <p><i class="fa fa-times" aria-hidden="true"></i></p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <add-button name="Add Question"/>
                        </div>
                        <div class="mt-5">
                            <hr />
                            <button class="btn btn-secondary btn-lg"> Delete Unit </button>
                            <button class="btn btn-primary btn-lg"> Activate Unit </button>
                        </div>
                    </accordion>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
import Accordion from '../../components/accordion';
import AddButton from '../../components/AddButton';
    export default {
        components:{
            Accordion,AddButton
        },
        props: ['classroomId'],
        data() {
            return {
                unitData: [],
            };
        },
        mounted() {
            this.axios.get('/api/classroom/' + classroomId + '/unit-details').then(() => {
                this.unitData = resp.data.success.unitData
            });
        }
    }

</script>
