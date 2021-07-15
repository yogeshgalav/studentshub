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
          :title="user_detail.full_name"
        />
      </div>
      <div class="col-md-12 col-center">
        <student-report :classroom-id="$route.params.classroomId" />
      </div>
      <div class="col-md-12">
        <daily-assignment-report :daily-reports="daily_reports" />
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
import ClassroomHeader from '../../../components/ClassroomHeader';
import DailyAssignmentReport from '../../../components/DailyAssignmentReport';
import dayjs from 'dayjs';
import StudentReport from '../student-report.vue';

export default {
	components: {
		ClassroomHeader,
		DailyAssignmentReport,
		StudentReport,
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
        '/get-assignment-report';
			if (this.$route.name === 'ClassroomStudentPanel') {
				url = url + '/' + this.$router.currentRoute.params.userId;
			}
			this.axios.get(url).then((resp) => {
				this.daily_reports = resp.data.success.daily_reports;
				this.today_report = resp.data.success.today_report;
				// this.current_report = resp.data.success.current_report;
				this.user_detail = resp.data.success.user_detail;
				this.today_assignment = resp.data.success.today_assignment;
				this.is_available = resp.data.success.is_available;
				this.showLoader = false;
			});
		},
	},
};
</script>
