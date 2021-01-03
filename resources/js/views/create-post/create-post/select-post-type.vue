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
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Select Post Type</p></div>
                    <label class="weight-500">Choose type</label>
                    <div class="input_icon_frm">
                        <span class="icon_design_input"><i class="fa fa-newspaper" aria-hidden="true"></i></span>
                    <select class="form-control custom-select" v-model="selected_type">
                        <option value="article">Article</option>
                        <option value="fact">Fact</option>
                        <option value="mcq">MCQ</option>
                        <option value="video">Youtube video</option>
                    </select>
                    </div>
                    <span>{{info_text[selected_type]}}</span>
                </div>
                <div class="creat_post_btn">
                <button type="button" @click="nextTab" class="login_btn">Next <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></button>
                </div>
                </div>
            </div>
        </div>
         </div>
</template>
<style scoped>
.post-type{
    margin: 50%;
}
.login_img img {
    width: 70%;
    margin: 0 auto;
}
.creat_post_card {
    background-color: white;
    margin-top: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
}
.creat_post_card .row {
    align-items: center;
}
button.login_btn span {
    margin: 0px 5px;
}
.creat_post_btn {
    margin-top: 30px;
}
.creat_post_card .form-control
{
    border-radius: 0;
      transform: inherit;
    }
</style>

<script>
import EventBus from '../event-bus';
export default {
    props:['newPost'],
    data(){
        return{
            selected_type:this.newPost.post_type,
            info_text:{
                'article':'A Blog Article of minimum 400 words enriched with Rich Text Content and Media.',
                'fact':'A Short Information supported by an Image.',
                'mcq':'A Question with 4 choices and its Answer.',
                'video':'An url of Youtube Video with short Description.'
            }
        }
    },
    mounted(){
        EventBus.$on('validateStep1',()=>{
			// this.$validator.validate().then(valid => {
			// 	if(valid){
                    this.$store.commit('set_post_type', {'post_type':this.selected_type});
					EventBus.$emit('validateWizard',1,true);
				// }else{
				// 	EventBus.$emit('validateWizard',1,false);
				// }
			// });
		});
    },
    methods:{
        nextTab(){
            EventBus.$emit('nextTab');
        },
    }
}
</script>
