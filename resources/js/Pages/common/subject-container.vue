<template>
  <section>
    <form @submit.prevent="addsubject">
      <div class="row">
        <div class="col-md-10 col-sm-12">
          <div class="form-group m-0-a">
            <div class="card mb-2">
              <div class="card_post">
                <div class="card-body">
                  <div class="dashboard_post">
                    <div>
                      <label
                        class="p-3"
                        for="subject_name"
                      >Subject</label>
                      <input
                        id="subject_name"
                        v-model="subject_name"
                        v-validate="'required'"
                        name="subject_name"
                        class="form-control"
                        type="text"
                        placeholder="Enter Subject Name"
                      ><span class="error">{{ formErrors('subject_name') }}</span>
           
            
                      <div class="p-3">
                        <button
                          type="submit"
                          class="btn btn-primary btn-md"
                        >
                          Submit
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
	props:['subjectRoute','dashboardId','dashboardType'],
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
			this.showLoader = true;
			//let loader = this.$loading.show();
			this.axios.post('/api/'+this.dashboardType+'/'+this.dashboardId+'/add-subject',
				{
					subject_name:this.subject_name,
					dashboard_id:this.dashboardId,
				}).then((resp)=>{
				this.showLoader = false;
			});
    		},
	}

};
</script>
