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
              <router-link :href="'/classroom/'+$route.params[0]+'/setup'">
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
      <div
        v-if="assignment_list.length"
        class="col-md-6"
      >
        <select
          class="form-control minimal"
          @change="setCurrentAssignment"
        >
          <option
            v-for="(daily,index) in assignment_list"
            :key="index"
            :value="daily.id"
          >
            {{ daily.show_date }}
          </option>
        </select>
      </div>
    </div>
    <div 
      v-if="assignment_list.length"
      class="row col-md-12"
    >
      <div class="col-md-12">
        <div class="card mt-5">
          <div class="card-header">
            {{ current_assignment.show_date }}
          </div>
          <div class="card-body">
            <div class="col-md-3 col-12">
              <div class="form-group pl-0">
                <label
                  class="control-label mb-1"
                  :for="'start_date'"
                >Select Unit</label>
                <select
                  v-model="current_assignment.unit_id"
                  class="form-control"
                  :disabled="current_assignment.daily_reports_count>0"
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
                      v-model="current_assignment.attempt_date"
                      v-validate="'required'"
                      :name="'attempt_date'"
                      :disabled="current_assignment.daily_reports_count>0"
                      value-type="format"
                      :typeable="true"
                      :type="'date'"
                      :format="'DD-MM-YYYY'"
                      :lang="'en'"
                      placeholder
                      :not-before="currentDate.setDate(currentDate.getDate() + 1)"
                      @change="updateAssignment"
                    />
                  </div>
                  <span class="text-danger">{{ formErrors('attempt_date') }}</span>
                  <span class="text-danger">{{ update_assignment_error }}</span>
                </div>
              </div>
            </div>
            <div v-if="current_assignment.id">
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
                          :disabled="current_assignment.daily_reports_count>0"
                          value-type="format"
                          :typeable="true"
                          :type="'time'"
                          :format="'hh:mm a'"
                          :lang="'en'"
                          placeholder
                          :time-picker-options="{ start: currentUserStartTime, step: '00:15', end: '23:45' }"
                          @input="timeFormat('start',$event)"
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
                          :disabled="assignmentStartTime==='Invalid Date' || current_assignment.daily_reports_count>0"
                          :time-picker-options="{ start: currentUserEndTime, step: '00:15', end: '23:45' }"
                          @input="timeFormat('end',$event)"
                        />
                      </div>
                      <span class="text-danger">{{ formErrors('end_time') }}</span>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="col-md-12">
                <div v-if="!current_assignment.daily_reports_count">
                  <edit-questions
                    :key="current_assignment.id"
                    :assignment-id="current_assignment.id"
                    @totalUpdate="totalUpdate"
                  />
                </div>
                <div v-else>
                  <question-report
                    :assignment-id="current_assignment.id"
                  />
                </div>
              </div>
            </div>
          </div>
          <div 
            v-if="!current_assignment.daily_reports_count"
            class="card-footer"
          >
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
                  {{ current_assignment.activated_at ? 'Deactivate' : 'Activate' }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <modal
      ref="addAssignmentModal"
      name="addAssignmentModal"
      heading="Add Assignment"
      @submit="addAssignment()"
    >
      <template slot="modalBody">
        <form data-vv-scope="newAssignment">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="assignment_date">Assignment Date:</label>
                <div class="inner-addon left-addon">
                  <div class="cl_input">
                    <date-picker
                      id="assignment_date"
                      v-model="new_assignment_date"
                      v-validate="'required'"
                      :name="'assignment_date'"
                      value-type="format"
                      :typeable="true"
                      :type="'date'"
                      :format="'DD-MM-YYYY'"
                      :lang="'en'"
                      placeholder
                      :not-before="currentDate.setDate(currentDate.getDate() + 1)"
                    />
                    <div>
                      <span class="text-danger">{{ formErrors('newAssignment.assignment_date') }}</span>
                      <span class="text-danger">{{ assignment_error }}</span>
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
                  {{ formErrors('newAssignment.new_unit') }}
                </div>
              </div>
            </div>
          </div>
        </form>
      </template>
    </modal>
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
import Modal from '../../../components/VueNiceModal';
import FormMixin from '../../../components/mixins/form-mixin.js';
import ClassroomHeader from '../../../components/ClassroomHeader';
import swal from '../../../components/swal.js';
import EditQuestions from './edit-questions';
import QuestionReport from './question-report';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

var customParseFormat = require('dayjs/plugin/customParseFormat');

export default {
	components: {
		ClassroomHeader,
		DatePicker,
		EditQuestions,
		Modal,
		QuestionReport,
	},
	mixins: [FormMixin],
	data() {
		return {
			showLoader:false,
			new_unit:'',
			new_assignment_date:'',
			current_assignment: {
				id:'',
				unit_id: '',
				attempt_date: '',
				start_time: '',
				end_time: '',
				activated_at:'',
			},
			assignment_list: [],
			unitList: [],
			assignmentStartTime:'',
			assignmentEndTime:'',
			currentDate:new Date(),
			total: 0,
			assignment_error: '',
			update_assignment_error:'',
		};
	},
	computed: {
		latestDate() {
			return new Date();
		},
		classroomDetail() {
			return this.$store.state.classroom.classroomDetail;
		},
		currentUserStartTime(){
			if(!this.current_assignment){
				return '';
			}
			if(this.current_assignment.attempt_date!==this.$dayjs().format('YYYY-MM-DD')){
				return '00:00';
			}
			return  this.$dayjs().add(15 - this.$dayjs().minute() % 15, 'minutes').format('HH:mm');
		},
		currentUserEndTime(){
			if(!this.current_assignment){
				return '';
			}
			if(this.assignmentStartTime){
				return this.$dayjs(this.assignmentStartTime,'hh:mm a').add(15, 'minutes').format('HH:mm');
			}
			return  this.currentUserStartTime;
		},
	},
	watch:{
		current_assignment(val){
			this.assignmentStartTime = val.start_time ? this.$dayjs(val.start_time,'HH:mm:ss').format('hh:mm a') : '';
			this.assignmentEndTime = val.end_time ? this.$dayjs(val.end_time,'HH:mm:ss').format('hh:mm a') : '';
		}
	},
	mounted() {
		this.$dayjs.extend(customParseFormat);
		this.getAssignmentList();
	},
	methods: {
		getAssignmentList() {
			this.showLoader=true;
			this.axios
				.get('/api/classroom/' + this.$route.params[0] + '/get-assignment-list')
				.then((resp) => {
					this.unitList = resp.data.success.unitList;
					this.assignment_list = resp.data.success.assignment_list.map(node=>{
						node.show_date = this.$dayjs(node.attempt_date, 'YYYY-MM-DD').format('D MMM, YYYY');
						return node;
					});
					this.setCurrentAssignment();
					this.showLoader=false;
				});
		},
		setCurrentAssignment(event = null){
			let assignment = null;

			if(null!==event && event.target.value){
				assignment = this.assignment_list.find(node=>node.id===parseInt(event.target.value));
			}else if(null===event && this.assignment_list.length){
				assignment = this.assignment_list[0];
			}else{
				return false;
			}
			this.current_assignment={
				id: assignment.id,
				unit_id: assignment.unit_id,
				attempt_date: this.$dayjs(assignment.attempt_date, 'YYYY-MM-DD').format('DD-MM-YYYY'),
				show_date: assignment.show_date,
				start_time: assignment.start_time,
				end_time: assignment.end_time,
				daily_reports_count: assignment.daily_reports_count,
				activated_at: assignment.activated_at,
			};
		},
		addAssignment() {
			
			this.validateForm('newAssignment').then(valid => {
				if(valid){
					this.assignment_error='';
					this.showLoader=true;
					this.axios
				      .post('/api/classroom/' + this.$route.params[0] + '/create-assignment', {
							unit_id: this.new_unit,
							attempt_date: this.$dayjs(this.new_assignment_date, 'DD-MM-YYYY').format('YYYY-MM-DD'),
						})
						.then((resp) => {
							let new_assignment =resp.data.success.assignment;
							new_assignment.show_date = this.$dayjs(new_assignment.attempt_date, 'YYYY-MM-DD').format('D MMM, YYYY');
							new_assignment.attempt_date = this.$dayjs(new_assignment.attempt_date, 'YYYY-MM-DD').format('DD-MM-YYYY');
							new_assignment['daily_report_count'] = 0;
							this.assignment_list.unshift(new_assignment);
							this.current_assignment = new_assignment;
							this.showLoader=false;
							this.$refs.addAssignmentModal.closeModal();
						}).catch(err => {
							if(422 === err.response.status){
								this.assignment_error='Assignment for this date is already present, please select different date.';
							}
							this.showLoader=false;
						});
				
				}
			});
		},
		timeFormat(type,newValue){
			if(type==='start'){
			  this.assignmentStartTime = newValue;
				this.current_assignment.start_time = this.$dayjs(newValue,'hh:mm a').format('HH:mm:ss');
			}
			if(type==='end'){
			  this.assignmentEndTime = newValue;
				this.current_assignment.end_time = this.$dayjs(newValue,'hh:mm a').format('HH:mm:ss'); 
			}
			this.updateAssignment();
		},
		updateAssignment() {
			this.update_assignment_error = '';
			this.form_errors = [];
			this.showLoader=true;
			this.axios
				.post('/api/daily-assignment/' + this.current_assignment.id + '/update', {
					assignment_id: this.current_assignment.id,
					unit_id: this.current_assignment.unit_id,
					attempt_date: this.$dayjs(this.current_assignment.attempt_date, 'DD-MM-YYYY').format('YYYY-MM-DD'),
					start_time: this.current_assignment.start_time,
					end_time: this.current_assignment.end_time,
				})
				.then((resp) => {
					this.showLoader=false;
				}).catch(err => {
					if(422 === err.response.status){
						this.update_assignment_error='Assignment for this date is already present, please select different date';
					}
					this.showLoader=false;
				});
		},
            
		deleteDailyAssignment() {
			swal
				.confirmDialog(
					'Are you sure you want to Delete Assignment for date ' +
            this.current_assignment.show_date +
            '?'
				)
				.then((result) => {
					if (result.value) {
						this.axios.delete('/api/daily-assignment/'+this.current_assignment.id).then(()=>{
							let assignmentIndex = this.assignment_list.findIndex(node=>node.id===this.current_assignment.id);
							this.assignment_list.splice(assignmentIndex,1);
							this.setCurrentAssignment();
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
			if(this.current_assignment.activated_at){
				this.activateApi();
			}else{
				swal
					.confirmDialog(
						'Are you sure you want to Activate Assignment for date ' +
                        this.current_assignment.show_date +
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
			this.axios.post('/api/daily-assignment/'+this.current_assignment.id+'/activate')
				.then(() => {
					this.current_assignment.activated_at = this.current_assignment.activated_at ? '' : new Date();
				});
		}
	}
};
</script>
