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
                <div v-if="!subjects_data.length">
                  <slot name="empty">
                    Currently no subject have been shared.
                  </slot> 
                </div>
                <div id="infinite-list">
                  <div
                    v-for="(subject,index) in subjects_data"
                    :key="index"
                  >
                    <subject-card
                      :subject="subject"
                    />
                  </div>
                </div>
              </div>
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
	props:['categoryId','subjectRoute'],
	data() {
		return{
			subjects_data: [],
			subjects:[],
			showLoader: false,
			current_page: 1
		};
       
	},
    	mounted() {
		this.loadSubjects();
	},
	
  	methods: {
		loadSubjects(){
			const route= this.subjectRoute ? this.subjectRoute+'/subjects' : '/subjects';
			const url= new URL(this.baseUrl+'/api'+route);
			this.showLoader = true;

			url.searchParams.set('page', this.current_page);
			this.current_page=this.current_page+1;

			this.axios.get(url.toString())
				.then(resp => {
					const subjects = resp.data.success.subjects;
					this.subjects_data = this.subjects_data.concat(subjects.data);
		            this.current_page = this.current_page;
					this.showLoader = false;
				})
				.catch(err => {
					this.showLoader = false;
				});
		},
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
	}

};
</script>
