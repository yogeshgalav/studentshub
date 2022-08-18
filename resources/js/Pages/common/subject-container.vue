<template>
  <section>
    <form @submit.prevent="addsubject">
      <div class="row">
        <div class="col-md-10 col-sm-12">
          <div>
            <div class="card mb-2">
              <div class="card_post">
                <div class="card-body">
                  <div class="">
                    <div>
                      <input
                        id="subject_name"
                        v-model="subject_name"
                        v-validate="'required'"
                        name="subject_name"
                        class="form-control"
                        type="text"
                        placeholder="Enter Subject Name"
                        style="border: 0px;"
                      ><span class="error">{{ formErrors('subject_name') }}</span>
           
            
                      <div class="mt-3">
                        <button
                          v-if="subject_name"
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
              <img
                class="search-not-found"
                src="/images/search-not-found.png"
              >
              <p style="text-align:center;">
                <slot name="empty">
                  Currently no subject have been shared.
                </slot> 
              </p>
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
			current_page: 1,
			subject_name:'',
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
			this.axios.post('/api/'+this.dashboardType+'/'+this.dashboardId+'/add-subject',{
				subject_name:this.subject_name,
				dashboard_id:this.dashboardId,
			}).then((resp)=>{
				this.showLoader = false;
				this.subjects_data.unshift({
					id:resp.data.success.subject.id,
					myvote:null,
					subject_name:resp.data.success.subject.subject_name,
					total_downvotes:0,
					total_upvotes:0,
				});
				this.subject_name ='';
			});
    		},
	}

};
</script>
