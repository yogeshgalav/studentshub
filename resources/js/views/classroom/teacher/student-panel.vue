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
            <student-report
              :classroom-id="$route.params.classroomId"
              :user-id="current_user_id"
            />
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <daily-answer-report :user-id="current_user_id" />
      </div>
    </div>
    <!-- fotter for update chnges -->
    <navigation-component
      :current-user-id="current_user_id"
      @changeUser="changeUser"
    />
  </div>
</template>
<style scoped>
.col-center {
  margin: auto;
}
.ml-280 {
	margin-left:300px !important;
}
.text-right p{
  display: inline-block;
}

</style>
<script>
import ClassroomHeader from '../../../components/ClassroomHeader';
import NavigationComponent from '../../../components/NavigationComponent';
import DailyAnswerReport from '../DailyAnswerReport';
import StudentReport from '../student-report.vue';

export default {
	components: {
		ClassroomHeader,
		DailyAnswerReport,
		StudentReport,
		NavigationComponent
	},
	filters: {
		timeFormat(time) {
			return $dayjs(time, 'hh:mm:ss').format('hh:mm A');
		},
	},
	data() {
		return {
			current_user_id:this.$router.currentRoute.params.userId,
			today_report: null,
			today_assignment: null,
			is_available: false,
			user_detail: null,
		};
	},
	methods:{
		changeUser(user_id){
			this.current_user_id = user_id;
		}
	}
};
</script>
