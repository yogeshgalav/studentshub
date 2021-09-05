<template>
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
      <div>
        <div class="row">
          <div class="col-md-12">
            <div class="">
              <div class="col-md-6  mb-2">
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
              <div class="col-md-3 col-12" />
            </div> 
            <div class="">
              <div
                v-if="!homeworks.length"
                class="card"
              >
                <div class="card-body">
                  <div class="col-md-12">
                    <p>
                      {{ "Currently no Homework has been added." }}
                    </p>
                  </div>
                </div>
              </div>
              <div
                v-for="(homework,index2) in homeworks"
                :key="index2"
                class="card mb-2"
              >
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
                          {{ homework.teacher_name }} <span> {{ homework.created_at }} &nbsp; 
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
                      </div>
                    </div>
                    <hr>
                    <p>{{ homework.description }}</p>
                  </div>
                  <hr>
                </div>
                <div class="col-md-3 col-12" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <modal
      ref="addHomeworkModal"
      name="addHomeworkModal"
      heading="Add Homework"
      @submit="addHomework()"
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
                  :for="'new_description'"
                >Description</label>
                <textarea
                  id="new_description"
                  v-model="new_description"
                  name="new_description"
                  class="form-control"
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
import ClassroomHeader from '../../../components/ClassroomHeader';
import ProfileImage from '../../../components/ProfileImage.vue';
import Modal from '../../../components/VueNiceModal';
import DatePicker from 'vue2-datepicker';

export default {
	name:'Homework',
	components:{
		Modal,
		ClassroomHeader,
		ProfileImage,
		DatePicker
	},
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
			currentDate:new Date(),
			new_unit : '',
			new_homework_date:'',
			new_description:'',
			unitList:[],
			homeworks:[],

		};
	},
	mounted(){
		this.axios.get('/api/classroom/'+ this.$route.params.classroomId +'/homeworks').then(resp =>{
			this.unitList = resp.data.success.unitList;
			this.homeworks = resp.data.success.homeworks;
		});
	},
	methods:{
		addHomework(){
			this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/homework',{
				'submission_date': this.new_homework_date,
				'description':this.new_description,
				'unit_id': this.new_unit
			}).then(resp =>{
				window.location.reload();
			});
		}
	}

};
</script>

<style>

</style>