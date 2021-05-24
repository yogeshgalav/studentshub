<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="row">
      <div class="col-md-12">
        <classroom-header 
          title="Daily Assignment"
        />
      </div>
    </div>
    <div
      v-if="!unitList.length"
      class="card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p>
              {{ 'No unit created.This page will populate once unit setup is done. ' }}
              <router-link :to="'/classroom/'+$route.params.classroomId+'/setup'">
                Click here to to create unit
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div
      v-else
      class="mt-2"
    >
      <div class="col-md-6  mb-2">
        <div>
          <div class="text-right">
            <button
              class="btn-lg btn-primary"
              data-toggle="modal"
              data-target="#addAssignmentModal"
            >
              <i class="fas fa-plus" />&nbsp;&nbsp;Add Assignment
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <select
          v-model="current_assignment_id"
          class="form-control minimal"
          @change="getAssignmentDetails"
        >
          <option
            v-for="(daily,index) in assignment_list"
            :key="index"
            :value="daily.id"
          >
            {{ daily.attempt_date }}
          </option>
        </select>
      </div>
    </div>
    <div class="row col-md-12">
      <div class="col-md-12">
        <div class="card mt-5">
          <div class="card-header">
            {{ assignment.attempt_date }}
          </div>
          <div class="card-body">
            <div class="col-md-3 col-12">
              <div class="form-group pl-0">
                <label
                  class="control-label mb-1"
                  :for="'start_date'"
                >Select Unit</label>
                <select
                  v-model="assignment.unit_id"
                  class="form-control"
                  @change="updateAssignment"
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
                  {{ formErrors('unit_id') }}
                </div>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="row">
                <div class="col-md-6">
                  <label
                    class="text-black mb-1"
                    :for="'attempt_date'"
                  >{{ 'Attempt Date' }}</label>
                  <div class="input-group-prepend">
                    <div
                      class="input-group-prepend date"
                      data-provide="datepicker"
                    >
                      <span class="input-group-text">
                        <i class="fa fa-calendar" />
                      </span>
                    </div>
                    <date-picker
                      :id="'attempt_date'"
                      v-model="assignment.attempt_date"
                      v-validate="'required'"
                      :name="'attempt_date'"
                      value-type="format"
                      :typeable="true"
                      :type="'date'"
                      :format="'YYYY-MM-DD'"
                      :lang="'en'"
                      placeholder
                      :not-before="currentDate.setDate(currentDate.getDate() + 1)"
                      @change="updateAssignment"
                    />
                  </div>
                  <span class="text-danger">{{ formErrors('attempt_date') }}</span>
                  <span class="text-danger">{{ assignment_error }}</span>
                </div>
              </div>
            </div>
            <div v-if="assignment.id">
              <div class="">
                <div class="col-md-6 col-12">
                  <div class="row">
                    <div class="col-md-6">
                      <label
                        class="text-black mb-1"
                        :for="'start_time'"
                      >{{ 'Start Time' }}</label>
                      <div class="input-group-prepend">
                        <div
                          class="input-group-prepend date"
                          data-provide="datepicker"
                        >
                          <span class="input-group-text">
                            <i class="fa fa-clock" />
                          </span>
                        </div>
                        <date-picker
                          :id="'start_time'"
                          v-validate="'required'"
                          :value="assignmentStartTime"
                          :name="'start_time'"
                          value-type="format"
                          :typeable="true"
                          :type="'time'"
                          :format="'hh:mm a'"
                          :lang="'en'"
                          placeholder
                          :time-picker-options="{ start: currentUserStartTime, step: '00:15', end: '23:45' }"
                          @input="timeFormat('start',$event)"
                          @change="updateAssignment"
                        />
                      </div>
                      <span class="text-danger">{{ formErrors('start_time') }}</span>
                    </div>
                
                    <div class="col-md-6">
                      <label
                        class="text-black mb-1"
                        :for="'start_time'"
                      >{{ 'End Time' }}</label>
                      <div class="input-group-prepend">
                        <div
                          class="input-group-prepend date"
                          data-provide="datepicker"
                        >
                          <span class="input-group-text">
                            <i class="fa fa-clock" />
                          </span>
                        </div>
                        <date-picker
                          :id="'end_time'"
                          v-validate="'required'"
                          :value="assignmentEndTime"
                          :name="'end_time'"
                          value-type="format"
                          :typeable="true"
                          :type="'time'"
                          :format="'hh:mm a'"
                          :lang="'en'"
                          placeholder
                          :disabled="assignmentStartTime==='Invalid Date'"
                          :time-picker-options="{ start: currentUserEndTime, step: '00:15', end: '23:45' }"
                          @input="timeFormat('end',$event)"
                          @change="updateAssignment"
                        />
                      </div>
                      <span class="text-danger">{{ formErrors('end_time') }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="col-md-12">
                  <div class="text-grey col-md-12 pl-0">
                    <p class="mt-2">
                      Students will be asked to answer the following questions on this unit
                      attempt
                    </p>
                  </div>

                  <edit-questions
                    :key="assignment.id"
                    :daily-questions="assignment.daily_questions"
                    :assignment-id="assignment.id"
                    @totalUpdate="totalUpdate"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div
              class="row mobile_button_view"
            >
              <hr>
              <div class="col-md-6 col-6 text-left">
                <button
                  class="btn btn-white btn-md mt-1 "
                  @click="deleteDailyAssignment()"
                >
                  <i class="fa fa-trash text-black" />
                </button>
              </div>
              <div class="col-md-6 col-6 text-right">
                <button
                  class="btn btn-primary btn-md mt-1"
                  @click="activateDailyAssignment()"
                >
                  {{ assignment.activated_at ? 'Deactivate' : 'Activate' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.delete_btn {
  padding: 0 22px 0 22px;
  font-size: 18px;
}
.border-bottom-1px  {
  border-bottom:1px dashed #ccc !important;
}
</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import ClassroomHeader from '../../components/ClassroomHeader';
import swal from '../../components/swal.js';
import EditQuestions from './edit-questions';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import dayjs from 'dayjs';
var customParseFormat = require('dayjs/plugin/customParseFormat');
dayjs.extend(customParseFormat);

export default {
	components: {
		ClassroomHeader,
		DatePicker,
		EditQuestions
	},
	mixins: [FormMixin],
	data() {
		return {
			showLoader:true,
			current_assignment_id: [],
			assignment: {
				unit_id: '',
				attempt_date: '',
				daily_questions: [],
			},
			assignment_list: [],
			unitList: [],

			currentDate:new Date(),
			total: 0,
			assignment_error: '',
		};
	},
	computed: {
		latestDate() {
			return new Date();
		},
		classroomDetail() {
			return this.$store.state.classroom.classroomDetail;
		},
		assignmentStartTime(){
			if(!this.assignment){
				return '';
			}
			return dayjs(this.assignment.start_time,'HH:mm:ss').format('hh:mm a');
		},
		assignmentEndTime(){
			if(!this.assignment){
				return '';
			}
			return dayjs(this.assignment.end_time,'HH:mm:ss').format('hh:mm a');
		},
		currentUserStartTime(){
			if(!this.assignment){
				return '';
			}
			if(this.assignment.attempt_date!==dayjs().format('YYYY-MM-DD')){
				return '00:00';
			}
			return  dayjs().add(15 - dayjs().minute() % 15, 'minutes').format('HH:mm');
		},
		currentUserEndTime(){
			if(!this.assignment){
				return '';
			}
			if(this.assignmentStartTime){
				return dayjs(this.assignmentStartTime,'hh:mm a').add(15, 'minutes').format('HH:mm');
			}
			return  this.currentUserStartTime;
		},
	},
	mounted() {
		this.getAssignmentList();
	},
	methods: {
		changeLoader(status){
			this.showLoader=status;
		},
		getAssignmentList() {
			this.axios
				.get('/api/classroom/' + this.$route.params.classroomId + '/get-assignment-list')
				.then((resp) => {
					this.unitList = resp.data.success.unitList;
					this.assignment_list = resp.data.success.assignment_list;
					if(this.assignment_list.length){
						this.current_assignment_id = this.assignment_list[0].id;
						this.getAssignmentDetails();
					}
				});
		},
		getAssignmentDetails(){
			this.axios
				.get('/api/classroom/' + this.$route.params.classroomId + '/assignment/' + this.current_assignment_id + '/details')
				.then((resp) => {
					this.assignment=resp.data.success.assignment_detail;
					this.showLoader=false;
				});
		},
		addAssignment() {
			this.assignment_list.unshift({
				unit_id: '',
				attempt_date: '',
				daily_questions: [],
			});
		},
		timeFormat(type,newValue){
			if(type==='start'){
				this.assignment.start_time = dayjs(newValue,'hh:mm a').format('HH:mm:ss');
			}
			if(type==='end'){
				this.assignment.end_time = dayjs(newValue,'hh:mm a').format('HH:mm:ss'); 
			}
		},
		updateAssignment() {
			this.form_errors = [];
			if (!this.assignment.unit_id || !this.assignment.attempt_date) {
				return false;
			}
			this.showLoader=true;
			this.axios
				.post('/api/update-daily-assignment', {
					assignment_id: this.assignment.id,
					unit_id: this.assignment.unit_id,
					attempt_date: this.assignment.attempt_date,
					start_time: this.assignment.start_time,
					end_time: this.assignment.end_time,
				})
				.then((resp) => {
					this.assignment = resp.data.success.assignment;           
					this.assignment['daily_questions']=[];
					this.showLoader=false;
					this.assignment_error='';
				}).catch(err => {
					console.log(err.response.status,err.response.data);
					if(422 === err.response.status){
						this.assignment_error=err.response.data;
					}
				});
		},
            
		deleteDailyAssignment() {
			swal
				.confirmDialog(
					'Are you sure you want to Delete Assignment for date ' +
            this.assignment.attempt_date +
            '?'
				)
				.then((result) => {
					if (result.value) {
						this.axios.post('/api/delete-daily-assignment', {
							daily_assignment_id: this.assignment.id,
						}).then(()=>{
							let assignmentIndex = this.assignment_list.findIndex(node=>node.id===this.assignment.id);
							this.assignment_list.splice(assignmentIndex,1);
							if(this.assignment_list.length){
								this.current_assignment_id = this.assignment_list[0].id;
								this.getAssignmentDetails();
							}
						});
					}
				});
		},
		totalUpdate(total){
			this.total=total;
		},
		activateDailyAssignment() {
			if (this.total !== 10) {
				swal
					.infoDialog('Total marks for Daily Assignment should be 10.');
				return false;
			}
			if(this.assignment.activated_at){
				this.activateApi();
			}else{
				swal
					.confirmDialog(
						'Are you sure you want to Activate Assignment for date ' +
                        this.assignment.attempt_date +
                        '?'
					)
					.then((result) => {
						if (result.value) {
							this.activateApi();
						}
					});
			}
		},
		activateApi(){
			this.axios.post('/api/activate-daily-assignment', {
				daily_assignment_id: this.assignment.id,
				status: this.assignment.activated_at ? 'deactivate' : 'activate'
			}).then(() => {
				this.assignment.activated_at = this.assignment.activated_at ? null : new Date();
			});
		}
	}
};
</script>
