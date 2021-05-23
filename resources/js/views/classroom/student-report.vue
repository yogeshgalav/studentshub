<template>
  <div class="text-center">
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

export default {
	components: {
		DoughnutGraph,
		MultiBarGraph,
		DualLineGraph,
	},
	props:['classroomId'],
	data() {
		return {
			showLoader: true,
			pieChartData: [],
			dualLineChartData:[],
			firstData:[],
			averageData:[],
			lastData:[]
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
			let MultiBarGraph = resp.data.success.reports_summary;
			this.firstData = MultiBarGraph.filter(node=>node.score_type === 'first')
				.sort((a,b)=>b.unit_id-a.unit_id)
				.map(node=>node.score);
			this.averageData = MultiBarGraph.filter(node=>node.score_type === 'average')
				.sort((a,b)=>b.unit_id-a.unit_id)
				.map(node=>node.score);
			this.lastData = MultiBarGraph.filter(node=>node.score_type === 'last')
				.sort((a,b)=>b.unit_id-a.unit_id)
				.map(node=>node.score);
			console.log(this.firstData);
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

