<template>
  <div class="row">
    <div class="col-md-12">
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :width="250"
        :is-full-page="true"
      />
      <classroom-header
        v-if="routeClassroomId" 
        title="Message"
      />
      <div v-else>
        <h1>Messages</h1>
        <hr>
      </div>
      <div>
        <div class="row">
          <div class="col-md-12">
            <div class="">
              <div class="col-md-3 col-12 pl-0">
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
              <div class="col-md-3 col-12" />
            </div>
            <modal
              ref="editMessageModal"
              name="editMessageModal"
              heading="Edit Message"
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
                  <div class="col-md-12">
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
                            <div
                              v-if="message.user_id===AuthUser.id"
                              class="dropdown d-inline"
                            >
                              <button
                                id="dropdownMenuButton"
                                class="btn btn-secondary dropdown-toggle p-0"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="fas fa-ellipsis-v" />
                              </button>
                              <div
                                class="dropdown-menu dropdown-menu-right"
                                style="min-width: max-content;"
                                aria-labelledby="dropdownMenuButton"
                              >
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  data-toggle="modal"
                                  data-target="#editMessageModal"
                                  @click="edit_message=message"
                                >Edit</button> 
                                <button
                                  type="button"
                                  class="dropdown-item"
                                  @click="deleteMessage(message.id)"
                                >Delete</button>
                              </div>
                            </div></span>
                        </p>
                        <p class="font-size-14 mb-0">
                          {{ message.classroom_name }}
                        </p>
                      </div>
                    </div>
                    <hr>
                    <p>{{ message.content }}</p>
                  </div>
                  <hr>
                  <like-component
                    :user-like="message.user_like ? true : false"
                    :total-likes="message.total_likes"
                    :likable-id="message.id"
                    :message="message"
                    likable-type="message"
                    :show-reply="true"
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
                    <div
                      v-if="classrooms && classrooms.length"
                      class="col-md-12"
                    >
                      <div class="form-group">
                        <div class="inner-addon left-addon">
                          <div class="cl_input">
                            <label for="classroom">Classroom</label>
                            <select
                              v-model="selectedClassroomId"
                              v-validate="'required'"
                              class="form-control custom-select"
                              name="classroom"
                            >
                              <option
                                v-for="(classroom, index) in classrooms"
                                :key="index"
                                :value="classroom.id"
                              >
                                {{ classroom.name }}
                              </option>
                            </select>

                            <span class="text-danger">{{
                              formErrors("add_message_form.classroom")
                            }}</span>
                          </div>
                        </div>
                      </div>
                    </div>

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
import LikeComponent from '../common/LikeComponent';

export default {
	components: {
		// AddButton,
		ClassroomHeader,
		ProfileImage,
		Modal,
		LikeComponent,
	},
	mixins: [FormMixin],
	props:['classrooms'],
	data() {
		return {
			routeClassroomId: this.$route.params.classroomId,
			selectedClassroomId: '',
			showLoader: true,
			messages: [],
			content: '',
			edit_message:{
				id:'',
				content:'',
			},
		};
	},
	computed: {
		classroomDetail() {
			return this.$store.state.classroom.classroomDetail;
		},
	},
	mounted() {
		this.getMessages();
	},
	methods: {
		getMessages() {
			let api = '/api/get-classroom-messages/';
			if(this.routeClassroomId){
				api = api + this.routeClassroomId;
			}
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
		saveMessage() {
			this.$validator.validateAll('add_message_form').then((valid) => {
				if (valid) {
					//call api and update field
					this.axios
						.post(
							'/api/add-message',
							{
								classroom_id: this.routeClassroomId ? this.routeClassroomId :this.selectedClassroomId,
								content: this.content,
							}
						)
						.then((resp) => {
							let classroom_name ='';
							if(this.classrooms && this.classrooms.length){
								classroom_name = this.classrooms.find(node=>node.id===this.selectedClassroomId)['name'];
							}else{
								classroom_name = this.classroomDetail.name;
							}
							this.messages.push({
								'id':resp.data.success.message.id,
								'content':resp.data.success.message.content,
								'created_at':resp.data.success.message.created_at,
								'user_name':this.AuthUser.full_name,
								'avatar_url':this.AuthUser.avatar_url,
								'classroom_id': this.routeClassroomId ? this.routeClassroomId :this.selectedClassroomId,
								'classroom_name':classroom_name,
								'total_likes':0,
								'time':'Just now'});
							this.$refs.addMessageModal.closeModal();
							this.content = '';
						});
				}
			});
		},
		editMessage(e, message){
			this.$validator.validateAll('edit_message_form').then((valid)=>{
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
