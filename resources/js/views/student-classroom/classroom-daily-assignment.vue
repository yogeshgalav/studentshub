<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <classroom-header />
      </div>
      <div
        v-if="user_detail"
        class="col-md-12"
      >
        <h2 class="font-size-40 text-black weight-800">
          {{ user_detail.full_name }}
        </h2>
      </div>
      <div class="col-md-8 col-center">
        <div v-if="daily_report!==null">
          <div
            id="reflection-complete"
            class="card mt-3 mb-3  bg-success "
          >
            <div class="card-header">
              <h3 class="text-center font-size-18 text-white">
                {{ 'Daily Assignment' }}
              </h3>
            </div>
            <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
              <div class="row">
                <div class="col-md-12 col-12 center-col">
                  <div class="row">
                    <div class="col-md-12 col-lg-12 col-12 text-center">
                      <p>
                        {{ 'Daily Assisment for today is completed' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="daily_report===null && daily_assignment===null">
          <div
            id="reflection-complete"
            class="card mt-3 mb-3  bg-success "
          >
            <div class="card-header">
              <h3 class="text-center font-size-18 text-white">
                {{ 'Daily Assignment' }}
              </h3>
            </div>
            <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
              <div class="row">
                <div class="col-md-12 col-12 center-col">
                  <div class="row">
                    <div class="col-md-12 col-lg-12 col-12 text-center">
                      <p>
                        {{ 'There is no Daily Assignment for today.' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-if="daily_report===null && daily_assignment!==null">
          <div
            id="reflection-incomplete"
            class="card mt-3 mb-3 bg-primary border-primary"
          >
            <div class="card-header ">
              <h3 class="text-center font-size-18 text-white">
                {{ 'Daily Assignment' }}
              </h3>
            </div>
            <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
              <div class="row">
                <div class="col-md-12 col-12 center-col">
                  <div
                    v-if="is_available"
                    class="row"
                  >
                    <div class="col-md-12 col-lg-12 col-12 text-center">
                      <p>
                        <span
                          class="weight-800 text-black"
                        >
                          {{ 'Daily assisgment for today is remaining' }}
                        </span>
                      </p>
                      <a
                        id="reflection-link"
                        class="btn btn-success text-white"
                        :href="'/classroom/' + $route.params.classroomId +'/daily-attempt'"
                      >
                        {{ 'Attempt now' }}
                      </a>
                    </div>
                  </div>
                  <div
                    v-else-if="isAssignmentEnded"
                    class="row"
                  >
                    <div class="col-md-12 col-lg-12 col-12 text-center">
                      <p>
                        <span
                          class="weight-800 text-black"
                        >
                          {{ 'Daily assisgment for today has been ended at ' }}{{ daily_assignment.end_time | timeFormat }}
                        </span>
                      </p>
                    </div>
                  </div>
                  <div
                    v-else
                    class="row"
                  >
                    <div class="col-md-12 col-lg-12 col-12 text-center">
                      <p>
                        <span
                          class="weight-800 text-black"
                        >
                          {{ 'Daily assisgment for today will start at ' }}{{ daily_assignment.start_time | timeFormat }}
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="daily_reports.length"
        class="col-md-2"
      >
        <ul>
          <li
            v-for="report in daily_reports"
            :key="report.attempt_date"
            @click="getDailyAnswer(report)"
          >
            {{ report.attempt_date }}
          </li>
        </ul>
      </div>
      <div class="col-md-10 col-center">
        <div class="row">
          <div
            v-if="daily_reports.length"
            class="col-md-4"
          >
            <select
              class="form-control minimal"
              @change="getDailyAnswer($event)"
            >
              <option
                v-for="report in daily_reports"
                :key="report.id"
                :value="report.id"
              >
                {{ report.attempt_date }}
              </option>
            </select>
          </div>
        </div>
        <div
          v-if="current_report"
          class="row"
        >
          <daily-assignment-report :current-report="current_report" />
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
    .col-center {
        margin: auto;
    }
</style>
<script>
import ClassroomHeader from '../../components/ClassroomHeader';
import DailyAssignmentReport from '../../components/DailyAssignmentReport';
import dayjs from 'dayjs';

export default {
	components: {
		ClassroomHeader,
		DailyAssignmentReport,
	},
	filters:{
		timeFormat(time){
			return dayjs(time,'hh:mm:ss').format('hh:mm A');
		}
	},
	data() {
		return {
			daily_report: null,
			daily_assignment: null,
			is_available: false,
			user_detail:null,
			current_report:null,
			daily_reports:[],
		};
	},
	computed:{
		isAssignmentEnded(){
			return dayjs().isAfter(dayjs(this.daily_assignment.end_time,'hh:mm:ss'));
		}
	},
	mounted() {
		this.getDailyReports();
		this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-todays-report').then((
			resp) => {
			this.daily_report = resp.data.success.daily_report;
			this.daily_assignment = resp.data.success.daily_assignment;
			this.is_available = resp.data.success.is_available;
                   
		});
	},
	methods:{
		getDailyReports(){
			let url='/api/classroom/' + this.$route.params.classroomId + '/get-student-daily-reports';
			if(this.$route.name==='ClassroomStudentPanel'){
				url=url+'/'+this.$router.currentRoute.params.userId;
			}
			this.axios.get(url).then((
				resp) => {
				this.daily_reports = resp.data.success.daily_reports;
				this.current_report = resp.data.success.current_report;
				this.user_detail = resp.data.success.user_detail;
			});    
		},
		getDailyAnswer(event){
			this.axios.post('/api/classroom/' + this.$route.params.classroomId + '/get-daily-answers',{
				'report_id':event.target.value,
			}).then((
				resp) => {
				this.current_report = resp.data.success.current_report;                   
			});    
		}
	}
};

</script>
