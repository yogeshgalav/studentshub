<template>
  <div>
    <hr>
    <div
      v-for="reply in replies"
      :key="reply.id"
      class="card-body"
    >
      <div class="row">
        <div class="dashboard_post">
          <div class="avatar">
            <profile-image
              :avatar="reply.avatar_url"
              :user-name="reply.user_name"
              size="small"
            />
          </div>
        </div>
        <div
          class="col-md-10 ml-2 row row-cols-1 pt-2 pb-2"
          style="background-color: #f2f2f2; border-radius: 10px;"
        >
          <h5 class="pb-0 mb-0">
            {{ reply.user_name }}
          </h5>
          <p class="mb-0">
            {{ reply.content }}
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
          <p class="usernamedash mb-0 dash_user_date">
            {{ AuthUser.full_name }}
          </p>
          <p class="usernamedash mb-0">
            {{ message.classroom_name }}
          </p>
        </div> -->
      </div>
      <div
        class="row col-md-10 align-items-center p-0"
        style="background-color: #f0f2f5; border-radius: 20px;"
      >
        <input
          type="text"
          placeholder="Reply to this message"
          class="col-11 col-md-11 message-reply"
          @keyup.enter="saveReply($event, message)"
        >
        <i
          class="far fa-paper-plane col-md-1"
          style="font-size: 25px; color: gray; cursor: pointer;"
        />
      </div>
    </div>
  </div>
</template>
<style scoped>
.message-reply, .message-reply:focus{
  font-size: 20px; border-radius: 20px; border: none !important; outline: none; background-color: #f0f2f5;
}
.card-body{
  padding-top: 0;
  padding-bottom: 20px;
}
</style>
<script>
export default {
	props:['message'],
	data(){
		return {
			replies:[],
		};
	},
	mounted(){
		this.getReply(this.message);
	},
	methods:{
		saveReply(e, message){
			this.$validator.validate().then((valid) => {
        	if(valid){
					this.axios.post('/api/add-message',
						{
							parent_message_id:message.id,
							content:e.target.value,
							classroom_id:message.classroom_id,
						}).then((resp)=>{
						this.replies.push({
							'id':resp.data.success.message.id,
							'content':resp.data.success.message.content,
							'created_at':resp.data.success.message.created_at,
							'user_name':this.AuthUser.full_name,
							'avatar_url':this.AuthUser.avatar_url,
							'classroom_id': this.message.classroom_id,
							'classroom_name': this.message.classroom_name,
							'total_likes':0,
							'time':'Just now'});
					});
				}
			});
		},
		getReply(message){
			this.axios.get('/api/message/'+ message.id +'/get-replies')
				.then((resp) => {
					this.replies=resp.data.success.messages;
				});
		},
	}
};
</script>

