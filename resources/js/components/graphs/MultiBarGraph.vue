<script>
import { Bar } from 'vue-chartjs';

export default {
	extends: Bar,
	props:{
		width:{
			type:Number,
			default: 200
		},
		height:{
			type:Number,
			default: 100
		},
		xAxisLabels:{
			type:Array,
			default: () => []
		},
		barLabels:{
			type:Array,
			default: () => []
		},
		barOneData:{
			type:Array,
			default: () => []
		},
		barTwoData:{
			type:Array,
			default: () => []
		},
		barThreeData:{
			type:Array,
			default: () => []
		}
	},
	computed:{
		chartData(){
			const self = this;
			return  {
				labels: this.xAxisLabels,
				datasets: [
					{
						label: this.barLabels[0],
						backgroundColor: this.reportColorCodes[0],
						data: this.barOneData
					},
					{
						label: this.barLabels[1],
						backgroundColor: this.reportColorCodes[1],
						data: this.barTwoData
					},
					{
						label: this.barLabels[2],
						backgroundColor: this.reportColorCodes[2],
						data: this.barThreeData
					}
				]
			};
		},
		chartOptions() {
			var self = this;
			return{
				responsive: true,
				legend: {
					position: 'top'
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			};
		}
	},
	mounted() {
		// this.chartData is created in the mixin.
		// If you want to pass options please create a local options object
		this.renderChart(this.chartData,this.chartOptions);
	}
};
</script>
