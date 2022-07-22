<template>
  <section>
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
  </section>
</template>
<script>
import SubjectCard from '../subject/SubjectCard.vue';
export default {
  	components: {
		SubjectCard
	},
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
		console.log(this.subjects);		
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
		}
	}

};
</script>
