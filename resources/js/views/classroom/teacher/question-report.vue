<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
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
            :value="daily.total_attende"
            label="Total Attempts"
          />
          <single-value
            :value="daily.average_score"
            label="Average Score"
          />
          <single-value
            :value="daily.average_duration"
            label="Average Duration"
          />
        </div>
        <linear-graph
          :low-count="daily.low_count"
          :med-count="daily.medium_count"
          :high-count="daily.high_count"
        />
        <div
          v-for="(question,index) in daily.daily_questions"
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
	data() {
		return {
			showLoader:true,
			dailyAssignmentData: [],
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
				.get('/api/classroom/' + this.$route.params.classroomId + '/daily-assignment-reports')
				.then((resp) => {
					this.unitList = resp.data.success.unitList;
					this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
					let summaryData = resp.data.success.summary;
					let scoresData = resp.data.success.scores;
					let questionsData = resp.data.success.questionsdata;
					const countTime = (str) => {
						const [hh = '0', mm = '0', ss = '0'] = (str || '0:0:0').split(':');
						const hour = parseInt(hh, 10) || 0;
						const minute = parseInt(mm, 10) || 0;
						const second = parseInt(ss, 10) || 0;
						let totalSec = (hour*3600) + (minute*60) + (second);
						const totalHrs = Math.floor(totalSec / 60 / 60);
						const totalMin = Math.floor(totalSec / 60) - (totalHrs * 60);
						return `${totalHrs>0?totalHrs+' hr':''} ${totalMin>0?totalMin+' min':''}`;
					};
					this.dailyAssignmentData.map((node)=>{
						let summary = summaryData.find(node2=>node2.daily_assignment_id===node.id);
						node.total_attende=summary.total_attende;
						node.average_score=parseFloat(summary.average_score).toFixed(1);
						node.average_duration=countTime(summary.average_duration);
						// making new nodes for scores in linearGraph
						let scores = scoresData.find(node2=>node2.daily_assignment_id===node.id);
						node.high_count = scores.high_count;
						node.low_count = scores.low_count;
						node.medium_count = scores.medium_count;

						node.daily_questions.map(question => {
							question.pie_data = questionsData.filter(node2 => node2.question_id === question.id).map(node2=>{
								node2.label = 'Option '+this.letters[node2.label];
								return node2;
							});

						});
						return node;
					});
					this.showLoader=false;
				});
		},
	},
};
</script>
