<template>
  <div>
    <span class="text-blue">{{ timer }}</span>
    <div id="no-copy">
      <div class="card col-md-8 col-center p-0">
        <div class="card-header">
          Complete Daily Assignments
        </div>
        <div class="card-body">
          <form
            action="/save-daily-answers"
            method="POST"
            @submit="sumbitAttempt"
          >
            <input
              type="hidden"
              name="_token"
              :value="csrfToken"
            >
            <input
              type="hidden"
              name="daily_assignment_id"
              :value="dailyAssignment.id"
            >
            <input
              type="hidden"
              name="classroom_id"
              :value="dailyAssignment.classroom_id"
            >
            <input
              type="hidden"
              name="time"
              :value="timer"
            >
            <div
              v-for="(question,index) in dailyAssignment.daily_questions"
              :key="index"
              class="col-md-12"
            >
              <div class="row">
                <div class="col-md-12 mb-1 mt-3">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="weight-800">
                        {{ 'Question' + (index+1) }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                   
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="mb-2">
                        {{ question.question_text }}
                      </div>
                    </div>
                  </div>
                  <input
                    class="form-check-input"
                    type="hidden"
                    :name="'answers['+index+'][question_id]'"
                    :value="question.id"
                  >
                  <div
                    v-for="(choice,index2) in question.multiple_choice"
                    :key="index2"
                    class="row"
                  >
                    <div class="col-md-1">
                      <div class="form-check ml-3 mt-2">
                        <input
                          :id="'correctAnswer'+index2"
                          v-validate="'required'"
                          class="form-check-input"
                          type="radio"
                          :name="'answers['+index+'][answer]'"
                          :value="choice.option_order"
                        >
                      </div>
                    </div>
                    <div class="col-md-3">
                      {{ choice.option_text }}
                    </div>
                  </div>
                  <span class="error">{{ formErrors('answers['+index+'][answer]') ? 'Please answer this question.' : '' }}</span>
                </div>
              </div>
            </div>
            <div class="col-md-12 mt-3">
              <button
                type="submit"
                class="btn btn-primary"
                @click="clearInterval(interval)"
              >
                Submit Answers
              </button>
            </div>
          </form>
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
      .col-center {
       margin:auto;
      }
</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import dayjs from 'dayjs';
var customParseFormat = require('dayjs/plugin/customParseFormat');
dayjs.extend(customParseFormat);

export default {
	mixins: [FormMixin],
	props:['dailyAssignment'],
	data(){
		return {
			timer:'00:00',
			interval:null
		};
	},
	mounted(){
		var target = document.getElementById('no-copy');
        
		// PREVENT CONTEXT MENU FROM OPENING
		target.addEventListener('contextmenu', function(evt){
			evt.preventDefault();
		}, false);
 
		// PREVENT CLIPBOARD COPYING
		target.addEventListener('copy', function(evt){
			// Change the copied text if you want
			evt.clipboardData.setData('text/plain', '');
			// Prevent the default copy action
			evt.preventDefault();
		}, false);

		this.interval=setInterval(()=>{
			this.timer=dayjs(this.timer,'mm:ss').add(2,'seconds').format('mm:ss');
		}, 2000);
	},
	methods:{
		sumbitAttempt(e){
			this.$validator.validate().then(valid => {
				if (valid) {
					return true;
				}else{
					e.preventDefault();
				}
			});
		}
	}
};
</script>