import Vue from 'vue';
import VeeValidate  from 'vee-validate';
Vue.use(VeeValidate);

const FormMixin = {
	components:{
		VeeValidate
	},
	data(){
		return{
			form_errors:[],
		};
	},
	methods:{
		collectErrors:function(field){
			if(this.form_errors){
				return this.form_errors.flatMap(node=>node);
			}
		},
		formErrors:function(field){

			if ( ! this.form_errors ) {
				return null;
			}

			if(this.form_errors[field]){
				return this.form_errors[field][0];
			}else if(this.errors.collect(field).length>0){
				let err_msg=this.errors.first(field);
				//remove string between #
				if(err_msg.indexOf('#') >= 0){
					let split_msg=err_msg.split('#');
					err_msg=split_msg[0]+' '+split_msg[2];
				}
				if(err_msg.indexOf('form_data.') >= 0){
					err_msg=err_msg.replace('form_data.', '');
				}
				return err_msg.replace(/_/g, ' ');
			}else{
				return null;
			}
		}
	}
};
export default  FormMixin;
