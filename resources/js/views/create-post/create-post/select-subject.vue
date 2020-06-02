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
                    <div class="text-center"> <p class="title weight-600 font-size-16 text-black">What is the subject of your Post.</p></div>
                    <label class="weight-500">Subject</label>
                    <div class="input_icon_frm">
                        <span class="icon_design_input"><i class="fa fa-file" aria-hidden="true"></i></span>
                        <input type="text" @input="editSubject" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Does this Post belongs to your Course?</label>
                    <input type="radio" id="yes" value="yes" v-model="is_course_subject">
                    <label for="yes">Yes</label>
                    <input type="radio" id="no" value="no" v-model="is_course_subject">
                    <label for="no">No</label>
                </div>
                <div class="form-group" v-if="is_course_subject==='no'">
                    <label> {{ 'Category' }} </label>
                  <div class="inner-addon left-addon">
                   <div class="input_icon_frm">
                        <span class="icon_design_input"><i class="fa fa-file" aria-hidden="true"></i></span>
                    <select class="form-control" v-model="selected_category">
                        <option value="">Select Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>
                   </div>
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                 <div class="creat_post_btn">
                    <button type="button" @click="prevTab" class="login_btn"><span><i class="fa fa-arrow-left" aria-hidden="true"></i></span> Back </button>
                    <button type="button" @click="nextTab" class="login_btn">Next <span><i class="fa fa-arrow-right" aria-hidden="true"></i></span></button>
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
.creat_post_btn {
    margin-top: 30px;
}
.creat_post_btn button {
    margin: 0px 15px 0px 0;
}

.creat_post_btn {
    display: flex;
    /* margin-top: 22px; */
    justify-content: space-between;
}
button.login_btn span {
    margin: 0px 5px;
}
.creat_post_card .form-control
{
    border-radius: 0;
      transform: inherit;
    }
    button.chnage_cat {
    background-color: blue;
    border: none;
    color: white;
    padding: 10px;
    border-radius: 5px;
  
}
</style>
<script>
import {mapState} from 'vuex';
import EventBus from '../event-bus';
export default {
    computed:{
		...mapState({
			'categories': state=>state.categories,
			'AuthUserCategory': state=>state.AuthUserCategory,
			'subject': state=>state.new_post.subject,
        }),
    },
    data(){
        return {
            is_course_subject:'yes',
            selected_category:'',
            subject_name:'',
        };
    },
    mounted(){
        EventBus.$on('validateStep3',()=>{
			this.$validator.validate().then(valid => {
				if(valid){
                    this.$store.commit('set_post_subject',{
                        'is_course_subject':this.is_course_subject,
                        'subject_name':this.subject_name,
                        'selected_category':this.selected_category
                        });
					EventBus.$emit('validateWizard',3,true);
				}else{
					EventBus.$emit('validateWizard',3,false);
				}
			});
        });
        
        this.selected_category= this.AuthUserCategory;
    },
    methods:{
        editSubject(event){
            this.subject_name=event.target.value;
        },
        getSubject(subject_id){
            this.$store.dispatch('getSubjectList',{subject_id:subject_id});
        },
        nextTab(){
            EventBus.$emit('nextTab');
        },
        prevTab(){
            EventBus.$emit('prevTab');
        },
    }
}
</script>
