<script>
import { Line } from 'vue-chartjs';

export default {
	extends: Line,
	props:{
		width:{
			type:Number,
			default: 200
		},
		height:{
			type:Number,
			default: 200
		},
		lineOneData:{
			type:Array,
			default: () => []
		},
		lineTwoData:{
			type:Array,
			default: () => []
		},
		labels:{
			type:Array,
			default: () => []
		}
	},
	computed:{
		chartData(){
			var dataFirst = {
				label: 'Car A - Speed (mph)',
				data: [0, 59, 75, 20, 20, 55, 40],
				lineTension: 0,
				fill: false,
				borderColor: 'red'
			};

			var dataSecond = {
				label: 'Car B - Speed (mph)',
				data: [20, 15, 60, 60, 65, 30, 70],
				lineTension: 0,
				fill: false,
				borderColor: 'blue'
			};

			const self = this;
			return  {
				labels: ['0s', '10s', '20s', '30s', '40s', '50s', '60s'],
				datasets: [dataFirst, dataSecond]
			};
		},
		chartOptions() {
			var self = this;
			return{
				legend: {
					display: true,
					position: 'top',
					labels: {
						boxWidth: 80,
						fontColor: 'black'
					}
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
