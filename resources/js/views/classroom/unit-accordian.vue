<template>
    <div class="row">
        <div class="col-md-12" v-for="(unit,index) in unitData" :key="index">
            <accordion title="Unit 0: introduction" :aria-expanded="true" tab="accordion_status_unit_active">
                <div class="row">
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <div class="form-group  row">
                                <div class="col-md-12">
                                    <label class="col-form-label text-black font-size-14">Topic
                                        Title </label>
                                    <div class="inner-addon left-addon">
                                        <div class="input_icon_frm">
                                            <span class="icon_design_input"><i class="fa fa-user"></i></span>
                                            <div class="cl_input">
                                                <input type="text" class="form-control" id="topic_title">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  row">
                                <div class="col-md-12">
                                    <label class="col-form-label text-black font-size-14">Answer
                                        Type </label>
                                    <div class="inner-addon left-addon">
                                        <div class="input_icon_frm">
                                            <span class="icon_design_input"><i class="fa fa-user"></i></span>

                                            <select class="form-control">
                                                <option>Text
                                                </option>
                                                <option>Multiple
                                                </option>
                                                <option>Scale
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group cl_add_topic ">
                                <button class="login_btn">ADD Topic
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-2 mt-2">
                        <div class="divider">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="cls_btn">
                            <button class="login_btn">Delete Unit
                            </button>
                            <button class="login_btn">Activate Unit
                            </button>
                        </div>
                    </div>
                </div>
            </accordion>
        </div>
    </div>
</template>
<script>
export default {
    props:['classroomId'],
    data(){
        return {
            unitData:[],
        };
    },
    mounted(){
        this.axios.get('/api/classroom/'+classroomId+'/unit-details').then(()=>{
            this.unitData=resp.data.success.unitData
        });
    }
}
</script>