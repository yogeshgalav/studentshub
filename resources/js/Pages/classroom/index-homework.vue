<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <classroom-header
          v-if="routeClassroomId" 
          title="Homework"
        />
        <div v-else>
          <h1>Homework</h1>
          <hr>
        </div>
      </div>
    </div>
    <div 
      v-if="AuthUser.role!=='student'"
      class="row"
    >
      <div class="col-md-12 mb-2">
        <div>
          <div class="text-right">
            <button
              class="btn-lg btn-primary"
              data-toggle="modal"
              data-target="#addHomeworkModal"
            >
              <i class="fas fa-plus" />&nbsp;&nbsp;Add Homework
            </button>
          </div>
        </div>
      </div>
    </div> 
    <div class="row">
      <div class="col-md-10 col-12">
        <div
          v-if="!homeworks.length"
          class="card"
        >
          <div class="card-body">
            <p>
              {{ "Currently no Homework has been added." }}
            </p>
          </div>
        </div>
      </div>
      <div
        v-for="(homework,index2) in homeworks"
        :key="index2"
        class="col-md-10 col-12"
      >
        <div class="card mb-2">
          <div class="card-body">
            <div>
              <div class="dashboard_post">
                <div class="avatar">
                  <profile-image
                    :avatar="homework.avatar_url"
                    :user-name="homework.teacher_name"
                  />
                </div>
                <div class="info-post ml-2 dash_insititue_name">
                  <p class="font-size-14 mb-0 dash_user_date">
                    {{ homework.teacher_name }} <span> {{ $dayjs(homework.created_at).fromNow() }} 
                      <div
                        v-if="homework.teacher_id===AuthUser.id"
                        class="dropdown d-inline"
                      >
                        <button
                          id="dropdownMenuButton"
                          class="btn btn-secondary dropdown-toggle p-0  border-0"
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
                            data-target="#addHomeworkModal"
                            @click="editHomework(homework)"
                          >Edit</button> 
                          <button
                            type="button"
                            class="dropdown-item"
                            @click="deleteHomework(homework.id)"
                          >Delete</button>
                        </div>
                      </div>
                            <!-- <div
                              v-if="homework.user_id===AuthUser.id"
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
                            </div> --> </span>
                  </p>
                  <p class="font-size-14 mb-0">
                    {{ homework.classroom_name }}
                  </p>
                </div>
              </div>
              <hr>
              <p class="font-size-14 text-grey mb-0">
                Submission Date: {{ $dayjs(homework.submission_date).format('D MMMM, YYYY') }}
              </p>
              <p>{{ homework.homework_text }}</p>
              <router-link
                :href="'/classroom/'+routeClassroomId+'/homework/'+homework.id"
                class="btn p-0 btn-link font-size-16"
                style="text-decoration: underline;"
              >
                View Homework &nbsp;<i class="fa fa-arrow-right" />
              </router-link>
            </div>
            <hr>
            <interaction-component
              :user-mark="homework.user_mark ? true : false"
              :homework-id="homework.id"
            />
          </div>
        </div>
      </div>
    </div>
    <modal
      ref="addHomeworkModal"
      name="addHomeworkModal"
      heading="Add Homework"
      classes="modal-lg"
      @submit="addOrEditHomework"
    >
      <template slot="modalBody">
        <form data-vv-scope="newHomework">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="assignment_date">Homework Date:</label>
                <div class="inner-addon left-addon">
                  <div class="cl_input">
                    <date-picker
                      id="Homework_date"
                      v-model="new_homework_date"
                      v-validate="'required'"
                      :name="'homework_date'"
                      value-type="format"
                      :typeable="true"
                      :type="'date'"
                      :format="'DD-MM-YYYY'"
                      :lang="'en'"
                      placeholder
                      :not-before="currentDate.setDate(currentDate.getDate() + 1)"
                    />
                    <div>
                    <!-- <span class="text-danger">{{ formErrors('newAssignment.assignment_date') }}</span>
                      <span class="text-danger">{{ assignment_error }}</span> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label
                  class="control-label mb-1"
                  :for="'new_unit'"
                >Select Unit</label>
                <select
                  id="new_unit"
                  v-model="new_unit"
                  name="new_unit"
                  class="form-control"
                >
                  <option
                    v-for="(unit,index2) in unitList"
                    :key="index2"
                    :value="unit.id"
                  >
                    {{ 'Unit '+unit.unit_no + ':' +unit.unit_name }}
                  </option>
                </select>
                <div class="error">
                <!-- {{ formErrors('newAssignment.new_unit') }} -->
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label
                  class="control-label mb-1"
                  :for="'homework_html'"
                >Homework</label>
                <rich-text-editor
                  id="homework_html"
                  v-model="homework_html"
                />
                <div class="error">
                <!-- {{ formErrors('newAssignment.new_unit') }} -->
                </div>
              </div>
            </div>
          </div>
        </form>
      </template>
    </modal>
  </div>
