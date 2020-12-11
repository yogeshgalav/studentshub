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
      <div class="col-md-8">
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
<script>
import ClassroomHeader from '../../components/ClassroomHeader';
import DailyAssignmentReport from '../../components/DailyAssignmentReport';

export default {
	components: {
		ClassroomHeader,
		DailyAssignmentReport,
	},
	data(){
		return {
			user_detail:null,
			current_report:null,
			daily_reports:[],
		};
	},
	mounted() {
		this.getDailyReports();
		// this.getDailyAssignmentReport(attempt_date);
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