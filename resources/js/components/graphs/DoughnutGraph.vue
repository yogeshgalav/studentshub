<script>
import { Doughnut } from 'vue-chartjs';

export default {
	extends: Doughnut,
	props:{
		width:{
			type:Number,
			default: 300
		},
		height:{
			type:Number,
			default: 300
		},
		graphData:{
			type:Array,
			default: () => []
		}
	},
	computed:{
		chartData(){
			return  {
				labels: this.graphData.map(node=>node.label),
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
					display: true,
				},
				plugins: {
					datalabels: {
						display: false,
					}
				},
				tooltips: {
					enabled: true,
					mode: 'single',
				},
			};
		}
	},
	mounted(){
		this.renderChart(this.chartData,this.chartOptions);
	}
};
</script>
