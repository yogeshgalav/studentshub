<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header v-if="routeClassroomId" />
    <div>
      <div class="row">
        <div class="col-md-12">
          <div class="row add_cl_q">
            <div class="col-md-3 col-12">
              <div class="mt-2">
                <button
                  type="button"
                  class="btn btn-primary btn-lg"
                  @click="addMessage"
                >
                  Add Message
                </button>
              </div>
            </div>
            <div class="col-md-3 col-12" />
          </div>
          <div class="row add_cl_q mt-2">
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
              class="col-md-12 col-12 mt-2 card"
            >
              <div class="card-body">
                <div class="dashboard_post">
                  <div class="avatar">
                    <profile-image
                      :avatar="message.avatar_url"
                      :user-name="message.user_name"
                    />
                  </div>
                  <div class="info-post ml-2 dash_insititue_name"> 
                    <p class="usernamedash mb-0 dash_user_date">
                      {{ message.user_name }} <span> {{ message.time }}</span>
                    </p>
                    <p class="usernamedash mb-0">
                      {{ message.classroom_name }}
                    </p>
                  </div>
                </div>
                <hr>
                <p>{{ message.content }}</p>
              </div>
            </div>
            <div class="col-md-3 col-12" />
          </div>
        </div>

        <modal
          name="addMessageModal"
          class="doubt_model model-md"
          :click-to-close="false"
        >
          <form @submit.prevent="saveMessage()">
            <div class="row">
              <div class="col-md-12 mt-2">
                <div class="row">
                  <div class="col-md-6">
                    <h4>Add Message to this classroom.</h4>
                  </div>
                  <div class="col-md-6 text-right">
                    <button
                      type="button"
                      class="btn btn-lg btn-link font-size-24"
                      @click="$modal.hide('addMessageModal')"
                    >
                      &times;
                    </button>
                  </div>
                </div>
              </div>

              <div
                v-if="classrooms && classrooms.length"
                class="col-md-12"
              >
                <div class="form-group">
                  <div class="inner-addon left-addon">
                    <div class="cl_input">
                      <select
                        v-model="selectedClassroomId"
                        class="form-control custom-select"
                      >
                        <option
                          v-for="(classroom, index) in classrooms"
                          :key="index"
                          :value="classroom.id"
                        >
                          {{ classroom.name }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <div class="inner-addon left-addon">
                    <div class="cl_input">
                      <input
                        id="messageContent"
                        v-model="content"
                        v-validate="'required'"
                        name="content"
                        class="form-control"
                        placeholder="write message here"
                      >
                      <span class="text-danger">{{
                        formErrors("content")
                      }}</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-1 row text-right">
                <div class="col-md-12">
                  <hr>
                  <button
                    type="submit"
                    class="btn btn-outline-primary mb-2"
                  >
                    Submit
                  </button>
                </div>
              </div>
            </div>
          </form>
        </modal>
      </div>
    </div>
  </div>
</template>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
// import AddButton from '../../components/AddButton';
import ProfileImage from '../post/ProfileImage.vue';
import AddButton from '../../components/AddButton';

    
import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: {
		// AddButton,
		ClassroomHeader,
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
				this.messages = resp.data.success.messages;
				this.showLoader = false;
			});
		},
		addMessage() {
			this.$modal.show('addMessageModal');
		},
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
		saveMessage() {
			this.$validator.validate().then((valid) => {
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
							this.messages.push(resp.data.success.message);
							this.$modal.hide('addMessageModal');
							this.content = '';
						});
				}
			});
		},
	},
};
</script>
