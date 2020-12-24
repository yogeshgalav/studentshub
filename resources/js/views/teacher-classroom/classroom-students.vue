<template>
  <div>
    <classroom-header />
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-black mb-0">
          Classroom students report
        </h4>
      </div>
      <div class="col-md-12">
        <vue-table-component
          key="joinedStudents"
          :columns="joinedColumns"
          :rows="joinedStudents"
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
    <div class="row">
      <div class="col-md-12">
        <h4 class="text-black mb-0 mt-3">
          Join requests
        </h4>
      </div>
      <div class="col-md-12">
        <vue-table-component
          key="unjoinedStudents"
          :columns="unjoinedColumns"
          :rows="unjoinedStudents"
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

            <span v-else-if="props.column.field==='accept_request'">  
              <button
                class="btn btn-md btn-success"
                @click="acceptJoinRequest(props.row.user_id,'accept')"
              >
                Accept
              </button>
            </span>

            <span v-else-if="props.column.field==='delete_request'">
              <button
                class="btn btn-md btn-danger"
                @click="acceptJoinRequest(props.row.user_id,'decline')"
              >
                Decline
              </button>
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
    <div class="row">
      <div
        v-if="classroomDetail.id"
        class="col-md-4 col-12 mt-3 mb-3"
      >
        <div
          class="join_id_box"
          @click="copyText('joinId')"
        >
          <i class="fa  text-blue  fa-arrow-right mr-3" />  <span
            class="text-blue font-size-14 weight-800 join-id line-height-25-px"
          >
            {{ 'Copy Join Id' }}: {{ classroomDetail.classroom_live_id }}
            <strong class="right_positions hide"><i class="fa fa-copy text-success font-size-15" /> </strong>  
          </span>
        </div>
      </div>
      <div
        v-if="classroomDetail.batch_start_year && classroomDetail.batch_end_year"
        class="col-md-4 col-12 mt-3 mb-3"
      >
        <div
          class="join_id_box"
          @click="copyText('RegisterationLink')"
        >
          <i class="fa  text-blue  fa-arrow-right mr-3" />  <span
            class="text-blue font-size-14 weight-800 join-id line-height-25-px"
          >
            {{ 'Copy Registration Link' }}
            <strong class="right_positions hide"><i class="fa fa-copy text-success font-size-15" /> </strong>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.join_id_box {
 border:1px solid #eee;
 border-radius: 5px;
 padding: 8px 5px 8px 15px;
 cursor: pointer;
}
.join_id_box:hover {
 background-color: #f3f9e8;
 border-color: #e1ebb3;
}
.right_positions {
  position: absolute;
  right: 40px;
}
.join_id_box:hover strong{
	display: block;
	margin-top: -20px;
}
.hide {
  display: none;
}
</style>
<script>
import ClassroomHeader from '../../components/ClassroomHeader';
import VueTableComponent from '../../components/vue-table-component';
import dayjs from 'dayjs';
export default {
	components: {
		ClassroomHeader,
		VueTableComponent
	},
	data() {
		return {
			student_details: [],
			joinedColumns: [
				{
					label: 'Student Name',
					field: 'user_name',
				},
				{
					label: 'Institute ID',
					field: 'unique_college_id',
				},
				{
					label: 'Last Score',
					field: 'last_score',
				},
				{
					label: 'Last Time',
					field: 'last_time',
				},
				{
					label: 'Last Rank',
					field: 'last_rank',
				},
				{
					labelTop: 'Daily Average',
					label: 'Score',
					field: 'daily_average_score',
				},
				{
					labelTop: 'Daily Average',
					label: 'Time',
					field: 'daily_average_time',
				},
				{
					labelTop: 'Daily Average',
					label: 'Rank',
					field: 'daily_average_rank',
				},
			],
			unjoinedColumns: [
				{
					label: 'Student Name',
					field: 'user_name',
				},
				{
					label: 'Institute ID',
					field: 'unique_college_id',
				},
				{
					label: 'Accept Request',
					field: 'accept_request',
				},
				{
					label: 'Delete Request',
					field: 'delete_request',
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
			this.axios('/api/classroom/'+ this.$route.params.classroomId +'/students-data').then((resp)=>{
				this.student_details=resp.data.success.student_details;
				this.assignment_details = resp.data.success.assignment_details;
				this.student_details.map(node=>{
					let assignment = this.assignment_details.filter(node2=>node2.user_id===node.user_id);
					if(assignment.length){
						node.last_score =  assignment[0].marks_obtained;
						
						let m = dayjs(assignment[0].duration,'HH:mm:ss').minute();
						let s = dayjs(assignment[0].duration,'HH:mm:ss').second();
						node.last_time = m+' min '+s+' sec ';
						
						node.last_rank = assignment[0].rank;
						
						node.daily_average_score = parseFloat(assignment.reduce((acc,currVal)=>{
							return acc+ currVal.marks_obtained;
						},0)/assignment.length).toFixed(2);
						//get avg millisecond
						let avg_ms= parseFloat(assignment.reduce((acc,currVal)=>{
							return acc+ dayjs(currVal.duration).millisecond();
						},0)/assignment.length).toFixed(2);
						//convert millisecond to min and sec
						if(avg_ms!=='NaN'){
							let m2 = dayjs(dayjs().millisecond(avg_ms)).minute();
							let s2 = dayjs(dayjs().millisecond(avg_ms)).second();
							node.daily_average_time  = m2+' min '+s2+' sec ';
						}else{
							node.daily_average_time  = null;
						}
						node.daily_average_rank = parseFloat(assignment.reduce((acc,currVal)=>{
							return acc+ currVal.rank;
						},0)/assignment.length).toFixed(2);
					}else{
						node.last_score = null;
						node.last_time = null;
						node.last_rank = null;
						node.daily_average_score = null;
						node.daily_average_time = null;
						node.daily_average_rank = null;
					}
					return node;
				});
			});
		},
		acceptJoinRequest(user_id,status) {
			this.axios.post('/api/classroom/user-request-action', {
				user_id: user_id,
				status: status,
				classroom_id: this.$route.params.classroomId,
			}).then((resp) => {
				this.student_details = this.student_details.filter(node=>node.user_id!==user_id);
			});;

		},
		copyText(copyType){
			const el = document.createElement('textarea');
			if(copyType==='RegisterationLink'){
				el.value = this.baseUrl+'/get-started?joinId='+this.classroomDetail.classroom_live_id;
			}else{
				el.value = this.classroomDetail.classroom_live_id;
			}
			document.body.appendChild(el);
			el.select();
               
			document.execCommand('copy');
			document.body.removeChild(el);
		},
	},

};

</script>