</template>
<script>
import ClassroomHeader from '../../components/ClassroomHeader';
import ProfileImage from '../../components/ProfileImage.vue';
import Modal from '../../components/VueNiceModal';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import RichTextEditor from '../../components/RichTextEditor';

import InteractionComponent from '../common/InteractionComponent2';

export default {
	name:'Homework',
	components:{
		Modal,
		ClassroomHeader,
		ProfileImage,
		DatePicker,
		InteractionComponent,
		RichTextEditor,
	},
	data() {
		return {
			routeClassroomId: this.$route.params[0],
			selectedClassroomId: '',
			showLoader: true,
			messages: [],
			content: '',
			edit_message:{
				id:'',
				content:'',
			},
			currentDate:new Date(),
			new_unit : '',
			new_homework_date:'',
			homework_html:'',
			unitList:[],
			homeworks:[],
			editorSettings: {
				modules: {
					imageDrop: true,
					imageResize: {},
				}
			},
			edit_homework_id:'',      
		};
	},
	mounted(){
		this.axios.get('/api/classroom/'+ this.$route.params[0] +'/homeworks').then(resp =>{
			this.unitList = resp.data.success.unitList;
			this.homeworks = resp.data.success.homeworks;
		});
	},
	methods:{
		addHomework(){
			let homework_text = this.getHomeworkText();
			this.axios.post('/api/classroom/'+this.$route.params[0]+'/homework',{
				'submission_date': this.new_homework_date,
				'homework_text':this.getHomeworkText(),
				'homework_html':this.homework_html,
				'unit_id': this.new_unit
			}).then(resp =>{
				this.homeworks.unshift({
					id:resp.data.success.homework_id,
					submission_date:this.new_homework_date,
					classroom_name:this.$store.state.classroom.classroomDetail.name,
					homework_text:homework_text ? homework_text : 'Complete the following homework.',
					teacher_avatar:this.AuthUser.avatar_url,
					teacher_name:this.AuthUser.full_name,
					total_done:0,
					created_at:'just now',
				});
				this.$refs.addHomeworkModal.closeModal();
			});
		},
		getHomeworkText(){
			if(this.homework_html.trim()===''){
				return '';
			}
			var span= document.createElement('span');
			span.innerHTML= this.homework_html;
        
			var children= span.querySelectorAll('*');
			for(var i = 0 ; i < children.length ; i++) {
				if(children[i].textContent)
					children[i].textContent+= ' ';
				else
					children[i].innerText+= ' ';
			}
			return [span.textContent || span.innerText].toString();
		},
    	addOrEditHomework(){
    		if(this.edit_doubt_id){
    			this.updateHomework();
    			return true;
    		}
    		this.addHomework();
    		return true;
    	},

		updateDoubt()
    	{
    		this.axios.put('/api/homework/' + this.edit_homework_id ,{
    		'submission_date': this.new_homework_date,
				'homework_text':this.getHomeworkText(),
				'homework_html':this.homework_html,
				'unit_id': this.new_unit
    		}).then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addDoubtModal.closeModal();
    				this.setupPage();
    			})
    			.catch(err => {
    				reject(err);
    			});
    	},

		editHomework(hw){
    		this.edit_homework_id = hw.id;
    		this.homework_html = hw.text;
			this.new_homework_date = hw.submission_date;
			this.new_unit = hw.classroom_name;
    		
    	},
    	deleteHomework(HomeworkId){
			let delete_index = this.homeworks.findIndex(node=>node.id === HomeworkId);
    		this.axios.delete('/api/homework/' + HomeworkId).then((resp)=>{
    			this.homeworks.splice(delete_index,1);
    		});
    	},
	}

};
</script>

<style>

</style>