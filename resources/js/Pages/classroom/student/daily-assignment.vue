<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <classroom-header
          title="Daily Assignment" 
        />
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
        <div v-if="today_report!==null">
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
        <div v-if="today_report===null && today_assignment===null">
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
        <div v-if="today_report===null && today_assignment!==null">
          <div
            id="reflection-incomplete"
            :class="['card mt-3 mb-3', cardColor]"
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
                        :href="'/classroom/' + $route.params.classroomId"
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
                          {{ 'Daily assisgment for today has been ended at ' }}{{ today_assignment.end_time | timeFormat }}
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
                          {{ 'Daily assisgment for today will start at ' }}{{ today_assignment.start_time | timeFormat }}
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
import StudentReport from '../student-report.vue';


export default {
	components: {
		ClassroomHeader,
		DailyAnswerReport,
		StudentReport,
	},
	filters:{
		timeFormat(time){
			return this.$dayjs(time,'hh:mm:ss').format('hh:mm A');
		}
	},
	data() {
		return {
			showLoader:true,
			today_report: null,
			today_assignment: null,
			is_available: false,
			user_detail:null,
			current_report:null,
			daily_reports:[],
		};
	},
	computed:{
		isAssignmentEnded(){
			return this.$dayjs().isAfter(this.$dayjs(this.today_assignment.end_time,'hh:mm:ss'));
		},
		cardColor(){
			if(this.is_available){
				return 'bg-success';
			}else if(this.isAssignmentEnded){
				return 'bg-danger';
			}
			return 'bg-warning';
		}
	},
	mounted() {
		
		history.pushState(null, null);
		window.addEventListener('popstate', (event)=> {
			window.location='/classroom/' + this.$route.params.classroomId;
			return false;
		});
		this.getDailyReports();
	},
	methods:{
		getDailyReports(){
			let url='/api/classroom/' + this.$route.params.classroomId + '/get-assignment-report';
			if(this.$route.name==='ClassroomStudentPanel'){
				url=url+'/'+this.$router.currentRoute.params.userId;
			}
			this.axios.get(url).then((
				resp) => {
				this.today_report = resp.data.success.today_report;
				this.user_detail = resp.data.success.user_detail;
				this.today_assignment = resp.data.success.today_assignment;
				this.is_available = resp.data.success.is_available;
				this.showLoader = false;
			});    
		},
	}
};

</script>
