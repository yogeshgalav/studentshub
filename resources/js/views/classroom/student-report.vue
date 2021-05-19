<template>
  <div>
    <div class="col-md-12">
      <doughnut-graph :graph-data="pieChartData" />
    </div>
    <div class="col-md-12">
      <multiBar-graph :graph-data="[{ id: 2, count: 3 }]" />
    </div>
    <div class="col-md-12">
      <dualLine-graph
        v-if="dualLineChartData.length"
        :line-one-data="dualLineChartData.map(node=>node.classroom_score)"
        :line-two-data="dualLineChartData.map(node=>node.student_score)"
        :labels="dualLineChartData.map(node=>node.attempt_date)"
        line-one-label="Classroom score"
        line-two-label="Student score"
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
	data() {
		return {
			showLoader: true,
			pieChartData: [],
			dualLineChartData:[]
		};
	},
	mounted() {
		let url =
      '/api/classroom/' +
      this.$route.params.classroomId +
      '/get-student-report-data';
		if (this.$route.name === 'ClassroomStudentPanel') {
			url = url + '/' + this.$router.currentRoute.params.userId;
		}
		this.axios.get(url).then((resp) => {
			this.pieChartData = resp.data.success.assignments_attemps;
			this.dualLineChartData = resp.data.success.average_scores;
			this.showLoader = false;
		});
	},
};
</script>

