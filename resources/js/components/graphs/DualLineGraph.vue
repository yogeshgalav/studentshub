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
		lineOneLabel:{
			type:String,
			default:''
		},
		lineTwoLabel:{
			type:String,
			default:''
		},
		labels:{
			type:Array,
			default: () => []
		}
	},
	computed:{
		chartData(){
			var dataFirst = {
				label: this.lineOneLabel,
				data: this.lineOneData,
				lineTension: 0,
				fill: false,
				borderColor: 'red'
			};

			var dataSecond = {
				label: this.lineTwoLabel,
				data: this.lineTwoData,
				lineTension: 0,
				fill: false,
				borderColor: 'blue'
			};

			return  {
				labels: this.labels,
				datasets: [dataFirst, dataSecond]
			};
		},
		chartOptions() {
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
