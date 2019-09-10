<template>
<div class="row">
            <div class="col-md-8 offset-2">
                
                <div class="form-group">
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Choose Category</p></div>
                    <label class="weight-500">Choose Category</label>
                    <auto-complete class="form-control custom-select" :items="categories" value="Subject_name" @input="selectPostType($event)" />
                        
                </div>
                <div class="form-group">
 <label class="weight-500">Select Subject</label>
<auto-complete class="form-control custom-select" @input="editSubject($event)" />
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
			'categories': state=>state.categories,
		}),
	},
    methods:{
        editSubject(event){
            this.$store.dispatch('createPost',{post_subject:event.target.value});
        }
    }
}
</script>
