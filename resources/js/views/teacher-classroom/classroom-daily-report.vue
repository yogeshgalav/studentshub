<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="row">
      <div class="col-md-12">
        <classroom-header
          title="Daily Report"
        />
      </div>
    </div>
    <div
      v-for="(daily,index) in dailyAssignmentData"
      :key="index"
      class="card mt-5"
    >
      <div>
        <div class="row">
          <div class="col-md-12">
            <accordion
              :title="daily.attempt_date"
              :aria-expanded="true"
              tab="accordion_status_unit_active"
            >
              <div class="">
                <div class="col-md-12">
                  <div class="text-grey col-md-12">
                    <p>
                      Students have attempted this unit.
                    </p>
                  </div>
                <div class="row">
                    <single-value :value="'1'" label="Total Attempts" />
                    <single-value :value="summary.average_score" label="Average Score" />
                    <single-value :value="summary.average_duration" label="Average Duration" />
                </div>
                  <div
                    v-for="(question,index) in daily.daily_questions"
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
                              <div class="bg-circle">
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
            </accordion>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
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
.line-height-55  {
  line-height: 55px;
}
</style>
<script>
import Vue from 'vue';

import Accordion from '../../components/accordion';

import ClassroomHeader from '../../components/ClassroomHeader';

import SingleValue from '../../components/SingleValue';

export default {
	components: {
		Accordion,
		ClassroomHeader,
    SingleValue
	},
	data() {
		return {
			showLoader:true,
			dailyAssignmentData: {},
			marks: 10,
      summary:null
		};
	},
	computed: {
		classroomDetail() {
			return this.$store.state.classroom.classroomDetail;
		},
	},
	mounted() {
		this.getDailyDetails();
	},
	methods: {
		getDailyDetails() {
			this.axios
				.get('/api/classroom/' + this.$route.params.classroomId + '/daily-assignment-reports')
				.then((resp) => {
					this.unitList = resp.data.success.unitList;
					this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
                    this.summary = resp.data.success.summary;
                    console.log(this.summary);
					this.showLoader=false;
				});
		},
	},
};
</script>
