<template>
  <div class="row add_cl_q">
    <div class="col-md-12">
      <div class="text-grey col-md-12">
        <p>
          Students have attempted this unit.
        </p>
      </div>

      <div
        v-for="(question,index) in dailyAssignmentData.daily_questions"
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
              v-for="(choice,index) in question.multiple_choice"
              :key="index"
              class="row"
            >
              <div class="col-md-9 mb-1 mt-1 ">
                <div :class="['row line-height-30', choice.option_order === question.correct_answer ? 'bg-card-green text-white' : 'bg-card-gray', 'p-2']">
                  <div :class="[choice.option_order === question.correct_answer ? 'bg-circle-white' : 'bg-circle']">
                    {{ letters[index] }}
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
</template>
<script>
export default {
	props:['assignment'],
	data(){
		return{
			dailyAssignmentData:[],
		};
	},
	mounted(){
		this.axios.get('/api/daily-assignment-details/'+this.assignment.id)
			.then((resp)=>{
				this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
			});
	}
};
</script>