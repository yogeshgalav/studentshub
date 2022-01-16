<template>
  <div>
    <loading
      :active.sync="loading"
      :color="'#10069F'"
      :width="100"
      :is-full-page="true"
      :opacity="0.7"
    />
    <classroom-header 
      title="Attendance"
    />
    <div class="row">
      <div
        v-if="classroomDetail.meet_link"
        class="col-md-6 col-12"
      >
        <a
          :href="classroomDetail.meet_link"
          target="_blank"
          class="btn btn-primary btn-lg"
          @click="joinMeeting"
        >Start Meeting
        </a>
      </div>
      <div
        class="col-md-6 col-12"
      >
        <button
          v-if="showPresentButton"
          class="btn btn-success btn-lg"
          @click="markPresent"
        >
          Mark Present
        </button>
        <button
          v-else
          class="btn btn-white btn-lg"
          @click="getAttendanceDetails"
        >
          Refresh
        </button>
      </div>

      <div class="col-md-12 mt-2 mb-2">
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
                    :href="'/classroom/'+$route.params[0]+'/student-panel/'+props.row.user_id"
                    class="text-underline"
                  >{{ props.row['user_name'] }}</a>
                </span>
                <span v-else>{{ props.row[props.column.field] }}</span>
              </template>
              <div slot="emptystate">
                <p class="mt-3">
                  {{ 'Currently no attendance data to show here.' }}
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
import swal from '../../../components/swal';



export default {
	components: {
		ClassroomHeader,
		VueTableComponent
	},
	data() {
		return {
			attendance: {
				present_at:'',
				ended_at:''
			},
			attendRow: [],
			attendColumn: [
				{
					label: 'Date',
					field: 'meet_date',
				},
				{
					label: 'Joined at',
					field: 'joined_at',
				},
				
				{
					label: 'Present at',
					field: 'present_at',
				},
				
			],
			hover: false,
			loading: false,
		};
	},
	computed: {
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		},
		showPresentButton(){
			if(!this.attendance){
				return false;
			}
			let ended_at = this.$dayjs(this.attendance.ended_at);
			let current_time = this.$dayjs();
			if(!this.attendance.present_at && current_time.isBefore(ended_at) ){
				return true;
			}
			return false;
		}
	},
	mounted(){
		
		this.getAttendanceDetails();
	},
	methods: {
		getAttendanceDetails(){
			this.loading=true;
			this.axios('/api/classroom/'+ this.$route.params[0] +'/get-student-attendance').then((resp)=>{
				this.attendance = resp.data.success.attendance;
				this.attendRow = resp.data.success.attend_rows.map(node=>{
					node.joined_at = this.$dayjs(node.joined_at, 'hh:mm:ss').format('hh:mm A');
					node.present_at = node.present_at ? this.$dayjs(node.present_at, 'hh:mm:ss').format('hh:mm A') : '';
					node.meet_date = this.$dayjs(node.meet_date, 'YYYY-MM-DD').format('D MMMM, YYYY');
					return node;
				});;
				this.loading=false;

			});
		},
		joinMeeting(){
			this.axios('/api/classroom/'+ this.$route.params[0] +'/join-meeting');
		},
		markPresent(){
			this.loading=true;
			this.axios('/api/classroom/'+ this.$route.params[0] +'/mark-present').then((resp)=>{
				this.attendance = resp.data.success.attendance;
				this.attendRow = resp.data.success.attend_rows.map(node=>{
					node.joined_at = this.$dayjs(node.joined_at, 'hh:mm:ss').format('hh:mm A');
					node.present_at = node.present_at ? this.$dayjs(node.present_at, 'hh:mm:ss').format('hh:mm A') : '';
					node.meet_date = this.$dayjs(node.meet_date, 'YYYY-MM-DD').format('D MMMM, YYYY');
					return node;
				});;
				this.loading=false;
				swal.infoDialog('Present Marked!');
			});
		}
	},

};

</script>
