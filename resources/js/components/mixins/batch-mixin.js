import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';


const BatchMixin = {
	components:{
		DatePicker
	},
	computed:{
		yearError(){
			var d = new Date();
			var n = d.getFullYear();
			if(this.start_year>n){
				return 'Please enter currect start year.';
			}else if(this.end_year && this.end_year<this.start_year){
				return 'Please enter currect start and end year.';
			}
			return '';
		}
	},
	data(){
		return{
			end_year: '',
			start_year: '',
		};
	}
};
export default  BatchMixin;
