<template>
<div class="row">
            <div class="col-md-8 offset-2">
                
                <div class="form-group">
                    <div class="row">
                        <input type="text" :value="selected_subject.Subject_name" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card" v-for="subject in primary_subject_list" :key="subject.id">{{subject.Subject_name}}</div>
                        </div>
                        <div class="col-md-8">
                            <div class="card" v-for="subject in subject_list" :key="subject.id">
                                <div class="card-body" @click="getSubject(subject.id)">
                                {{subject.Subject_name}}
                                </div>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>
        </div>
   
</template>
<script>
import {mapState} from 'vuex';
import AutoComplete from './../../../../components/AutoComplete';

export default {
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
    methods:{
        editSubject(event){
            this.$store.dispatch('createPost',{field:'post_subject',post_subject:event.target.value});
        },
        getSubject(subject_id){
            this.$store.dispatch('getSubjectList',{subject_id:subject_id});
        }
    }
}
</script>
