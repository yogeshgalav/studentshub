<template>
  <div class="creat_post_card img_der">
<div class="row">
    <div class="col-md-6">
                <div class="login_img">
                    <img src="/images/undraw_post_online_dkuk.svg" alt="">
                </div>   
            </div>
     <div class="col-md-6">
                 <div class="logn_right">
                
                <div class="form-group">
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Give an attractive Heading to your Post.</p></div>
                    <label class="weight-500">Heading</label>
                    <div class="input_icon_frm">
                        <span class="icon_design_input"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" v-model="heading">
                    </div>
                </div>
                 <div class="creat_post_btn">
                     <button type="button" @click="prevTab" class="login_btn"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span> Back </button>
                <button type="button" @click="nextTab" class="login_btn">Finish <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></button>
                </div>
                 </div>
            </div>
</div>
  </div>
  
</template>
<style  scoped>
.login_img img {
    width: 70%;
    margin: 0 auto;
}
.creat_post_btn button {
    margin: 0px 15px 0px 0;
}
button.login_btn span {
    margin: 0px 5px;
}
.creat_post_btn {
    margin-top: 30px;
}

.creat_post_btn {
    display: flex;
    /* margin-top: 22px; */
    justify-content: space-between;
}
.creat_post_card .form-control
{
    border-radius: 0;transform: inherit
    }
</style>
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
    },
    methods:{
        nextTab(){
            EventBus.$emit('nextTab');
        },
        prevTab(){
            EventBus.$emit('prevTab');
        },
    }
}
</script>
