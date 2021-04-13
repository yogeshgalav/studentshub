<template>
  <div>
    <div
      v-for="reply in replies"
      :key="reply.id"
      class="card-body mt-2"
    >
      <div class="row">
        <div class="dashboard_post">
          <div class="avatar">
            <profile-image
              :avatar="reply.avatar_url"
              :user-name="reply.user_name"
            />
          </div>
        </div>
        <div
          class="col-md-10 ml-2"
          style="background-color: #f2f2f2; border-radius: 10px;"
        >
          <h5>{{ reply.user_name }}</h5>
          <p>{{ reply.content }}</p>
        </div>
      </div>
    </div>
    <div
      class="mt-3"
      style="padding-left: inherit;"
    >
      <div
        class="dashboard_post"
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
      <input
        type="text"
        placeholder="Reply to this message"
        class="col-10"
        style="font-size: 20px; border-radius: 20px; border: 0; margin-right: 20px; outline: none; box-shadow: #80808069 2px 2px 2px, #80808094 2px 2px 2px inset;"
        @keyup.enter="saveReply($event, message)"
      >
      <i
        class="fa fa-paper-plane ml-2"
        aria-hidden="true"
        style="font-size: 25px; color: gray; cursor: pointer;"
      />
    </div>
  </div>
</template>

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

<style>

</style>