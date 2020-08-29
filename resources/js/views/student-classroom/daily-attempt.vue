<template>
<div id="no-copy">
   <div class="card col-md-8 col-center p-0">
     <div class="card-header">
       Complete Daily Assignments
     </div>
     <div class="card-body">
       <form action="/save-daily-answers" method="POST">
       <input type="hidden" name="_token" :value="csrfToken" />
       <input type="hidden" name="daily_assignment_id" :value="DailyAssignment.id" />
       <input type="hidden" name="classroom_id" :value="DailyAssignment.classroom_id" />
                  <div
                    v-for="(question,index) in DailyAssignment.daily_questions"
                    :key="index"
                    class="col-md-12"
                  >
                    <div class="row">
                      <div class="col-md-12 mb-1 mt-3">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="weight-800">{{'Question' + (index+1)}} </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                   
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="mb-2">{{question.question_text}}</div>
                          </div>
                        </div>
                     <input
                          class="form-check-input"
                          type="hidden"
                          :name="'answers['+index+'][question_id]'"
                          :value="question.id"
                        />
                        <div
                          class="row"
                          v-for="(choice,index2) in question.multiple_choice"
                          :key="index2"
                        >
                       
                          <div class="col-md-3">{{'Option ' + letters[index2]}}</div>
                          <div class="col-md-3">{{choice.option_text}}</div>
                          <div class="col-md-1" >
                            <div class="form-check ml-3 mt-2">
                        <input
                          class="form-check-input"
                          type="radio"
                          :name="'answers['+index+'][answer]'"
                          :id="'correctAnswer'+index2"
                          :value="choice.option_order"
                        />
                       
                      </div>
                      </div>
                     
                        </div>
                        
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 mt-3">
                     <button type="submit" class="btn btn-primary">Submit Answers</button>
                  </div>
                        </form>
     </div>
   </div>
</div>
</template>
<style scoped>
      #no-copy {
        user-select: none;
      }
      #no-copy::selection {
        background: none;
      }
      #no-copy::-moz-selection {
        background: none;
      }
      .col-center {
       margin:auto;
      }
</style>
<script>
export default {
  props:['DailyAssignment'],
  computed:{
    letters() {
      let letters = [];
      for (let i = "A".charCodeAt(0); i <= "Z".charCodeAt(0); i++) {
        letters.push(String.fromCharCode([i]));
      }
      return letters;
    },
  },
    mounted(){
        var target = document.getElementById("no-copy");
        
        // PREVENT CONTEXT MENU FROM OPENING
        target.addEventListener("contextmenu", function(evt){
          evt.preventDefault();
        }, false);
 
        // PREVENT CLIPBOARD COPYING
        target.addEventListener("copy", function(evt){
          // Change the copied text if you want
          evt.clipboardData.setData("text/plain", "");
          // Prevent the default copy action
          evt.preventDefault();
        }, false);
    }
}
</script>