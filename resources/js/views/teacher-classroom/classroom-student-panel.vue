<template>
  <div>
    <div class="row">
      <div class="col-md-2">
        <ul>
          <li
            v-for="report in daily_reports"
            :key="report.attempt_date"
            @click="getDailyAnswer(report.id)"
          >
            {{ report.attempt_date }}
          </li>
        </ul>
      </div>
      <div class="col-md-8">
        <div class="card mt-3 mb-3  bg-default ">
          <div class="card-header">
            <h3 class="text-center font-size-18 text-black">
              {{ 'Attempted Questions Status' }}
            </h3>
          </div>
          <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
            <div class="row">
              <div class="col-md-12 col-12 center-col">
                <div
                  v-for="(question,index) in daily_assignment.daily_questions"
                  :key="index"
                  class="col-md-6 border-bottom-1px ml-3 p-3 mb-3"
                >
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="weight-800">
                            {{ 'Question' + ' ' + (index+1) }} 
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label class="btn btn-white ">
                            {{ 'Marks:'+ ' ' + question.marks }}
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                    
                  <div class="row mt-2">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="mb-2 weight-500">
                            {{ question.question_text }}
                          </div>
                        </div>
                      </div>
                      <div
                        v-for="(choice,index2) in question.multiple_choice"
                        :key="index2"
                        class="row"
                      >
                        <div class="col-md-9 mb-1 mt-1 ">
                          <div
                            v-if="choice.option_order===question.correct_answer"
                            class="row line-height-30 bg-card-green p-2"
                          >
                            <div class="'bg-circle-white'">
                              {{ letters[index2] }}
                            </div>
                            <span class="pl-2">  {{ choice.option_text }}  </span>
                          </div>
                          <div
                            v-else-if="choice.option_order===question.my_daily_answer.selected_answer"
                            class="row line-height-30 bg-card-yellow p-2"
                          >
                            <div class="'bg-circle-white'">
                              {{ letters[index2] }}
                            </div>
                            <span class="pl-2">  {{ choice.option_text }}  </span>
                          </div>
                          <div
                            v-else
                            class="row line-height-30 bg-card-gray p-2"
                          >
                            <div class="bg-circle">
                              {{ letters[index2] }}
                            </div>
                            <span class="pl-2">  {{ choice.option_text }}  </span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12">
                <p class="text-black mb-1">
                  Marks obtained : <span class="text-success weight-800"> {{ daily_report.marks_obtained }} </span> | Rank : <span class="text-success weight-800"> {{ daily_report.rank }} </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
	data(){
		return {
			daily_assignment:[],
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
				url=url+'/'+this.$router.params.userId;
			}
			this.axios.get(url).then((
				resp) => {
				this.daily_reports = resp.data.success.daily_reports;
				this.daily_assignment = resp.data.success.daily_assignment;                   
			});    
		},
		getDailyAnswer(report_id){
			this.axios.post('/api/classroom/' + this.$route.params.classroomId + '/get-daily-answers',{
				'report_id':report_id,
			}).then((
				resp) => {
				this.daily_assignment = resp.data.success.daily_assignment;                   
			});    
		}
	}
};
</script>