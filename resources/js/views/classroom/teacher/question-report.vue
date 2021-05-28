<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="false"
    />
    
    <div class="">
      <div class="col-md-12">
        <div class="text-grey col-md-12">
          <p>
            Students have attempted this unit.
          </p>
        </div>
        <div class="row">
          <single-value
            :value="assignment.total_attempt"
            label="Total Attempts"
          />
          <single-value
            :value="assignment.average_score"
            label="Average Score"
          />
          <single-value
            :value="assignment.average_duration"
            label="Average Duration"
          />
        </div>
        <linear-graph
          :low-count="assignment.low_count"
          :med-count="assignment.medium_count"
          :high-count="assignment.high_count"
        />
        <div
          v-for="(question,index) in daily_questions"
          :key="index"
          class="row"
        >
          <div class="col-md-6 border-bottom-1px ml-3 p-3 mb-3">
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
                    <div :class="['row line-height-30', choice.is_correct ? 'bg-card-green text-white' : 'bg-card-gray', 'p-2']">
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
          <div class="col-md-4 border-bottom-1px ml-3 p-3 mb-3">
            <doughnut-graph
              v-if="question && question.pie_data"
              :graph-data="question.pie_data"
            />
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
import SingleValue from '../../../components/SingleValue';
import LinearGraph from '../../../components/graphs/LinearGraph';
import DoughnutGraph from '../../../components/graphs/DoughnutGraph';

export default {
	components: {
		SingleValue,
		LinearGraph,
		DoughnutGraph
	},
	props:['assignmentId'],
	data() {
		return {
			showLoader:true,
			assignment: [],
			daily_questions: [],
			marks: 10
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
				.get('/api/classroom/' + this.$route.params.classroomId + '/assignment/'+this.assignmentId+'/reports')
				.then((resp) => {
					let summary_data = resp.data.success.summary_data;
					let score_data = resp.data.success.score_data;
					this.assignment={
						total_attempt:summary_data.total_attempt,
					  average_score:parseFloat(summary_data.average_score).toFixed(1),
					  average_duration:this.countTime(summary_data.average_duration),
						// making new nodes for scores in linearGraph
						high_count: score_data.high_count,
						low_count: score_data.low_count,
						medium_count: score_data.medium_count,
					};

					this.daily_questions = resp.data.success.daily_questions;
					let questions_data = resp.data.success.questions_data;
					this.daily_questions.map(question => {
						question.pie_data = questions_data.filter(node2 => node2.question_id === question.id).map(node2=>{
							node2.label = 'Option '+this.letters[node2.label];
							return node2;
						});
					});

					this.showLoader=false;
				});
		},
		countTime(str){
			const [hh = '0', mm = '0', ss = '0'] = (str || '0:0:0').split(':');
			const hour = parseInt(hh, 10) || 0;
			const minute = parseInt(mm, 10) || 0;
			const second = parseInt(ss, 10) || 0;
			let totalSec = (hour*3600) + (minute*60) + (second);
			const totalHrs = Math.floor(totalSec / 60 / 60);
			const totalMin = Math.floor(totalSec / 60) - (totalHrs * 60);
			return `${totalHrs>0?totalHrs+' hr':''} ${totalMin>0?totalMin+' min':''}`;
		}
	},
};
</script>
