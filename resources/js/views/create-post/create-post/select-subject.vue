<template>
<div class="row">
            <div class="col-md-8 offset-2">
                
                <div class="form-group">
                    <div class="text-center"> <p class="title weight-600 font-size-16 text-black">What is the subject of your Post.</p></div>
                    <label class="weight-500">Subject</label>
                    <div class="row">
                        <input type="text" :value="selected_subject.Subject_name" @input="editSubject" class="form-control">
                    </div>
                </div>
                <div class="form-group" v-if="AuthUserCategory">
                    <label> {{ 'Category/Course Type' }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <base-select
                    ref="baseSelect"
                    v-model="selected_category"
                    value="AuthUserCategory"
                    :options="categories"
                    :options-limit="10"
                    :show-labels="false"
                    :preserve-search="false"
                    :placeholder="'select category'"
                    label="name"
                    class="multi-select-item"
                    />
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
            </div>
        </div>
   
</template>
<script>
import {mapState} from 'vuex';
import EventBus from '../event-bus';
export default {
    computed:{
		...mapState({
			'categories': state=>state.categories,
			'AuthUserCategory': state=>state.AuthUserCategory,
			'selected_subject': state=>state.new_post.selected_subject,
        }),
    },
    data(){
        return {
            selected_category:'',
        };
    },
    mounted(){
        EventBus.$on('validateStep3',()=>{
			this.$validator.validate().then(valid => {
				if(valid){
					EventBus.$emit('validateWizard',3,true);
				}else{
					EventBus.$emit('validateWizard',3,false);
				}
			});
		});
    },
    methods:{
        editSubject(event){
            console.log('1',event.target.value)
            this.$store.dispatch('createPost',{field:'post_subject',subject_name:event.target.value});
        },
        getSubject(subject_id){
            this.$store.dispatch('getSubjectList',{subject_id:subject_id});
        }
    }
}
</script>
