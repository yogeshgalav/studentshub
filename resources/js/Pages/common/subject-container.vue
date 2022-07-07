<template>
  <section>
    <div class="row">
      <div class="col-md-12">
        <h1>Create Subject</h1>
      </div>
    </div>
    <hr>
    <form @submit.prevent="addsubject">
      <div class="row">
        <div class="col-md-5 col-10">
          <div class="form-group m-0-a">
            <label for="subject_name">Subject</label>
            <input
              id="subject_name"
              v-model="subject_name"
              v-validate="'required'"
              name="subject_name"
              class="form-control"
              type="text"
              placeholder="Enter Subject Name"
            ><span class="error">{{ formErrors('subject_name') }}</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="p-3">
          <button
            type="submit"
            class="btn btn-primary btn-md"
          >
            Submit
          </button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-10 col-sm-12">
          <div v-if="!subjects.length">
            <slot name="empty">
              Currently no subject have been shared.
            </slot> 
          </div>
          <div id="infinite-list">
            <div
              v-for="(subject,index) in subjects"
              :key="index"
            >
              <subject-card
                :subject="subject"
              />
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>
</template>
<script>
import SubjectCard from '../subject/SubjectCard.vue';
import FormMixin from '@/components/mixins/form-mixin.js' ;
export default {
  	components: {
		SubjectCard
	},
	mixins: [FormMixin],
	props:['categoryId'],
	data() {
		return{
			edit_category: 14,
			subjects:'',
			showLoader: false,
			current_page: 1
		};
       
	},
    	mounted() {
		this.axios
			.get('/api/search-subject?categoryId='+this.categoryId)
			.then(resp => {
				this.subjects = resp.data.success.subjects;
			});
      
	},
	methods:{
		addsubject(){
			let loader = this.$loading.show();
      	this.axios.post(this.baseUrl + '/api/add-subject',{
    			subject_name:this.subject_name,
				category_id:this.categoryId,
    		} )
    			.then(resp => {
    			window.location.reload();
    			});
    		},
	},

};
</script>
