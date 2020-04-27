<template>
<div class="row">
     <div class="col-md-8 offset-2">
                
                <div class="form-group">
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Give an attractive Heading to your Post.</p></div>
                    <label class="weight-500">Heading</label>
                    <input type="text" class="form-control" v-model="heading">
                </div>
            
               
            </div>
</div>
  
</template>
<script>
import EventBus from '../event-bus';
export default {
    mounted(){
        EventBus.$on('validateStep4',()=>{
			this.$validator.validate().then(valid => {
				if(valid){
                    this.$store.commit('set_post_heading',{'post_heading': this.heading});
					EventBus.$emit('validateWizard',4,true);
				}else{
					EventBus.$emit('validateWizard',4,false);
				}
			});
		});
    },
    data(){
        return{
            heading:'',
        };
    }
}
</script>
