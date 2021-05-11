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
        <classroom-header title="Student Panel" />
      </div>
      <div
        v-if="user_detail"
        class="col-md-12"
      >
        <h2 class="font-size-40 text-black weight-800">
          {{ user_detail.full_name }}
        </h2>
      </div>

      <nav-tabs
        :tabs="tabs"
        :initial-tab="initialTab"
      >
        <template slot="tab-heading-daily">
          {{ "Daily Assignment" }}
        </template>
        <template slot="tab-panel-daily">
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
        </template>

        <template slot="tab-heading-report">
          {{ "Report" }}
        </template>
        <template slot="tab-panel-report">
          <div class="col-md-12 col-center">
            <student-report />
          </div>
        </template>
      </nav-tabs>
    </div>
  </div>
</template>
<style scoped>
.col-center {
  margin: auto;
}
</style>
<script>
import ClassroomHeader from '../../../components/ClassroomHeader';
import DailyAssignmentReport from '../../../components/DailyAssignmentReport';
import dayjs from 'dayjs';
import NavTabs from '../../../components/NavTabs';
import studentReport from '../student-report';
import StudentReport from '../student-report.vue';

export default {
	components: {
		ClassroomHeader,
		DailyAssignmentReport,
		NavTabs,
		studentReport,
	},
	filters: {
		timeFormat(time) {
			return dayjs(time, 'hh:mm:ss').format('hh:mm A');
		},
	},
	data() {
		return {
			showLoader: true,
			today_report: null,
			today_assignment: null,
			is_available: false,
			user_detail: null,
			current_report: null,
			daily_reports: [],
			initialTab: 'daily',
			tabs: ['daily', 'report'],
		};
	},
	mounted() {
		this.getDailyReports();
	},
	methods: {
		getDailyReports() {
			let url =
        '/api/classroom/' +
        this.$route.params.classroomId +
        '/get-student-daily-reports';
			if (this.$route.name === 'ClassroomStudentPanel') {
				url = url + '/' + this.$router.currentRoute.params.userId;
			}
			this.axios.get(url).then((resp) => {
				this.daily_reports = resp.data.success.daily_reports;
				this.today_report = resp.data.success.today_report;
				this.current_report = resp.data.success.current_report;
				this.user_detail = resp.data.success.user_detail;
				this.today_assignment = resp.data.success.today_assignment;
				this.is_available = resp.data.success.is_available;
				this.showLoader = false;
			});
		},
		getDailyAnswer(event) {
			this.showLoader = true;
			this.axios

				.post(
					'/api/classroom/' +
            this.$route.params.classroomId +
            '/get-daily-answers',
					{
						report_id: event.target.value,
					}
				)
				.then((resp) => {
					this.current_report = resp.data.success.daily_assignment;
					this.showLoader = false;
				});
		},
	},
};
</script>
