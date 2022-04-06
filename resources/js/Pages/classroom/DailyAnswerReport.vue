<template>
  <div class="col-md-12">
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="false"
      loader="dots"
    />
    <div class="card mt-3 mb-3  bg-default ">
      <div class="card-header">
        <div class="row">
          <div class="col-md-8">
            <h3 class="font-size-18  mb-1 mt-1 light-black">
              {{ 'Previous Assignments' }}
            </h3>
          </div>
        </div>
      </div>
      <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
        <div class="row">
          <div
            v-if="assignment_list.length"
            class="col-md-4"
          >
            <select
              class="form-control minimal"
              @change="getDailyAnswer($event)"
            >
              <option
                v-for="assignment in assignment_list"
                :key="assignment.id"
                :value="assignment.id"
              >
                {{ assignment.attempt_date }}
              </option>
            </select>
          </div>
        </div>
        <div
          v-if="daily_report"
          class="row"
        >
          <div class="col-md-4 mt-5">
            <h3 class="font-size-18  mb-1 mt-1 light-black">
              Marks obtained: <span class="text-success">{{ daily_report.marks_obtained }}</span> | Rank: <span class="text-success">{{ daily_report.rank }}</span>
            </h3>
          </div>
        </div>
        <hr>
        <div
          v-if="daily_report"
          class="row"
        >
          <div class="col-md-7 mt-2 mb-2">
            <div
              v-for="(question,index) in daily_questions"
              :key="index"
            >
              <div class="border-bottom">
                <div class="pl-0 questioncard mb-2">
                  <p class="font-16  weight-800 mb-1 mt-2 light-black">
                    {{ 'Question:' + ' ' + (index+1) }}
                  </p>
                </div>
                <div class="pl-0 text-right">
                  <label class="btn btn-white">
                    Marks: <span>{{ question.marks }}</span>
                  </label>
                </div>
              </div>
               
              <div>
                <div class="col-md-12 pl-0">
                  <p class="font-16   mt-3 light-black">
                    {{ question.question_text }}
                  </p>

                  <div
                    v-for="(choice,index2) in question.multiple_choice"
                    :key="index2"
                  >
                    <div 
                      v-if="choice.is_correct"
                      class="bg-success-light  option_box outline-success text-white"
                    >
                      <span 
                        class="weight-800 border-right-success  option_word"
                      > {{ letters[index2] }} </span>
                      {{ choice.option_text }}
                    </div>
                    <div 
                      v-else-if="choice.id===question.daily_answer[0].selected_option_id"
                      class="bg-warning  option_box outline-warning text-white"
                    >
                      <span 
                        class="weight-800 border-right-warning  option_word"
                      > {{ letters[index2] }} </span>
                      {{ choice.option_text }}
                    </div>
                    <div 
                      v-else
                      class="option_box text-black outline-gray"
                    >
                      <span 
                        class="weight-800 border-right-gray option_word"
                      > {{ letters[index2] }} </span>
                      {{ choice.option_text }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p
            v-if="$route.name === 'ClassroomStudentPanel'"
            class="font-size-18 weight-400"
          >
            Student has not attempted this assignment.
          </p>
          <p
            v-else
            class="font-size-18 weight-400"
          >
            You have not attempted this assignment.
          </p>
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
.border-right-warning {
  border-right: 1px solid #c7a107 !important;
  
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
  position: relative;
}
.btn-white {
  border-radius: 15px;
  border: 1px solid #000;
}
.option_box {
  width: 100%;
line-height: 40px;
margin: 10px 0px;
}
.questioncard{
  display: inline-block;
}
.pl-0.text-right{
  display: inline-block;
  position: absolute;
  right: 5%;
}
.outline-gray {
 border:1px solid #D6D6D6;
}
.outline-success {
  border:1px solid #1A8908;
}
  @media screen  and (max-width: 768px) { 
    .bg-default .text-right {
      text-align:  left !important;
  
}

  }

</style>
<script>
export default {
	props:['dailyReports','userId'],
	data(){
		return {
			events:'',
			showLoader:true,
			daily_report:null,
			daily_questions:[],
			assignment_list:[],
			assignment_id:[],
		};
	},
	watch:{
		userId(val){
			this.getDailyAnswer();
		}
	},
	mounted(){
		this.axios.get('/api/classroom/'+this.$route.params[0]+'/get-attempted-assignment-list')
			.then(resp=>{
				this.assignment_list=resp.data.success.assignment_list;
				this.showLoader = false;
				if(this.assignment_list.length){
					this.assignment_id = this.assignment_list[0].id;
					this.getDailyAnswer();
				}
			});
	},
	methods:{
		setAssignmentId(event) {
			this.showLoader = true;
			this.assignment_id= event.target.value;
			this.getDailyAnswer();
		},
		getDailyAnswer(event) {
			let url = '/api/assignment/' + this.assignment_id +'/user';
			if (this.$route.name === 'ClassroomStudentPanel') {
				url = url + '/' + this.userId;
			}else {
				url = url + '/' + this.AuthUser.id;
			}console.log(url);
			this.axios.get(url).then((resp) => {
				this.daily_report = resp.data.success.daily_report;
				this.daily_questions = resp.data.success.daily_questions;
				this.showLoader = false;
			});
		},
	}
};
</script>