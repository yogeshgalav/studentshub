<template>
  <div>
    <classroom-header
      title="Classroom report"
    />
    <div class="row">
      <div class="col-md-12">
        <p class="font-weight-bold font-size-14 text-grey">
          Average score with average attempt by month.
        </p>
        <bar-line-graph
          v-if="bar_line_data.length"
          :x-axis-labels="bar_line_data.map(node=>node.attempt_month)"
          :line-data="bar_line_data.map(node=>node.average_score)"
          :bar-data="bar_line_data.map(node=>node.average_attempt)"
          line-label="Average score"
          bar-label="Average attempt"
        />
      </div>
      <div class="col-md-12 mt-3">
        <p class="font-weight-bold font-size-14 text-grey">
          Average score comparison by unit.
        </p>
        <doughnut-graph
          v-if="pie_graph_data.length"
          :graph-data="pie_graph_data"
        />
      </div>

      <div class="col-md-12 mt-3">
        <p class="font-weight-bold font-size-14 text-grey">
          First, Average and Last score in each unit.
        </p>
        <multi-bar-graph
          v-if="bar_data.length"
          :x-axis-label="bar_data.map(node=>node.unit_id)"
          :bar-labels="['First', 'Average', 'Last']"
          :bar-one-data="first_data"
          :bar-two-data="average_data"
          :bar-three-data="last_data"
        />
      </div>

      <div class="col-md-12 mt-3">
        <vue-table-component
          key="joinedStudents"
          :columns="joinedColumns"
          :rows="student_details"
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
              {{ 'Currently no student has joined this classroom.' }}
            </p>
            <p>{{ 'Share join Id to onboard your students to this classroom.' }}</p>
          </div>
        </vue-table-component>
      </div>
    </div>
  </div>
</template>
<script>
import ClassroomHeader from '../../components/ClassroomHeader';
import VueTableComponent from '../../components/vue-table-component';
import DoughnutGraph from '../../components/graphs/DoughnutGraph';
import MultiBarGraph from '../../components/graphs/MultiBarGraph.vue';
import BarLineGraph from '../../components/graphs/BarLineGraph.vue';


export default {
	components: {
		ClassroomHeader,
		VueTableComponent,
		DoughnutGraph,
		MultiBarGraph,
		BarLineGraph
	},
	data() {
		return {
			student_details: [],
			pie_graph_data:[],
			bar_data:[],
			bar_line_data:[],
			first_data:[],
			average_data:[],
			last_data:[],
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
			hover: false,
		};
	},
	computed: {
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		},
	},
	mounted(){
		this.getClassroomStudentDetails();	
	},
	methods: {
		getClassroomStudentDetails(){
			this.axios('/api/classroom/'+ this.$route.params[0] +'/report').then((resp)=>{
				this.student_details=resp.data.success.student_details;	
				const student_ids = resp.data.success.student_details.map(node=>{
					let new_node={};
					new_node['user_id'] = node.user_id;
					new_node['user_name'] = node.user_name;
					return new_node;
				});
				localStorage.setItem('studentids', JSON.stringify(student_ids));
				this.pie_graph_data=resp.data.success.pie_graph_data;
				this.bar_line_data=resp.data.success.bar_line_data;
				this.bar_data=resp.data.success.bar_data;
				this.first_data=this.bar_data.filter(node=>node.score_type==='first').map(node=>node.score);
				this.average_data=this.bar_data.filter(node=>node.score_type==='average').map(node=>node.score);
				this.last_data=this.bar_data.filter(node=>node.score_type==='last').map(node=>node.score);
				this.assignment_details = resp.data.success.assignment_details;
				this.student_details.map(node=>{
					let assignment = this.assignment_details.filter(node2=>node2.user_id===node.user_id);
					if(assignment.length){
						node.last_score =  assignment[0].marks_obtained;

						let m = this.$dayjs(assignment[0].duration,'HH:mm:ss').minute();
						let s = this.$dayjs(assignment[0].duration,'HH:mm:ss').second();
						node.last_time = m+' min '+s+' sec ';

						node.last_rank = assignment[0].rank;

						node.daily_average_score = parseFloat(assignment.reduce((acc,currVal)=>{
							return acc+ currVal.marks_obtained;
						},0)/assignment.length).toFixed(2);
						//get avg time
						let total_seconds= assignment.reduce((acc,currVal)=>{
							return acc+ this.$dayjs(currVal.duration,'HH:mm:ss').second();
						},0);
						let total_minutes= assignment.reduce((acc,currVal)=>{
							return acc+ this.$dayjs(currVal.duration,'HH:mm:ss').minute();
						},0);
						//convert millisecond to min and sec
						let avg_min = 0;
						let avg_sec = 0;
						if(total_seconds!==0){
							avg_min = total_minutes/assignment.length;
						}
						if(total_seconds!==0){
							avg_sec = total_seconds/assignment.length;
						}
						node.daily_average_time  = avg_min+' min '+avg_sec+' sec ';

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
