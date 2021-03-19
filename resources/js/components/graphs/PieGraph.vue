<script>
import { Doughnut } from 'vue-chartjs';

export default {
	// components: {
	// 	PieChart
	// },
	extends: Doughnut,
	props:{ width:{ type:Number, default: 200 }, height:{ type:Number, default: 200 }, graphData:{ type:Array, default: () => [] } },
	data(){
		return {
			reportColorCodes: ['#10069F', '#963CBD', '#00C1D5', '#F39C12', '#1D7BB9', '#95A5A6', '#EABD0A'],
			reportColorClasses: [
				'text-blue',
				'text-accent',
				'text-dark-cyan',
				'text-dark-yellow',
				'text-nice-blue',
				'text-metal',
				'text-light-yellow',
			],
		};
	},
	computed:{
		chartData(){
			const self = this;
			return  {
				labels: this.graphData.map(node=>node),
				datasets: [
					{
						label: 'label',
						backgroundColor: this.graphData.map((node,index)=>this.reportColorCodes[index]),
						data: this.graphData.map(node=>node.count)
					}
				]
			};
		},
		chartOptions() {
			var self = this;
			return{
				responsive: false,
				maintainAspectRatio: false,
				layout: {
					padding: {
						bottom:0,
					}
				},
				legend: {
					display: false,
				},
				plugins: {
					datalabels: {
						display: false,
					}
				},
				tooltips: {
					enabled: true,
					mode: 'single',
					callbacks: {
						label: function(tooltipItems, data) {
							return data.labels[tooltipItems.index].label;
						},
						title: function(tooltipItems, data) {
							// console.log(data.datasets);
							return data.datasets[0].data[tooltipItems[0].index];
						}
					}
				},
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
