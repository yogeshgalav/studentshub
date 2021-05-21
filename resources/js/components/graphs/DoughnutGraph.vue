<script>
import { Doughnut } from 'vue-chartjs';

export default {
	extends: Doughnut,
	props:{
		width:{
			type:Number,
			default: 200
		},
		height:{
			type:Number,
			default: 200
		},
		graphData:{
			type:Array,
			default: () => []
		}
	},
	computed:{
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
	watch:{
		graphData(val){
			if(val && val.length){
				// this.chartData is created in the mixin.
				// If you want to pass options please create a local options object
				this.renderChart(this.getChartData(val),this.chartOptions);
			}
		}
	},
	methods:{
		getChartData(val){
			return  {
				labels: val.map(node=>node.label),
				datasets: [
					{
						label: 'label',
						backgroundColor: val.map((node,index)=>this.reportColorCodes[index]),
						data: val.map(node=>node.count)
					}
				]
			};
		}
	}
};
</script>
