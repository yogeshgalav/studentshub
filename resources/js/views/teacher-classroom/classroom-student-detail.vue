<template>
    <div>
        <classroom-header />
        <div class="row">
            <div class="col-md-8">
                <vue-table-component
                    :columns="columns"
                    :rows="joinedStudents"
                    >
                    <template
                        slot="table-row"
                        slot-scope="props"
                    >
                        <span v-if="props.column.field==='user_name'">
                        <a
                            :href="'/student-panel/'+props.row.user_id"
                            class="text-underline"
                        >{{ props.row['user_name'] }}</a>
                        </span>
                        <span v-else>{{ props.row[props.column.field] }}</span>
                    </template>
                    <div slot="emptystate">
                        <p class="mt-3">
                        {{ 'Currently no student has joined this classroom' }}
                        </p>
                        <p>{{ 'Share join Id and accept there request to jion here.' }}</p>
                    </div>
                    </vue-table-component>
            </div>
        </div>
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
    import VueTableComponent from '../../components/vue-table-component';

    export default {
        components: {
            ClassroomHeader,
            VueTableComponent
        },
        data() {
            return {
                student_details: [],
                columns: [
                    {
                        label: 'Student Name',
                        field: 'user_name',
                    },
                    {
                        label: 'Institute ID',
                        field: 'unique_college_id',
                    },
                    {
                        label: 'Daily Average Score',
                        field: 'daily_average_score',
                    },
                    {
                        label: 'Daily Average Time',
                        field: 'daily_average_time',
                    },
                    {
                        label: 'Daily Average Rank',
                        field: 'daily_average_rank',
                    },
                ],
            };
        },
        computed: {
            joinedStudents(){
                return this.student_details.filter(node=>node.joined_at!==null);
            },
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
