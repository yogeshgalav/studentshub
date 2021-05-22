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
			default: 200
		},
		graphData:{
			type:Array,
			default: () => []
		}
	},
	computed:{
		chartData(){
			const self = this;
			return  {
				labels:this.graphData.map(node=>node.attempt_date),
				datasets: [ {
					label: this.graphData.map(node=>node.lineLabel),
					type:'line',
					data: this.graphData.map(node=>node.lineData),
					fill: false,
					borderColor: '#EC932F',
					backgroundColor: '#EC932F',
					pointBorderColor: '#EC932F',
					pointBackgroundColor: '#EC932F',
					pointHoverBackgroundColor: '#EC932F',
					pointHoverBorderColor: '#EC932F',
					yAxisID: 'y-axis-2'
				}, {
					type: 'bar',
					label:  this.graphData.map(node=>node.barLabel),
					data: this.graphData.map(node=>node.barData),
					backgroundColor: '#71B37C',
					borderColor: '#71B37C',
					hoverBackgroundColor: '#71B37C',
					hoverBorderColor: '#71B37C',
					yAxisID: 'y-axis-1'
				} ]
			};
		},
		chartOptions() {
			var self = this;
			return{
				responsive: true,
				tooltips: {
					mode: 'label'
				},
				elements: {
					line: {
						fill: false
					}
				},
				scales: {
					xAxes: [{
						display: true,
						gridLines: {
							display: false
						},
					}],
					yAxes: [{
						type: 'linear',
						display: true,
						position: 'left',
						id: 'y-axis-1',
						gridLines:{
							display: false
						},
					}, {
						type: 'linear',
						display: true,
						position: 'right',
						id: 'y-axis-2',
						gridLines:{
							display: false
						},
					}]
				}
			};
		}
	},
	mounted() {
		this.renderChart(this.chartData,this.chartOptions);
	}
};
</script>
