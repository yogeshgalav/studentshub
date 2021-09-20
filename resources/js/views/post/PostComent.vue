<template>
  <div>
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
</template>

<script>
export default {
	name: postComent,
	data(){
		return{
			comments:[],
			comment_text:'',
		};
	},
	mounted(){
		this.axios.get('/api/'+this.likableType+'/'+this.likableId+'/comment')
			.then((resp) => {
				this.comments=resp.data.success.comments;
			});
	},
	methods:{
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
	}
    

};
</script>

<style>
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