<template>
  <div class="col-md-8 col-center">
    <div v-if="daily_report!==null">
      <div
        id="reflection-complete"
        class="card mt-3 mb-3  bg-success "
      >
        <div class="card-header">
          <h3 class="text-center font-size-18 text-white">
            {{ 'Daily Assignment' }}
          </h3>
        </div>
        <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
          <div class="row">
            <div class="col-md-12 col-12 center-col">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    {{ 'Daily Assisment for today is completed' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
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
                    Marks obtained: <span class="text-success">{{ daily_report.marks_obtained }}</span> | Rank: <span class="text-success">{{ daily_report.rank }}</span>
                  </h3>
                </div>
              </div>
            </div>
            <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
              <div
                v-for="(question,index) in daily_assignment.daily_questions"
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
                      Marks: <span>{{ question.marks }}</span>
                    </label>
                  </div>
                </div>
               
                <div class="row">
                  <div class="col-md-12 pl-0">
                    <p class="font-16   mt-3 light-black">
                      {{ question.question_text }}
                    </p>

                    <div
                      v-for="(choice,index2) in question.multiple_choice"
                      :key="index2"
                    >
                      <div 
                        v-if="choice.option_order===question.correct_answer"
                        class="bg-success-light outline-success text-white"
                      >
                        <span 
                          class="weight-800 border-right-success  option_word"
                        > {{ letters[index2] }} </span>
                        {{ choice.option_text }}
                      </div>
                      <div 
                        v-else-if="choice.option_order===question.my_daily_answer.selected_answer"
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
      </div>
    </div>
    <div v-if="daily_report===null && daily_assignment===null">
      <div
        id="reflection-complete"
        class="card mt-3 mb-3  bg-success "
      >
        <div class="card-header">
          <h3 class="text-center font-size-18 text-white">
            {{ 'Daily Assignment' }}
          </h3>
        </div>
        <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
          <div class="row">
            <div class="col-md-12 col-12 center-col">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    {{ 'There is no Daily Assignment for today.' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="daily_report===null && daily_assignment!==null">
      <div
        id="reflection-incomplete"
        class="card mt-3 mb-3 bg-primary border-primary"
      >
        <div class="card-header ">
          <h3 class="text-center font-size-18 text-white">
            {{ 'Daily Assignment' }}
          </h3>
        </div>
        <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
          <div class="row">
            <div class="col-md-12 col-12 center-col">
              <div
                v-if="is_available"
                class="row"
              >
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    <span
                      class="weight-800 text-black"
                    >
                      {{ 'Daily assisgment for today is remaining' }}
                    </span>
                  </p>
                  <a
                    id="reflection-link"
                    class="btn btn-success text-white"
                    :href="'/classroom/' + $route.params.classroomId +'/daily-attempt'"
                  >
                    {{ 'Attempt now' }}
                  </a>
                </div>
              </div>
              <div
                v-else-if="isAssignmentEnded"
                class="row"
              >
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    <span
                      class="weight-800 text-black"
                    >
                      {{ 'Daily assisgment for today has been ended at ' }}{{ daily_assignment.end_time | timeFormat }}
                    </span>
                  </p>
                </div>
              </div>
              <div
                v-else
                class="row"
              >
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    <span
                      class="weight-800 text-black"
                    >
                      {{ 'Daily assisgment for today will start at ' }}{{ daily_assignment.start_time | timeFormat }}
                    </span>
                  </p>
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
    .col-center {
        margin: auto;
    }

</style>
<script>
import dayjs from 'dayjs';
export default {
	filters:{
		timeFormat(time){
			return dayjs(time,'hh:mm:ss').format('hh:mm A');
		}
	},
	data() {
		return {
			daily_report: null,
			daily_assignment: null,
			is_available: false,
		};
	},
	computed:{
		isAssignmentEnded(){
			return dayjs().isAfter(dayjs(this.daily_assignment.end_time,'hh:mm:ss'));
		}
	},
	mounted() {
		this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-todays-report').then((
			resp) => {
			this.daily_report = resp.data.success.daily_report;
			this.daily_assignment = resp.data.success.daily_assignment;
			this.is_available = resp.data.success.is_available;
                   
		});
	}
};

</script>
