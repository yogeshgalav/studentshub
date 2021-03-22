<template>
  <div>
    <button
      class="btn-link"
      type="button"
      @click="getReply(message)"
    >
      Reply
    </button>
    <div
      v-for="reply in content[0]"
      :key="reply.id"
      class="card-body"
    >
      <div class="dashboard_post">
        <div class="avatar">
          <profile-image
            :avatar="reply.avatar_url"
            :user-name="reply.user_name"
          />
        </div>
        <div class="info-post ml-2 dash_insititue_name"> 
          <p class="usernamedash mb-0 dash_user_date">
            {{ reply.user_name }} <span> {{ reply.time }}</span>
          </p>
          <p class="usernamedash mb-0">
            {{ reply.classroom_name }}
          </p>
        </div>
      </div>
      <hr>
      <p>{{ reply.content }}</p>
    </div>
    
    <div
      class="mb-2"
      style="padding-left: inherit;"
    >
      <input
        type="text"
        placeholder="Reply to this message"
        class="col-11"
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
			show_reply:false,
			content:[],
		};
	},
	methods:{
		saveReply(e, message){
			console.log(e);
			console.log(message); 
			this.$validator.validate().then((valid) => {
        	if(valid){
					this.axios.post('/api/add-message',
						{
							parent_message_id:message.id,
							content:e.target.value,
							classroom_id:message.classroom_id,
						});
				}
			});
		},
		getReply(message){
			this.show_reply=true;
			this.axios.get('/api/message/'+ message.id +'/get-replies')
				.then((resp) => {
					this.content.push(resp.data.success.messages);
					console.log(this.content);
				});
		},
	}
};
</script>

<style>

</style>