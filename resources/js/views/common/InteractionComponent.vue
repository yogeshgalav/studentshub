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
          @click="getComment()"
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
    <!-- message comment -->
    <div v-if="comment_active">
      <hr>
      <div
        v-for="comment in comments"
        :key="comment.id"
        class="card-body"
      >
        <div class="row">
          <div class="dashboard_post">
            <div class="avatar">
              <profile-image
                :avatar="comment.avatar_url"
                :user-name="comment.user_name"
                size="small"
              />
            </div>
          </div>
          <div
            class="col-md-10 ml-2 row row-cols-1 pt-2 pb-2"
            style="background-color: #f2f2f2; border-radius: 10px;"
          >
            <h5 class="pb-0 mb-0">
              {{ comment.user_name }}
            </h5>
            <p class="mb-0">
              {{ comment.comment_text }}
            </p>
          </div>
        </div>
      </div>
      <div
        class="mt-3 row"
        style="padding-left: inherit;"
      >
        <div
          class="dashboard_post col-md-1"
          style="display: inline-block;"
        >
          <div class="avatar mr-2">
            <profile-image
              :avatar="AuthUser.avatar_url"
              :user-name="AuthUser.full_name"
            />
          </div>
        <!-- <div class="info-post ml-2 dash_insititue_name"> 
          <p class="font-size-14 mb-0 dash_user_date">
            {{ AuthUser.full_name }}
          </p>
          <p class="font-size-14 mb-0">
            {{ message.classroom_name }}
          </p>
        </div> -->
        </div>
        <div
          class="row col-md-10 align-items-center p-0"
          style="background-color: #f0f2f5; border-radius: 20px;"
        >
          <input
            id="comment-input"
            v-model="comment_text"
            type="text"
            placeholder="Comment here"
            class="col-11 col-md-11 message-comment"
            @keyup.enter="savecomment($event, message)"
          >
          <div @click="savecomment">
            <i
              class="far fa-paper-plane col-md-1"
              style="font-size: 25px; color: gray; cursor: pointer;"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
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
			this.axios.post('/api/user-like/post', {
				likable_id: this.likableId,
				likable_type:this.likableType,
			}).catch(err => {
				this.like_active = !this.like_active;
			});
		},
		savecomment(){
			if(!this.comment_text){
				return false;
			}
			this.$validator.validate().then((valid) => {
        	if(valid){
					this.axios.post('/api/comment',
						{
							'commentable_id':this.likableId,
							'commentable_type':this.likableType,
							'comment_text': this.comment_text,
						}).then((resp)=>{
						this.comments.push({
							'id':resp.data.success.comment_id,
							'user_name':this.AuthUser.full_name,
							'avatar_url':this.AuthUser.avatar_url,
							'comment_text':this.comment_text,
							'time':'Just now'});
						this.comment_text = ''; 
					});
				}
			});
		},
		getComment(){
			this.comment_active = true;
			this.axios.get('/api/'+this.likableType+'/'+this.likableId+'/comment')
				.then((resp) => {
					this.comments=resp.data.success.comments;
				});
		},
	}
};
</script>

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
.message-comment, .message-comment:focus{
  font-size: 20px; border-radius: 20px; border: none !important; outline: none; background-color: #f0f2f5;
}
.card-body{
  padding-top: 0;
  padding-bottom: 20px;
}
</style>
