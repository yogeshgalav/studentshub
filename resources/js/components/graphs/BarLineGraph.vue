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
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					type: 'bar',
					label: 'Visitor',
					data: [200, 185, 590, 621, 250, 400, 95],
					fill: false,
					backgroundColor: '#71B37C',
					borderColor: '#71B37C',
					hoverBackgroundColor: '#71B37C',
					hoverBorderColor: '#71B37C',
					yAxisID: 'y-axis-1'
				}, {
					label: 'Sales',
					type:'line',
					data: [51, 65, 40, 49, 60, 37, 40],
					fill: false,
					borderColor: '#EC932F',
					backgroundColor: '#EC932F',
					pointBorderColor: '#EC932F',
					pointBackgroundColor: '#EC932F',
					pointHoverBackgroundColor: '#EC932F',
					pointHoverBorderColor: '#EC932F',
					yAxisID: 'y-axis-2'
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
						labels: {
							show: true,
						}
					}],
					yAxes: [{
						type: 'linear',
						display: true,
						position: 'left',
						id: 'y-axis-1',
						gridLines:{
							display: false
						},
						labels: {
							show:true,
                        
						}
					}, {
						type: 'linear',
						display: true,
						position: 'right',
						id: 'y-axis-2',
						gridLines:{
							display: false
						},
						labels: {
							show:true,
                        
						}
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
