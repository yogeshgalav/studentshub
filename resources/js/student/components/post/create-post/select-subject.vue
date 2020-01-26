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
            </div>
        </div>
   
</template>
<script>
import {mapState} from 'vuex';
import AutoComplete from './../../../../components/AutoComplete';
import FormMixin from '../../../../components/mixins/form-mixin.js';
import EventBus from '../event-bus';
export default {
    mixins: [FormMixin],
    components:{
        AutoComplete
    },
    computed:{
		...mapState({
			'primary_subject_list': state=>state.new_post.primary_subject_list,
			'subject_list': state=>state.new_post.subject_list,
			'selected_subject': state=>state.new_post.selected_subject,
		}),
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
