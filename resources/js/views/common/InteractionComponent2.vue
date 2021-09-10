<template>
  <div>
    <div
      v-if="AuthUser"
      class="row"
    >
      <div
        v-if="AuthUser.role_intended==='student'"
        class="col-md-4 col-6"
      > 
        <button
          type="button"
          class="btn"
          @click="markAsDone()"
        >
          <p
            v-if="mark_active"
            class="text-success pl-3 pr-3"
          >
            <span><i class="fa fa-check text-success" />&nbsp;</span>
            Marked Done
          </p>
          <p v-else>
            <span><i class="fa fa-check" />&nbsp;</span>
            Mark as done
          </p>
        </button>
      </div>
      <div class="col-md-6 col-6"> 
        <button      
          type="button"
          :class="['btn pl-0', comment_active ? 'text-primary' : '']"
          @click="toggleComment()"
        >
          <p>
            <span><i
              class="far fa-comment-alt"
            />&nbsp;</span>
            Comment
          </p>
        </button>
      </div>
    </div>
    <!-- comment section -->
    <div
      v-if="comment_active"
      class="comment-body"
    >
      <hr>
      <comment-section 
        :key="Math.random()"
        :commentable-id="homeworkId"
        :commentable-type="'homework'"
      />
    </div>
  </div>
</template>

<style scoped>
button{
    border: none;
    color: gray;
    display: flex;
    height: 25px;
	margin-bottom: 10px;
	margin-top: -10px;
    background-color: #fff;
}
.single_page_user_like{
    display: flex;
}
p{
	padding: 5px 0px;
	margin-bottom: 10px;
}
p:hover{
	background-color: #f0f2f5;
}
</style>
<script>
import CommentSection from './comment-section.vue';
export default {
	components:{
		CommentSection
	},
	props:{
		'userMark':{
			'type':Boolean,
			'required':false,
			'default':false,
		},
		'homeworkId':{
			'type':Number,
			'required':true,
		},
	},
	data(){
		return {
			mark_active:false,
			comment_active:false,
		};
	},
	watch: {
		userMark: function(val) {
			// this.user_like = this.postContent.user_like;
			this.mark_active = val ? true : false;
		}
	},
	mounted(){
		this.mark_active = this.userMark ? true : false;
	},
	methods:{
		markAsDone(){
			this.mark_active = !this.mark_active;
			this.axios.post('/api/homework/'+this.homeworkId+'/mark-as-done')
				.catch(err =>{
					this.mark_active = !this.mark_active;
				});
		},
		toggleComment(){
			this.comment_active = !this.comment_active;
		},
	}
};
</script>

