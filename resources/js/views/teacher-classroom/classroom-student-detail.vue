<template>
    <div>
        <classroom-header />
        <div class="row">
            <div class="col-md-8">
                <div class="card mt-5" v-for="(student,index) in unjoinedStudents" :key="student.user_id">
                    <div class="card-header">
                        <h4 class="mb-1">
                            {{ student.user_name }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-md btn-success" @click="acceptJoinRequest(student.user_id,'accept')"> Accept </button>
                        <button class="btn btn-md btn-danger" @click="acceptJoinRequest(student.user_id,'decline')"> Decline </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import ClassroomHeader from '../../components/ClassroomHeader';
    export default {
        components: {
            ClassroomHeader
        },
        data() {
            return {
                student_details: [],
            };
        },
        computed: {
            unjoinedStudents(){
                return this.student_details.filter(node=>node.joined_at===null);
            }
        },
        mounted(){
            this.getClassroomStudentDetails();
        },
        methods: {
            getClassroomStudentDetails(){
                this.axios('/api/classroom/'+ this.$route.params.classroomId +'/student-details').then((resp)=>{
                    this.student_details=resp.data.success.student_details;
                });
            },
            acceptJoinRequest(user_id,status) {
                this.axios.post('/api/classroom/user-request-action', {
                    user_id: user_id,
                    status: status,
                    classroom_id: this.$route.params.classroomId,
                }).then((resp) => {
                    this.student_details = this.student_details.filter(node=>node.user_id!=user_id)
                });;

            },
        },

    }

</script>
