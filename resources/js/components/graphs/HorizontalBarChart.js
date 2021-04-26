import { HorizontalBar } from 'vue-chartjs';
import ChartDataLabels from 'chartjs-plugin-datalabels';
export default {
	extends: HorizontalBar,
	plugin:[ChartDataLabels],
	props: ['data','options'],
	mounted() {
		// this.chartData is created in the mixin.
		// If you want to pass options please create a local options object
		this.renderChart(this.data,this.options);
	}
};
