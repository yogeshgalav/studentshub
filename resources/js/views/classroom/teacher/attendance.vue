<template>
  <div>
    <loading
      :active.sync="loading"
      :color="'#10069F'"
      :width="100"
      :is-full-page="true"
      :opacity="0.7"
    />
    <classroom-header />
    <div class="row">
      <div
        v-if="classroomDetail.meet_link"
        class="col-md-6 col-12"
      >
        <a
          :href="classroomDetail.meet_link"
          target="_blank"
          class="btn btn-primary btn-lg"
          @click="startMeeting"
        >Start Meeting
        </a>
      </div>
      <div
        class="col-md-6 col-12"
      >
        <button
          class="btn btn-white btn-lg"
          @click="getAttendanceDetails"
        >
          Refresh
        </button>
      </div>

      <div class="col-md-12 mt-2">
        <div class="card">
          <div class="card-header">
            Today's Attendance
          </div>
          <div class="card-body">
            <button
              class="btn btn-success btn-lg"
              @click="startAttendance"
            >
              Check Presence {{ startTimer ? timer : '' }}
            </button>
            <vue-table-component
              key="today_attendance"
              :columns="attendColumn"
              :rows="attendRow"
            >
              <template
                slot="table-row"
                slot-scope="props"
              >
                <span v-if="props.column.field==='full_name'">
                  <a
                    :href="'/classroom/'+$route.params.classroomId+'/student-panel/'+props.row.user_id"
                    class="text-underline"
                  >{{ props.row['full_name'] }}</a>
                </span>
                <span v-else-if="props.column.field==='status'">
                  <span
                    v-if="props.row.joined_at"
                    class="text-success"
                  >Present</span>
                  <span
                    v-else
                    class="text-danger"
                  >Absent</span>
                </span>
                <span v-else>{{ props.row[props.column.field] }}</span>
              </template>
              <div slot="emptystate">
                <p class="mt-3">
                  {{ 'Currently no student has joined meeting' }}
                </p>
              </div>
            </vue-table-component>
          </div>
        </div>
      </div>

      <div class="col-md-12 mt-2 mb-2">
        <div class="card">
          <div class="card-header">
            Previous Attendance
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <select 
                  v-model="selected_date"
                  class="form-control"
                  @change="getAttendanceForDate()"
                >
                  <option value="">
                    Select Date
                  </option>
                  <option
                    v-for="(date, index) in attendDates"
                    :key="index"
                    :value="date.original_date"
                  >
                    {{ date.meet_date }}
                  </option>
                </select>
              </div>
            </div>  
            <vue-table-component
              v-if="selected_date"
              key="today_attendance"
              :columns="attendColumn"
              :rows="PreviousAttendRow"
            >
              <template
                slot="table-row"
                slot-scope="props"
              >
                <span v-if="props.column.field==='full_name'">
                  <a
                    :href="'/classroom/'+$route.params.classroomId+'/student-panel/'+props.row.user_id"
                    class="text-underline"
                  >{{ props.row['full_name'] }}</a>
                </span>
                <span v-else-if="props.column.field==='status'">
                  <span
                    v-if="props.row.joined_at"
                    class="text-success"
                  >Present</span>
                  <span
                    v-else
                    class="text-danger"
                  >Absent</span>
                </span>
                <span v-else>{{ props.row[props.column.field] }}</span>
              </template>
              <div slot="emptystate">
                <p class="mt-3">
                  {{ 'No student has joined meeting on this date' }}
                </p>
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
			loading: false,
			meet_link: '',
			selected_date: '',
			attendRow: [],
			PreviousAttendRow: [],
			attendDates: [],
			attendColumn: [
				{
					label: 'Student Name',
					field: 'full_name',
				},
				{
					label: 'Institute ID',
					field: 'institute_id',
				},
				{
					label: 'Status',
					field: 'status',
				},
				{
					label: 'Joined at',
					field: 'joined_at',
				},
				{
					label: 'Present_at',
					field: 'present_at',
				},
				
			],
			hover: false,
			startTimer: false,
			timer:dayjs('10:00','mm:ss').format('mm:ss'),
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
			this.loading =true;
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/get-attendance-data').then((resp)=>{
				this.attendRow = resp.data.success.today_attendance.map(node=>{
					node.joined_at = dayjs(node.joined_at, 'hh:mm:ss').format('hh:mm A');
					node.present_at = node.present_at ? dayjs(node.present_at, 'hh:mm:ss').format('hh:mm A') : '';
					return node;
				});
				this.loading =false;
			});
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/get-attendance-dates').then((resp)=>{
				this.attendDates = resp.data.success.attend_dates.map(node=>{
					node.original_date = node.meet_date;
					node.meet_date = dayjs(node.meet_date, 'YYYY-MM-DD').format('D MMMM, YYYY');
					return node;
				});
			});
		},
		getAttendanceForDate(){
			this.loading =true;
			let date = dayjs(this.selected_date, 'D MMMM, YYYY').format('YYYY-MM-DD');
			console.log(date);
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/get-attendance-data?date='+date).then((resp)=>{
				this.PreviousAttendRow = resp.data.success.today_attendance.map(node=>{
					node.joined_at = dayjs(node.joined_at, 'hh:mm:ss').format('hh:mm A');
					node.present_at = node.present_at ? dayjs(node.present_at, 'hh:mm:ss').format('hh:mm A') : '';
					return node;
				});
				this.loading =false;
			});
		},
		startMeeting(){
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/start-meeting');
		},
		startAttendance(){
			this.timer=dayjs('10:00','mm:ss').format('mm:ss');
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/start-attendance').then(()=>{
				this.startTimer = true;
				var downTimer = setInterval(()=>{
					if(dayjs(this.timer,'mm:ss').minute() >10){
						clearInterval(downTimer);
						this.startTimer = false;
					}
					this.timer=dayjs(this.timer,'mm:ss').subtract(1,'seconds').format('mm:ss');
				}, 1000);
			});
		}
	},

	

};

</script>
