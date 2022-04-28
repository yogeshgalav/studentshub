<template>
  <div class="row">
    <div class="col-md-12">
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :width="250"
        :is-full-page="true"
      />
      
      <div>
        <h1>{{chatroom.name}}</h1>
        <hr>
      </div>
      
      <div>
        <div
          class="row"
        >
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-3 col-12">
                <div class="mt-2 mb-2">
                  <button
                    type="button"
                    class="btn btn-primary btn-lg "
                    data-toggle="modal"
                    data-target="#addMessageModal"
                  >
                    <i class="fas fa-plus" />&nbsp;&nbsp;Add Message
                  </button>
                </div>
              </div>
              <div class="col-md-3 col-12 mb-2">
                <div class="row">
                  <social-sharing
                    :url="
                      AuthUser.full_name + ' has invited you to join chatroom '+ chatroom.name+' click the link below to join now \n '+ baseUrl + '/get-started?chatId=' + chatroom.id
                    "
                    inline-template
                  >
                    <div class="">
                      <network network="whatsapp">
                        <button
                          type="button"
                          class="btn btn-success btn-lg "
                        >
                          <i class="fab fa-whatsapp" />&nbsp;&nbsp;Share
                        </button>
                      </network>
                    </div>
                  </social-sharing>
                </div>
              </div>
            </div>
            <modal
              ref="editMessageModal"
              name="editMessageModal"
              heading="Edit Message"
              classes="modal-md"
              @submit="editMessage"
            >
              <template slot="modalBody">
                <form data-vv-scope="edit_message_form">
                  <label class="text-black font-size-14">Edit Message </label>
                  <input
                    id="edit_message"
                    v-model="edit_message.content"
                    v-validate="'required'"
                    name="edit_message"
                    type="text"
                    class="form-control"
                    placeholder="Enter your Message"
                  >
                  <span class="error">{{ formErrors('edit_message_form.edit_message') }}</span>
                </form>
              </template>
            </modal>
            <div class="">
              <div
                v-if="!messages.length"
                class="card"
              >
                <div class="card-body">
                  <div class="col-md-10">
                    <p>
                      {{ "Currently no message has been added." }}
                    </p>
                  </div>
                </div>
              </div>
              <div
                v-for="(message,index2) in messages"
                :key="index2"
                class="card mb-2"
              >
                <div class="card-body">
                  <div>
                    <div class="dashboard_post">
                      <div class="avatar">
                        <profile-image
                          :avatar="message.avatar_url"
                          :user-name="message.user_name"
                        />
                      </div>
                      <div class="info-post ml-2 dash_insititue_name">
                        <p class="font-size-14 mb-0 dash_user_date">
                          {{ message.user_name }} <span> {{ message.time }} &nbsp; 
                          </span>
                        </p>
                      </div>
                    </div>
                    <hr>
                    <p>{{ message.content }}</p>
                  </div>
                  <hr>
                  <interaction-component
                    :user-like="message.user_like ? true : false"
                    :total-likes="message.total_likes"
                    :likable-id="message.id"
                    likable-type="message"
                    :edit-access="message.user_id===AuthUser.id"
                  />
                </div>
                <div class="col-md-3 col-12" />
              </div>
            </div>

            <modal
              ref="addMessageModal"
              name="addMessageModal"
              class="model-md"
              heading="Add Message"
              @submit="saveMessage"
            >
              <template slot="modalBody">
                <form data-vv-scope="add_message_form">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <div class="inner-addon left-addon">
                          <div class="cl_input">
                            <label for="message">Message</label>
                            <input
                              id="messageContent"
                              v-model="content"
                              v-validate="'required'"
                              name="message"
                              class="form-control"
                              placeholder="write message here"
                            >
                            <span class="text-danger">{{
                              formErrors("add_message_form.message")
                            }}</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </template>
            </modal>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
#dropdownMenuButton{
  border: none;
}
</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
// import AddButton from '../../components/AddButton';
import ProfileImage from '../../components/ProfileImage.vue';
import Modal from '../../components/VueNiceModal.vue';
import ClassroomHeader from '../../components/ClassroomHeader';
import InteractionComponent from '../common/InteractionComponent';
import SocialSharing from 'vue-social-sharing';

export default {
	components: {
		// AddButton,
		ClassroomHeader,
		ProfileImage,
		Modal,
		InteractionComponent,
		SocialSharing,
	},
	mixins: [FormMixin],
	props:['chatroom'],
	data() {
		return {
			showLoader: true,
			messages: [],
			content: '',
			edit_message:{
				id:'',
				content:'',
			},
		};
	},
	
	mounted() {
		this.getMessages();
	},
	methods: {
		getMessages() {
			let api = '/api/chatroom-messages/'+ this.chatroom.id;
			this.axios.get(api).then((resp) => {
				this.messages = resp.data.success.messages.map(node=>{
					node.show_reply= false;
					return node;
				});
				this.showLoader = false;
			});
		},

		addMessage() {
			this.$modal.show('addMessageModal');
		},
		saveMessage(chatroom) {
			
			this.validateForm('add_message_form').then((valid) => {
				if (valid) {
					//call api and update field
					this.axios
						.post(
							'/api/add-message/'+this.chatroom.id,
							{
								content: this.content,
							}
						)
						.then((resp) => {
							
							this.messages.push({
								'id':resp.data.success.message.id,
								'content':resp.data.success.message.content,
								'created_at':resp.data.success.message.created_at,
								'user_name':this.AuthUser.full_name,
								'avatar_url':this.AuthUser.avatar_url,
								'chatroom_id': this.chatroom.id,
								'total_likes':0,
								'time':'Just now'});
							this.$refs.addMessageModal.closeModal();
							this.content = '';
						});
				}
			});
		},
		editMessage(e, message){
			this.validateForm('edit_message_form').then((valid)=>{
			  if(valid){
			    this.axios.post('/api/edit-message',{
						message_id:this.edit_message.id,
						content:this.edit_message.content
			    }).then((resp) => {
						window.location.reload();
					});
			  }
			});
		},
		deleteMessage(messageId){
			this.axios.post('/api/delete-message',{
				message_id:messageId,
			}).then((resp)=>{
				window.location.reload();
			});
		},
	},
};
</script>
