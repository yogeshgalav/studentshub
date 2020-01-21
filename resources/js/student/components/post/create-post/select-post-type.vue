<template>
    <div class="row">
            <div class="col-md-8 offset-2">
                
                <div class="form-group">
                   <div class="text-center"> <p class="title weight-600 font-size-16 text-black">Select Post Type</p></div>
                    <label class="weight-500">Choose type</label>
                    <select class="form-control custom-select" @input="selectPostType($event)">
                        <option v-for="type in postTypes" :key="type">
                             {{type}}
                            
                        </option>
                    </select>
                </div>
               
            </div>
        </div>
</template>
<style scoped>
.post-type{
    margin: 50%;
}
</style>

<script>
import EventBus from '../event-bus';
export default {
    data(){
        return{
            postTypes:[
                'Article',
                'Fact',
                'Notice',
                'Video',
                'Quora',
                'Link',
                'MCQ',
                ],
        }
    },
    mounted(){
        EventBus.$on('validateStep1',()=>{
			// this.$validator.validate().then(valid => {
			// 	if(valid){
					EventBus.$emit('validateWizard',1,true);
				// }else{
				// 	EventBus.$emit('validateWizard',1,false);
				// }
			// });
		});
    },
    methods:{
        selectPostType(event){
           this.$store.dispatch('createPost',{field:'post_type',post_type:event.target.value});
        }
    }
}
</script>
