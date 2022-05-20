<template>
  <section>
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <div class="card mb-3 mt-2 pt-0 pb-0">
          <div class="card-body">
            <div class="row pl-3">
              <profile-image
                size="small"
                :user-name="AuthUser.full_name"
                :avatar="AuthUser.avatar_url"
              />&nbsp;&nbsp;
              {{ AuthUser.full_name }}
            </div>
            <a
              :href="'/ask-doubt'"
            > 
              <img
                src="/images/knowledge.svg"
                alt=""
              >&emsp;
              <slot name="share">Create new subject</slot> 
              &emsp;<span><i
                class="fa fa-arrow-right"
                aria-hidden="true"
              /></span>  
            </a>
          </div>
        </div>
        <div v-if="!subjects.length">
          <slot name="empty">
            Currently no subject have been shared.
          </slot> 
        </div>
        <div id="infinite-list">
          <div
            v-for="(subject,index) in subjects"
            :key="index"
          />
          <subject-card :subject="subject" />
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
	props:['subjects','subjectRoute'],
	data() {
		return{
			showLoader: false,
			current_page: 1
		};
       
	},
    	mounted() {
		console.log('xyz', this.subject);
	},

};
</script>
