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
				labels: [
					'Absence of OB',
					'Closeness',
					'Credibility',
					'Heritage',
					'M Disclosure',
					'Provenance',
					'Reliability',
					'Transparency'
				],
				datasets: [
					{
						label: 'American Express',
						backgroundColor: 'pink',
						borderColor: 'red',
						borderWidth: 1,
						data: [3, 5, 6, 7,3, 5, 6, 7]
					},
					{
						label: 'Mastercard',
						backgroundColor: 'lightblue',
						borderColor: 'blue',
						borderWidth: 1,
						data: [4, 7, 3, 6, 10,7,4,6]
					},
					{
						label: 'Paypal',
						backgroundColor: 'lightgreen',
						borderColor: 'green',
						borderWidth: 1,
						data: [10,7,4,6,9,7,3,10]
					},
					{
						label: 'Visa',
						backgroundColor: 'yellow',
						borderColor: 'orange',
						borderWidth: 1,
						data: [6,9,7,3,10,7,4,6]
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
				title: {
					display: true,
					text: 'Chart.js Bar Chart'
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
