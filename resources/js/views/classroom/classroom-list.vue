<template>
    <div>
        <div>
            <a href="/create-classroom"
            class="btn btn-primary btn-lg" 
            type="button"
            >Create Classroom</a>

            <button 
            class="btn btn-primary btn-lg" 
            type="button"
            @click="$modal.show('join_classroom_modal')"
            >Join Classroom</button>
            <modal name="join_classroom_modal" class="doubt_model">
            <form @submit.prevent="joinClassroom">
                <div class="model_box_inner card">
                     <div class="edit_profile_head">
                                <h4>Join Classroom</h4>
                            </div> 
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="model_input">
                                <label>Enter Classroom Name</label>
                                <input type="text" class="form-control" v-model="join_classroom_name">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="model_btn">
                                <button type="submit" class="save_profile_btn">Request</button>
                                <button type="button" class="cancel_profile_btn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </modal>
        </div>
        <div v-if="myClassrooms.length">
            <div class="row">
                My Classrooms
                <hr />
            </div>
            <div class="row">
                <div class="col-md-4" v-for="(classroom,index) in myClassrooms" :key="index">
                    <div class="clas_roo_main_box">
                        <div class="cl_box_top">
                            <p>{{classroom.subject_alias}}</p>
                        </div>
                        <div class="classroom_box">
                            <div class="clss_username">
                                <p><img src="/images/Group.svg" alt=""></p>
                                <h5>{{classroom.teacher_name}}</h5>
                            </div>
                            <div class="classroom_content">
                                <a :href="'/classroom/'+classroom.name">{{classroom.name}}</a>
                                <p>{{classroom.subject_name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="classroomList.length">
                <div class="row">
                    Joined Classrooms
                    <hr />
                </div>
                <div class="row">
                    <div class="col-md-4" v-for="(classroom,index) in classroomList" :key="index">
                        <div class="clas_roo_main_box">
                            <div class="cl_box_top">
                                <p>{{classroom.subject_alias}}</p>
                            </div>
                            <div class="classroom_box">
                                <div class="clss_username">
                                    <p><img src="/images/Group.svg" alt=""></p>
                                    <h5>{{classroom.teacher_name}}</h5>
                                </div>
                                <div class="classroom_content">
                                    <a :href="'/classroom/'+classroom.name">{{classroom.name}}</a>
                                    <p>{{classroom.subject_name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import VModal from 'vue-js-modal'

    export default {
        props: ['myClassrooms', 'classroomList'],
        components:{
            VModal
        },
        data(){
            return {
                join_classroom_name:'',
            };
        },
        watch:{
            create_classroom_subject(){

            }
        },
        methods:{
            joinClassroom(){
                this.axios.post('/api/classroom/join',{
                    name:this.join_classroom_name
                });
            },
        }
    }

</script>

<style>
    .clas_roo_main_box {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.16);
        margin-bottom: 30px;
        border-radius: 4px;
    }

    .cl_box_top p {
        color: white;
        font-size: 24px;
        font-weight: 700;
    }

    .cl_box_top {
        padding: 50px;
        text-align: center;
        background-color: #0f6bff;
        background: linear-gradient(90deg, #020024 0%, #090979 0%, #0475c0 0%, #00d4ff 79%);
    }

    .classroom_box p {
        color: #868686;
    }

    .classroom_box a {
        font-size: 20px;
        color: black;
        font-weight: 700;
    }

    .classroom_box {
        position: relative;
    }

    .clss_username {
        display: flex;
        align-items: center;
        position: absolute;
        top: -52px;
        width: 100%;
        padding: 0px 15px;
    }

    .clss_username img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #f6f6f6;
        border: solid 1px #ccc;
    }

    .classroom_content {
        padding: 44px 0 0;
    }

    .clss_username h5 {
        /* padding: 25px 12px; */
        margin: 20px 10px 0;
    }

    .classroom_content {
        padding: 60px 18px 10px;
    }

</style>
