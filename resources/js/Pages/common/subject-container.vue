<template>
  <section>
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
              :user-id="userId"
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
	props:['subjects','userId'],
	data() {
		return{
			showLoader: false,
			current_page: 1
		};
       
	},
    	mounted() {
		
	},

};
</script>
