<template>
  <div class="row">
    <div class="col-md-12">
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :width="250"
        :is-full-page="true"
      />
      <div class="row">
        <div class="col-md-12">
          <h1>Chatroom</h1>
          <hr>
        </div>
      </div>
     
        
      <div class="">
        <div class="col-md-3 col-12 pl-0">
          <div class="mt-2 mb-2">
            <button
              type="button"
              class="btn btn-primary btn-lg "
              data-toggle="modal"
              data-target="#addChatroomModal"
              @click="createChatroom()"
            >
              <i class="fas fa-plus" />&nbsp;&nbsp;Add Chatroom
            </button>
          </div>
        </div>
        <div class="col-md-3 col-12" />
      </div>
      <modal
        ref="addChatroomModal"
        name="addChatroomModal"
        class="model-md"
        heading="Add Chatroom"
        @submit="saveChatroom"
      >
        <template slot="modalBody">
          <form data-vv-scope="add_chatroom_form">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <div class="inner-addon left-addon">
                    <div class="cl_input">
                      <label for="chatroom">Chatroom Name</label>
                      <input
                        id="chatroomName"
                        v-model="chatroom_name"
                        v-validate="'required'"
                        name="chatroom"
                        class="form-control"
                        placeholder="write Chatroom Name here"
                      >
                      <span class="text-danger">{{
                        formErrors("add_chatroom_form.chatroom")
                      }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </template>
      </modal>
      <div v-if="chatrooms.length">
        <div 
          class="row"
        >
          <div
            v-for="(chatroom, index) in chatrooms"
            :key="index"
            class="col-md-4 mb-2"
          >
            <router-link
              :href="'/messages/'+chatroom.id"
              class="card rounded-lg pt-3 pb-3 bg-light text-center"
            >
              <div style="text-align: -webkit-center;">
                <profile-image
                  :user-name="chatroom.chatroom_name"
                  size="large"
                />
              </div>
              <h3 class="font-weight-bold text-info font-weight-bold">
                {{ chatroom.chatroom_name }}
              </h3>
            </router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
#profileImage{
  margin:auto !important;
}
</style>
<script>
import Modal from '../../components/VueNiceModal.vue';
import FormMixin from '../../components/mixins/form-mixin.js';


export default {
	components:{
		Modal,
		
	},
	mixins: [FormMixin],
	data() {
		return {
			showLoader: true,
			chatroom_name: '',
			chatrooms:[],
		};
	},
	
	mounted(){
		this.getchatroom();
	},
	methods:{
		getchatroom() {
			this.axios.post('/api/chatroom').then((resp) => {
				this.chatrooms = resp.data.success.chatrooms;
       	this.showLoader = false;
			});
		},
    	addChatroom() {
			this.$modal.show('addChatroomModal');
		},
    	saveChatroom() {
			this.validateForm('add_chatroom_form').then((valid) => {
				if (valid) {
					//call api and update field
					this.axios
						.post(
							'/api/add-chatroom',
							{
								chatroom_name: this.chatroom_name,
							}
						)
						.then((resp) => {
							window.location.href = '/chatroom';
						});
				}
			});
		},
	}
};
</script>

