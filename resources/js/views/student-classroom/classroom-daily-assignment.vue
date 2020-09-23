<template>
  <div class="col-md-8 col-center">
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
    <div v-if="daily_report!==null && daily_assignment!==null">
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

      <div class="card mt-3 mb-3  bg-default ">
        <div class="card-header">
          <h3 class="text-center font-size-18 text-black">
            {{ 'Attempted Questions Status' }}
          </h3>
        </div>
        <div class="card-body bg-white border-bottom-left-8 border-bottom-right-8">
          <div class="row">
            <div class="col-md-12 col-12 center-col">
              <div
                v-for="(question,index) in daily_assignment.daily_questions"
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
                    <div
                      v-for="(choice,index2) in question.multiple_choice"
                      :key="index2"
                      class="row"
                    >
                      <div class="col-md-1">
                        <div class="form-check ml-3 ">
                          <input
                            :id="'correctAnswer'+index2"
                            class="form-check-input"
                            type="radio"
                            disabled
                            :name="'answers['+index+'][answer]'"
                            :value="choice.option_order"
                          >
                        </div>
                      </div>
                       
                      <div class="col-md-3">
                        {{ choice.option_text }}
                      </div>
                      <div
                        v-if="choice.is_correct"
                        class="col-md-3"
                      >
                        <i class="fa fa-check text-success" />
                      </div>
                      <div
                        v-else
                        class="col-md-3"
                      >
                        <i class="fa fa-times text-danger" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-md-12">
              <p class="text-black mb-1">
                Marks obtained : <span class="text-success weight-800"> {{ daily_report.marks_obtained }} </span> | Rank : <span class="text-success weight-800"> {{ daily_report.rank }} </span>
              </p>
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
              <div class="row">
                <div class="col-md-12 col-lg-12 col-12 text-center">
                  <p>
                    <span class="weight-800 text-black">
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
export default {
	data() {
		return {
			daily_report: null,
			daily_assignment: null,
               
		};
	},
	mounted() {
		this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/get-student-daily-report').then((
			resp) => {
			this.daily_report = resp.data.success.daily_report;
			this.daily_assignment = resp.data.success.daily_assignment;
                   
		});
	}
};

</script>
