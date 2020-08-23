<template>
<div id="no-copy">
  
                  <div
                    v-for="(question,index) in DailyQuestions"
                    :key="index"
                    class="col-md-12"
                  >
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="weight-800">{{'Question' + (index+1)}} <button  title ="Edit" class="btn btn-link"  @click="addQuestion(daily.attempt_date)"><i class="fa fa-edit"></i> </button>  <button  title="Delete" class="btn btn-link p-0"><i class="fa fa-trash text-danger"></i> </button></div>
                          </div>
                          <div class="col-md-6">
                            <div class="text-success">{{'Marks' + question.marks}}</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <hr />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="mb-2">{{question.question_text}}</div>
                          </div>
                        </div>

                        <div
                          class="row"
                          v-for="(choice,index) in question.multiple_choice"
                          :key="index"
                        >
                          <div class="col-md-3">{{'Option ' + letters[index]}}</div>
                          <div class="col-md-3">{{choice.option_text}}</div>
                          <div class="col-md-1" v-if="choice.is_correct === 1"><i class="fa fa-check-circle text-success"></i></div>
                        </div>
                      </div>
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
</style>
<script>
export default {
  props:['DailyQuestions'],
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