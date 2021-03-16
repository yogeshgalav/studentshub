import Chart from 'chart.js';
import { Line, mixins } from 'vue-chartjs';
Chart.Legend.prototype.afterFit = function() {
	this.height = this.height + 20;
};
export default {
	extends: Line,
	mixins: [mixins.reactiveProp],
	props: ['chartData', 'options'],
	mounted () {
		this.renderChart(this.chartData, this.options);
	}
};
