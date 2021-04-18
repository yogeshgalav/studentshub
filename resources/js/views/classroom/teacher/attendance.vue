<template>
  <div>
    <classroom-header />
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-black mb-0">
          Smart Attendance
        </h4>
      </div>

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            Smart Attendance
          </div>
          <div class="card-body">
            <vue-table-component
              key="today_attendance"
              :columns="attendColumn"
              :rows="attendRow"
            >
              <template
                slot="table-row"
                slot-scope="props"
              >
                <span v-if="props.column.field==='user_name'">
                  <a
                    :href="'/classroom/'+$route.params.classroomId+'/student-panel/'+props.row.user_id"
                    class="text-underline"
                  >{{ props.row['user_name'] }}</a>
                </span>
                <span v-else>{{ props.row[props.column.field] }}</span>
              </template>
              <div slot="emptystate">
                <p class="mt-3">
                  {{ 'Currently no student has joined this classroom' }}
                </p>
                <p>{{ 'Share join Id and accept their request to join here.' }}</p>
              </div>
            </vue-table-component>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import ClassroomHeader from '../../../components/ClassroomHeader';
import VueTableComponent from '../../../components/vue-table-component';
import dayjs from 'dayjs';
export default {
	components: {
		ClassroomHeader,
		VueTableComponent
	},
	data() {
		return {
			attendRow: [],
			attendColumn: [
				{
					label: 'Student Name',
					field: 'user_name',
				},
				{
					label: 'Institute ID',
					field: 'unique_college_id',
				},
				{
					label: 'Status',
					field: 'status',
				},
				{
					label: 'Joined at',
					field: 'meet_time',
				},
				{
					label: 'Present_at',
					field: 'present_at',
				},
				
			],
			hover: false,
		};
	},
	computed: {
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		},
		joinedStudents(){
			return this.student_details;
		},
	},	
	mounted(){
		this.getAttendanceDetails();
	},
	methods: {
		getAttendanceDetails(){
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/student-attendance-data').then((resp)=>{
				
			});
		},
	},

};

</script>
