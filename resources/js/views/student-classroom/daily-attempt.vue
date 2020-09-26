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
                      <button
                        class="btn btn-white "
                        type="button"
                      >
                        {{ 'Marks:'+ ' ' + question.marks }}
                      </button>
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

                  <input
                    v-if="answers[index]"
                    type="hidden"
                    :name="'answers['+index+'][answer]'"
                    :value="answers[index]['answer']"
                  >
                  <input
                    v-if="answers[index]"
                    type="hidden"
                    :name="'answers['+index+'][question_id]'"
                    :value="question.id"
                  >
                  <div
                    v-for="(choice,index2) in question.multiple_choice"
                    :key="index2"
                    class="row"
                  >
                    <div class="col-md-9 mb-1 mt-1 ">
                      <div
                        :class="['row line-height-30', choice.option_order === answers[index]['answer'] ? 'bg-card-green text-white' : 'bg-card-gray', 'p-2']"
                        @click="selectAnswer(index,index2)"
                      >
                        <div
                          :class="[choice.option_order === answers[index]['answer'] ? 'bg-circle-white' : 'bg-circle']"
                        >
                          {{ letters[index2] }}
                        </div>
                        <span class="pl-2">  {{ choice.option_text }}  </span>
                      </div>
                    </div>
                  </div>
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
.delete_btn {
  padding: 0 22px 0 22px;
  font-size: 18px;
}
.btn-white {
  border-radius: 15px;
  border: 1px solid #000;
}
.border-1px  {
  border:1px solid #ccc;
}
.bg-gray {
  background-color: #eee;display: flex;
  line-height: 30px;
}

.border-bottom-1px  {
  border-bottom:1px dashed #ccc !important;
}
.line-height-30 {
   line-height: 30px !important;
}
.bg-circle {
  border-radius: 50%;
    border: 1px solid #000;
    width: 30px;
    height: 30px;
    text-align: center;
    vertical-align: middle;
    line-height: 30px;
    font-weight: 700;
}
.bg-circle-white {
   border-radius: 50%;
    border: 1px solid black;
    width: 30px;
    height: 30px;
    text-align: center;
    vertical-align: middle;
    line-height: 30px;
    font-weight: 700;
}
.line-height-55  {
  line-height: 55px;
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
			answers:[],
			interval:null
		};
	},
	computed:{
		letters() {
			let letters = [];
			for (let i = 'A'.charCodeAt(0); i <= 'Z'.charCodeAt(0); i++) {
				letters.push(String.fromCharCode([i]));
			}
			return letters;
		},
	},
	mounted(){
		this.answers=this.dailyAssignment.daily_questions.map(node=>{
			return {
				'question_id': node.id,
				'answer': '',
			};
		});
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
		},
		selectAnswer(index,index2){
			this.answers[index]['answer']= this.dailyAssignment.daily_questions[index].multiple_choice[index2].option_order;
		}
	}
};
</script>