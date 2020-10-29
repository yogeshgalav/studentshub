<template>
  <div>
    <div class="row">
      <div class="col-md-2">
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
          <div class="col-md-4">
            <select class="form-control minimal">
              <option>
                Select Date
              </option>
            </select>
          </div>
        </div>
       <div class="row">
         <div class="col-md-12">
            <div class="card mt-3 mb-3  bg-default ">
          <div class="card-header">
           <div class="row">
             <div class="col-md-8">
 <h3 class="font-size-18  mb-1 mt-1 light-black">
              {{ 'Attempted Questions Status' }}
            </h3>
             </div>
             <div class="col-md-4 text-right">
               <h3 class="font-size-18  mb-1 mt-1 light-black">
             Marks obtained: <span class="text-success">{{ current_report.marks_obtained }}</span> | Rank: <span class="text-success">{{ current_report.rank }}</span>
            </h3>
             </div>
           </div>

          </div>
          <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
             <div class="col-md-12 mt-2 mb-2">
                <div class="row border-bottom">
                  <div class="col-md-10 pl-0">
                    <p class="font-16  weight-800 mb-1 mt-2 light-black">
                      Question: 1
                    </p>
                  </div>
                  <div class="col-md-2 text-right">
                    <label class="btn_marks font-16 light-black">
                      Marks: <span>10</span>
                    </label>
                  </div>
                </div>
               
                <div class="row">
                    <div class="col-md-12 pl-0">
                  <p class="font-16   mt-3 light-black">
                   is the first question which attempted by user  ?
                    </p>

                    <div class="option_box text-black outline-gray">
                     <span class="weight-800 border-right-gray option_word"> A </span>   This is the first question which attempted by user.  This is the first question which attempted by user  ?
                    </div>

                      <div class="option_box text-black outline-gray">
                     <span class="weight-800 border-right-gray option_word"> B </span>   This is the first question which attempted by user.  This is the first question which attempted by user  ?
                    </div>

                      <div class="option_box   bg-success-light outline-success text-white">
                     <span class="weight-800 border-right-success  option_word"> C </span>   This is the first question which attempted by user.  This is the first question which attempted by user  ?
                    </div>
              </div>


              
                </div>
              </div>


               <div class="col-md-12 mt-2 mb-2">
                <div class="row border-bottom">
                  <div class="col-md-10 pl-0">
                    <p class="font-16  weight-800 mb-1 mt-2 light-black">
                      Question: 1
                    </p>
                  </div>
                  <div class="col-md-2 text-right">
                    <label class="btn_marks font-16 light-black">
                      Marks: <span>10</span>
                    </label>
                  </div>
                </div>
               
                <div class="row">
                    <div class="col-md-12 pl-0">
                  <p class="font-16   mt-3 light-black">
                   is the first question which attempted by user  ?
                    </p>

                    <div class="option_box text-black outline-gray">
                     <span class="weight-800 border-right-gray option_word"> A </span>   This is the first question which attempted by user.  This is the first question which attempted by user  ?
                    </div>

                      <div class="option_box text-black outline-gray">
                     <span class="weight-800 border-right-gray option_word"> B </span>   This is the first question which attempted by user.  This is the first question which attempted by user  ?
                    </div>

                      <div class="option_box   bg-success-light outline-success text-white">
                     <span class="weight-800 border-right-success  option_word"> C </span>   This is the first question which attempted by user.  This is the first question which attempted by user  ?
                    </div>
              </div>


              
                </div>
              </div>

            
            <div class="row">
             
              <div class="col-md-12 col-12 center-col">
                <div
                  v-for="(answer,index) in current_report.daily_answer"
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
                            {{ 'Marks:'+ ' ' + answer.daily_question.marks }}
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
                            {{ answer.daily_question.question_text }}
                          </div>
                        </div>
                      </div>
                      <div
                        v-for="(choice,index2) in answer.daily_question.multiple_choice"
                        :key="index2"
                        class="row"
                      >
                        <div class="col-md-9 mb-1 mt-1 ">
                          <div
                            v-if="choice.option_order===answer.daily_question.correct_answer"
                            class="row line-height-30 bg-card-green p-2"
                          >
                            <div class="'bg-circle-white'">
                              {{ letters[index2] }}
                            </div>
                            <span class="pl-2">  {{ choice.option_text }}  </span>
                          </div>
                          <div
                            v-else-if="choice.option_order===answer.selected_answer"
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
        </div>
         </div>
       </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
select.minimal {
    background-image: linear-gradient(45deg, transparent 50%, gray 50%), linear-gradient(135deg, gray 50%, transparent 50%), linear-gradient(to right, #ccc, #ccc);
    background-position: calc(100% - 20px) calc(1em + 4px), calc(100% - 15px) calc(1em + 4px), calc(100% - 2.8em) 0em;
    background-size: 5px 5px, 5px 5px, 1px 4em;
    background-repeat: no-repeat;
    padding: 0.8rem 2.8rem 0.8rem 1rem;
    background-color: #F6F5FF;
}
.light-black {
  color: #444040 !important;
}
.option_word {
  padding: 10px 12px;
    margin-right: 10px;
}
.font-16 {
  font-size: 16px !important;
}
.border-right-gray {
  border-right: 1px solid #ccc;
}
.border-right-success {
  border-right: 1px solid #1A8908;
  
}
.bg-success-light {
  background-color: #135B07;
  
}
.text-white {
  color: #fff;
}
.btn_marks {
   background-color: #E4E4E4; 
   padding:3px 15px 3px 15px;
   text-align: center;
   border-radius: 25px;
   width: auto;
}
.border-bottom {
  border-bottom: 1px solid #DEDEDE;
}
.option_box {
  width: 100%;
line-height: 40px;
margin: 10px 0px;
}
.outline-gray {
 border:1px solid #D6D6D6;
}
.outline-success {
  border:1px solid #1A8908;
}
</style>
<script>
export default {
	data(){
		return {
			current_report:[],
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
			});    
		},
		getDailyAnswer(report){
			this.axios.post('/api/classroom/' + this.$route.params.classroomId + '/get-daily-answers',{
				'report_id':report.id,
			}).then((
				resp) => {
				this.current_report = resp.data.success.current_report;                   
			});    
		}
	}
};
</script>