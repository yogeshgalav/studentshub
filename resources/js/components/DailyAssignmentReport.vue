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
            <div class="col-md-2 pl-0 text-right">
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
                  class="bg-success-light  option_box outline-success text-white"
                >
                  <span 
                    class="weight-800 border-right-success  option_word"
                  > {{ letters[index2] }} </span>
                  {{ choice.option_text }}
                </div>
                <div 
                  v-else-if="choice.id===answer.selected_answer"
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
  @media screen  and (max-width: 768px) { 
    .bg-default .text-right {
      text-align:  left !important;
  
}

  }

</style>
<script>
export default {
	props:['currentReport']
};
</script>