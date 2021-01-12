<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <accordion
          :title="daily.attempt_date"
          :aria-expanded="true"
          tab="accordion_status_unit_active"
        >
          <div class="row add_cl_q">
            <div class="col-md-3 col-12">
              <div class="form-group pl-0">
                <label
                  class="control-label mb-1"
                  :for="'start_date'"
                >Select Unit</label>
                <select
                  v-model="daily.unit_id"
                  class="form-control"
                  @change="updateAssignment(daily)"
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
                      v-model="daily.attempt_date"
                      v-validate="'required'"
                      :name="'attempt_date'"
                      value-type="format"
                      :typeable="true"
                      :type="'date'"
                      :format="'YYYY-MM-DD'"
                      :lang="'en'"
                      placeholder
                      :not-before="currentDate.setDate(currentDate.getDate() + 1)"
                      @change="updateAssignment(daily)"
                    />
                  </div>
                  <span class="text-danger">{{ formErrors('attempt_date') }}</span>
                  <span class="text-danger">{{ assignment_error }}</span>
                </div>
              </div>
            </div>
          </div>
          <div v-if="daily.id">
            <div class="row add_cl_q">
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
                        :value="dailyStartTime"
                        :name="'start_time'"
                        value-type="format"
                        :typeable="true"
                        :type="'time'"
                        :format="'hh:mm a'"
                        :lang="'en'"
                        placeholder
                        :time-picker-options="{ start: currentUserStartTime, step: '00:15', end: '23:45' }"
                        @input="timeFormat('start',$event)"
                        @change="updateAssignment(daily)"
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
                        :value="dailyEndTime"
                        :name="'end_time'"
                        value-type="format"
                        :typeable="true"
                        :type="'time'"
                        :format="'hh:mm a'"
                        :lang="'en'"
                        placeholder
                        :disabled="dailyStartTime==='Invalid Date'"
                        :time-picker-options="{ start: currentUserEndTime, step: '00:15', end: '23:45' }"
                        @input="timeFormat('end',$event)"
                        @change="updateAssignment(daily)"
                      />
                    </div>
                    <span class="text-danger">{{ formErrors('end_time') }}</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row add_cl_q">
              <div class="col-md-12">
                <div class="text-grey col-md-12 pl-0">
                  <p class="mt-2">
                    Students will be asked to answer the following questions on this unit
                    attempt
                  </p>
                </div>

                <daily-questions
                  :daily-questions="daily.daily_questions"
                  :assignment-id="daily.id"
                  @totalUpdate="totalUpdate"
                />
              </div>
            </div>

            <div
              class="mt-3 row mobile_button_view"
            >
              <hr>
              <div class="col-md-6 col-6 text-left">
                <button
                  class="btn btn-white btn-md mt-1 "
                  @click="deleteDailyAssignment(daily)"
                >
                  <i class="fa fa-trash text-black" />
                </button>
              </div>
              <div class="col-md-6 col-6 text-right">
                <button
                  class="btn btn-primary btn-md mt-1"
                  @click="activateDailyAssignment(daily)"
                >
                  {{ daily.activated_at ? 'Deactivate' : 'Activate' }}
                </button>
              </div>
            </div>
          </div>
        </accordion>
      </div>
    </div>
  </div>
</template>
<style scoped>

/* @media only screen and (max-width: 600px) {
.mobile_button_view button {
  width: 100%;
}
} */
</style>
<script>
import FormMixin from '../../../components/mixins/form-mixin.js';
import Accordion from '../../../components/accordion';
import swal from '../../../components/swal.js';
import DailyQuestions from './daily-questions';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import dayjs from 'dayjs';
var customParseFormat = require('dayjs/plugin/customParseFormat');
dayjs.extend(customParseFormat);

export default {
	components: {
		Accordion,
		DatePicker,
		DailyQuestions
	},
	mixins: [FormMixin],
	props: ['assignment','unitList'],
	data() {
		return {
			currentDate:new Date(),
			daily: this.assignment,
			total: 0,
			assignment_error: '',
		};
	},
	computed:{
		dailyStartTime(){
			return dayjs(this.daily.start_time,'HH:mm:ss').format('hh:mm a');
		},
		dailyEndTime(){
			return dayjs(this.daily.end_time,'HH:mm:ss').format('hh:mm a');
		},
		currentUserStartTime(){
			if(this.daily.attempt_date!==dayjs().format('YYYY-MM-DD')){
				return '00:00';
			}
			return  dayjs().add(15 - dayjs().minute() % 15, 'minutes').format('HH:mm');
		},
		currentUserEndTime(){
			if(this.dailyStartTime){
				return dayjs(this.dailyStartTime,'hh:mm a').add(15, 'minutes').format('HH:mm');
			}
			return  this.currentUserStartTime;
		},
	},
	methods: {
		timeFormat(type,newValue){
			if(type==='start'){
				this.daily.start_time = dayjs(newValue,'hh:mm a').format('HH:mm:ss');
			}
			if(type==='end'){
				this.daily.end_time = dayjs(newValue,'hh:mm a').format('HH:mm:ss'); 
			}
		},
		updateAssignment(daily) {
			this.form_errors = [];
			if (!daily.unit_id || !daily.attempt_date) {
				return false;
			}
			this.$emit('loader',true);
			this.axios
				.post('/api/update-daily-assignment', {
					assignment_id: daily.id,
					unit_id: daily.unit_id,
					attempt_date: daily.attempt_date,
					start_time: daily.start_time,
					end_time: daily.end_time,
				})
				.then((resp) => {
					this.daily = resp.data.success.assignment;           
					this.daily['daily_questions']=[];
					this.$emit('loader',false);
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
            this.daily.attempt_date +
            '?'
				)
				.then((result) => {
					if (result.value) {
						this.axios.post('/api/delete-daily-assignment', {
							daily_assignment_id: this.daily.id,
						}).then(()=>{
							this.$emit('deleteAssignment');
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
			swal
				.confirmDialog(
					'Are you sure you want to Activate Assignment for date ' +
                        this.daily.attempt_date +
                        '?'
				)
				.then((result) => {
					if (result.value) {
						this.axios.post('/api/activate-daily-assignment', {
							daily_assignment_id: this.daily.id,
							status: this.daily.activated_at ? 'deactivate' : 'activate'
						}).then(() => {
							this.daily.activated_at = new Date();
						});
					}
				});
		},
	}
};

</script>
