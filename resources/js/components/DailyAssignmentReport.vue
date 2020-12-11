<template>
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
              Marks obtained: <span class="text-success">{{ currentReport.marks_obtained }}</span> | Rank: <span class="text-success">{{ currentReport.rank }}</span>
            </h3>
          </div>
        </div>
      </div>
      <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
        <div
          v-for="(answer,index) in currentReport.daily_answer"
          :key="index"
          class="col-md-12 mt-2 mb-2"
        >
          <div class="row border-bottom">
            <div class="col-md-10 pl-0">
              <p class="font-16  weight-800 mb-1 mt-2 light-black">
                {{ 'Question:' + ' ' + (index+1) }}
              </p>
            </div>
            <div class="col-md-2 text-right">
              <label class="btn_marks font-16 light-black">
                Marks: <span>{{ answer.daily_question.marks }}</span>
              </label>
            </div>
          </div>
               
          <div class="row">
            <div class="col-md-12 pl-0">
              <p class="font-16   mt-3 light-black">
                {{ answer.daily_question.question_text }}
              </p>

              <div
                v-for="(choice,index2) in answer.daily_question.multiple_choice"
                :key="index2"
              >
                <div 
                  v-if="choice.option_order===answer.daily_question.correct_answer"
                  class="bg-success-light outline-success text-white"
                >
                  <span 
                    class="weight-800 border-right-success  option_word"
                  > {{ letters[index2] }} </span>
                  {{ choice.option_text }}
                </div>
                <div 
                  v-else-if="choice.option_order===answer.selected_answer"
                  class="bg-success-light outline-success text-white"
                >
                  <span 
                    class="weight-800 border-right-success  option_word"
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
  </div>
</template>
<script>
export default {
	props:['currentReport']
};
</script>