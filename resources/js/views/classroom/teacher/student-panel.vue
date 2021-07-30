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
    <div
      class="habit-footer"
    >
      <div class="col-md-12">
        <div
          class="row habit-footer_1 mt-1 ml-280"
        >
          <div class="col-md-6   text-right">
            <div class="mr-3">
              <button
                class="btn btn-secondary"
                type="button"
                @click="prevStud"
              >
                <i class="fas fa-chevron-left" />
              </button>
              <p>{{ current_user_name }}</p>
              <button
                type="button"
                class="btn btn-secondary"
                @click="nextStud"
              >
                <i class="fas fa-chevron-right" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
@media only screen and (max-width: 1024px) {

  .habit-footer .btn-secondary {
    padding: 15px 5%;
    margin: 20px 0px;
  }
  .habit-footer .btn-secondary {
    padding: 9px 5%;

  }
}
@media only screen and (min-width: 768px) and (max-width: 1240px) {

  
   .habit-footer .btn-secondary {
    padding: 15px 5%;

  }
  .habit-footer .offset-2 {
    margin-left: 30.6666666667% !important;
  }
}
@media (max-width: 1024px) and (min-width: 768px)
{
	.habit-footer .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}
}
@media only screen and (max-width: 768px) {
  .habit-footer .btn-secondary {

    font-size: 0.7rem;
  }
  .habit-footer .text-right {
	  text-align: left !important;
  }

  .habit-footer .font-siz-16 {
    font-size: 13px;
  }
  .habit-footer {
    padding-bottom: 5px;
  }
}

@media only screen and (max-width: 374px) {
  .habit-footer {
    padding-bottom: 25px;
  }
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
			current_user_name:'',
			curIndex:'',
			studentIds:[],
			current_user_id:this.$router.currentRoute.params.userId,
			today_report: null,
			today_assignment: null,
			is_available: false,
			user_detail: null,
		};
	},
	mounted(){
		this.studentIds = localStorage.getItem('studentids');
		//getting the index from the current user array
		student_ids.forEach((element,index) => {
			if(element.user_id === this.current_user_id){
				this.curIndex = index;
			}
		});
		//setting the name
		this.current_user_name = this.studentIds[this.curIndex].user_name;
	},
	methods:{
		nextStud(){
			if (this.hasnext()) {
				this.curIndex += 1;
				this.current_user_id = this.studentIds[this.curIndex].userId;
				this.current_user_name = this.studentIds[this.curIndex].user_name;
			}
		},
		prevStud(){
			if (this.hasprev()) {
				this.curIndex -= 1;
				this.current_user_id = this.studentIds[this.curIndex].userId;
				this.current_user_name = this.studentIds[this.curIndex].user_name;
			}
		},
		hasprev() {
			return this.curIndex - 1 >= 0;
		},
		hasnext() {
			return this.curIndex + 1 <= this.studentIds.length - 1;
		},
	}
};
</script>
