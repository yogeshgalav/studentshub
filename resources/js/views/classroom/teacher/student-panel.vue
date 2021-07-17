<template>
  <div>
    <div
      class="row"
    >
      <div 
        class="col-md-12"
      >
        <classroom-header 
          title="Student Dashboard"
        />
      </div>
      <div class="col-md-12 col-center">
        <div class="card mt-3 mb-3  bg-default ">
          <div class="card-header">
            <div class="row">
              <div class="col-md-8">
                <p class="font-size-18  mb-1 mt-1 light-black">
                  Current Progress
                </p>
              </div>
            </div>
          </div>
          <div class="card-body">
            <student-report :classroom-id="$route.params.classroomId" />
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <daily-answer-report />
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
import DailyAnswerReport from '../DailyAnswerReport';
import dayjs from 'dayjs';
import StudentReport from '../student-report.vue';

export default {
	components: {
		ClassroomHeader,
		DailyAnswerReport,
		StudentReport,
	},
	filters: {
		timeFormat(time) {
			return dayjs(time, 'hh:mm:ss').format('hh:mm A');
		},
	},
	data() {
		return {
			today_report: null,
			today_assignment: null,
			is_available: false,
			user_detail: null,
		};
	},
};
</script>
