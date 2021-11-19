<template>
  <div>
    <div
      v-if="AuthUser"
      class="row"
    >
      <div class="col-md-4 col-6"> 
        <button
          type="button"
          class="btn"
          @click="sendUserLike()"
        >
          <p
            v-if="like_active"
            class="text-primary pl-3 pr-3"
          >
            <span><i class="fas fa-thumbs-up text-primary" />&nbsp;</span>
            {{ totallikes }} Like
          </p>
          <p 
            v-else-if="totallikes===0"
          >
            <span><i class="far fa-thumbs-up" />&nbsp;</span>
            Like
          </p>
          <p v-else>
            <span><i class="far fa-thumbs-up" />&nbsp;</span>
            {{ totallikes }} Like
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
        :commentable-id="likableId"
        :commentable-type="likableType"
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
		'userLike':{
			'type':Boolean,
			'required':false,
			'default':false,
		},
		'totalLikes':{
			'type':Number,
			'required':true,
			'default':0,
		},
		'likableId':{
			'type':Number,
			'required':true,
		},
		'likableType':{
			'type':String,
			'required':true,
		},
		'editAccess':{
			'type':Boolean,
			'required':false,
			'default':false
		},
	},
	data(){
		return {
			like_active:false,
			comment_active:false,
			totallikes:0,
			comments:[],
			comment_text:'',
		};
	},
	watch: {
		userLike: function() {
			// this.user_like = this.postContent.user_like;
			this.totallikes = this.totalLikes;
			if(this.userLike === 1){
				this.like_active = true;
			}else{
				this.like_active = false;
			}
		}
	},
	mounted(){
		this.totallikes = this.totalLikes;
		if(this.userLike === true){
			this.like_active = true;
		}else{
			this.like_active = false;
		}
	},
	methods:{
		sendUserLike() {
			this.like_active = !this.like_active;
			if(this.like_active){	
				this.totallikes += 1;
			}
			else if(!this.like_active){
        	this.totallikes -= 1;
			}
			this.axios.post('/api/'+this.likableType+'/'+this.likableId+'/like').catch(err => {
				this.like_active = !this.like_active;
			});
		},
		toggleComment(){
			this.comment_active = !this.comment_active;
		},
	}
};
</script>

