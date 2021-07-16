<template>
  <div class="text-center">
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="false"
    />
    <div class="row justify-content-center col-md-12">
      <single-value
        :value="summary_data.total_attempt"
        label="Total Attempt"
      />
      <single-value
        :value="summary_data.average_score"
        label="Average Score"
      />
      <single-value
        :value="summary_data.average_rank"
        label="Average Rank"
      />
    </div>
    <div class="row justify-content-center col-md-12">
      <single-value
        :value="first_average"
        label="First Average Score"
      />
      <single-value
        :value="last_average"
        label="Last Average Score"
      />
      <single-value
        :value="progress + '%'"
        label="Progress"
      />
    </div>
    <div class="col-md-12">
      <p class="font-weight-bold font-size-14 text-grey">
        What is the overall progress of student w.r.t others in this classroom?
      </p>
      <dualLine-graph
        v-if="dualLineChartData.length"
        :line-one-data="dualLineChartData.map(node=>node.classroom_score)"
        :line-two-data="dualLineChartData.map(node=>node.student_score)"
        :labels="dualLineChartData.map(node=>node.attempt_date)"
        line-one-label="Classroom score"
        line-two-label="Student score"
      />
    </div>
    <div class="col-md-12 mt-5">
      <p class="font-weight-bold font-size-14 text-grey">
        How many assignments have been attempted in each unit?
      </p>
      <doughnut-graph 
        v-if="pieChartData.length" 
        :graph-data="pieChartData" 
      />
    </div>
    <div class="col-md-12 mt-5">
      <p class="font-weight-bold font-size-14 text-grey">
        What is the first, average and last score in each unit?
      </p>
      <multiBar-graph
        v-if="lastData.length"
        :bar-labels="['first','average','last']"
        :bar-one-data="firstData"
        :bar-two-data="averageData"
        :bar-three-data="lastData"
        :x-axis-labels="pieChartData.map(node=>node.label)"
      />
    </div>
  </div>
</template>

<script>
import DoughnutGraph from '../../components/graphs/DoughnutGraph';
import MultiBarGraph from '../../components/graphs/MultiBarGraph';
import DualLineGraph from '../../components/graphs/DualLineGraph';
import SingleValue from '../../components/SingleValue';

export default {
	components: {
		DoughnutGraph,
		MultiBarGraph,
		DualLineGraph,
		SingleValue
	},
	props:['classroomId'],
	data() {
		return {
			showLoader: true,
			pieChartData: [],
			dualLineChartData:[],
			firstData:[],
			averageData:[],
			lastData:[],
			summary_data:[],
			first_average:0,
			last_average:0,
			progress:0,
		};
	},
	mounted() {
		let url =
      '/api/classroom/' +
      this.classroomId +
      '/get-student-report';
		if (this.$route.name === 'ClassroomStudentPanel') {
			url = url + '/' + this.$router.currentRoute.params.userId;
		}
		this.axios.get(url).then((resp) => {
			this.pieChartData = resp.data.success.assignments_attempts;
			this.dualLineChartData = resp.data.success.average_scores;
			this.summary_data = resp.data.success.summary_data;
			let MultiBarGraph = resp.data.success.score_data;
			this.firstData = MultiBarGraph.filter(node=>node.score_type === 'first')
				.sort((a,b)=>b.unit_id-a.unit_id)
				.map(node=>node.score);
			this.averageData = MultiBarGraph.filter(node=>node.score_type === 'average')
				.sort((a,b)=>b.unit_id-a.unit_id)
				.map(node=>node.score);
			this.lastData = MultiBarGraph.filter(node=>node.score_type === 'last')
				.sort((a,b)=>b.unit_id-a.unit_id)
				.map(node=>node.score);
			this.first_average = this.firstData.reduce((a,b)=>a+b,0)/this.firstData.length;
			this.last_average = this.lastData.reduce((a,b)=>a+b,0)/this.lastData.length;
			this.progress=((this.last_average-this.first_average)/this.last_average)*100; 
			// let dataSet = {};
			// MultiBarGraph.map(node=>{

			// 	if(!this.MultiBarGraphData.labels.includes(node.unit_id)){
			// 		this.MultiBarGraphData.labels.push(node.unit_id);
			// 	};

			// this.MultiBarGraphData.dataSet[this.MultiBarGraphData.labels.indexOf(node.unit_id)] = {

			// }
			// });
			this.showLoader = false;
		});
	},
};
</script>

