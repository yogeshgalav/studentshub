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
		lineLabel:{
			type:String,
			default: ''
		},
		barLabel:{
			type:String,
			default: ''
		},
		lineData:{
			type:Array,
			default: () => []
		},
		barData:{
			type:Array,
			default: () => []
		},
		xAxisLabels:{
			type:Array,
			default: () => []
		},
	},
	computed:{
		chartData(){
			const self = this;
			return  {
				labels: this.xAxisLabels,
				datasets: [ {
					label: this.lineLabel,
					type:'line',
					data: this.lineData,
					fill: false,
					borderColor: this.reportColorCodes[1],
					backgroundColor: this.reportColorCodes[1],
					pointBorderColor: this.reportColorCodes[1],
					pointBackgroundColor: this.reportColorCodes[1],
					pointHoverBackgroundColor: this.reportColorCodes[1],
					pointHoverBorderColor: this.reportColorCodes[1],
					yAxisID: 'y-axis-2'
				}, {
					type: 'bar',
					label: this.barLabel,
					data: this.barData,
					backgroundColor: this.reportColorCodes[0],
					borderColor: this.reportColorCodes[0],
					hoverBackgroundColor: this.reportColorCodes[0],
					hoverBorderColor: this.reportColorCodes[0],
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
