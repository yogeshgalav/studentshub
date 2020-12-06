<template>
  <div>
    <classroom-header />
    <div class="row">
      <div class="col-md-8">
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
                :href="'/profile/'+props.row.user_id"
                class="text-underline"
              >{{ props.row['user_name'] }}</a>
            </span>
            <span v-else>{{ props.row[props.column.field] }}</span>
          </template>
        </vue-table-component>
      </div>
    </div>
  </div>
</template>
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
		};
	},
	computed: {
		joinedStudents(){
			return this.student_details.filter(node=>node.joined_at!==null);
		},
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
	},

};

</script>
