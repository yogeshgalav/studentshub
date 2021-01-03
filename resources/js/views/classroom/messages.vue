<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header />
    <div>
      <div class="row">
        <div class="col-md-12">
          <div
            v-if="AuthTeacher && AuthTeacher.id===classroomDetail.teacher_id"
            class="row add_cl_q"
          >
            <div class="col-md-3 col-12">
              <div class="mt-2">
                <add-button
                  name="Add Message"
                  size="lg"
                  @submit="addMessage"
                />
              </div>
            </div>
            <div class="col-md-3 col-12" />
          </div>
          <div class="row add_cl_q">
            <div 
              v-for="(message,index2) in messages"
              :key="index2"
              class="col-md-10 col-12 mt-2 card"
            >
              <div 
                class="card-body"
              >
                <p>{{ $dayjs(message.created_at).format('D MMMM, YYYY') }}</p>
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
          <form
            @submit.prevent="saveMessage()"
          >
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
                      <span class="text-danger">{{ formErrors('content') }}</span>
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
import AddButton from '../../components/AddButton';
    
import ClassroomHeader from '../../components/ClassroomHeader';
    
export default {
	components: {
		AddButton,
		ClassroomHeader
	},
	mixins:[FormMixin],
	data() {
		return {
			showLoader:true,
			messages: [],
			content: '',
		};
	},
	computed:{
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		}
	},
	mounted() {
		this.getMessages();
	},
	methods: {
		getMessages(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-messages').then((resp) => {
				this.messages = resp.data.success.messages;
				this.showLoader=false;
			});
		},
		addMessage() {
			this.$modal.show('addMessageModal');
		},
		saveMessage() {
			this.$validator.validate().then(valid => {
				if(valid){
					//call api and update field
					this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/add-message',{
						content: this.content,
					}).then((resp)=>{
						this.messages.push(resp.data.success.message);
			      this.$modal.hide('addMessageModal');
						this.content = '';
					});
				}
			});
		},
	}
};

</script>
