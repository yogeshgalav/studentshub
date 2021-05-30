<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header
      title="Unit Setup"
    />
    <div class="mt-2">
      <button
        class="btn-primary btn-lg"
        @click="addUnit"
      >
        <i class="fas fa-plus" />&nbsp;&nbsp;Add Unit
      </button>
    </div>
    <div
      v-for="(unit,index) in unitData"
      :key="index"
      class="card mt-5"
    >
      <div>
        <div class="row">
          <div class="col-md-12">
            <accordion
              :title="'Unit '+unit.unit_no+': '+unit.unit_name"
              :aria-expanded="true"
              tab="accordion_status_unit_active"
            >
              <div class="">
                <div class="col-md-6 col-12">
                  <div class="form-group pl-0">
                    <label
                      class="text-black mb-1"
                      :for="'unit_name' + index"
                    >{{ 'Unit Name' }}</label>
                    <input
                      :id="'unit_name' + index"
                      v-model="unit.unit_name"
                      v-validate="'required'"
                      type="text"
                      class="form-control"
                      :name="'unit_name' + index"
                      @blur="updateUnitName(unit.unit_no,$event)"
                    >
                    <span class="error">{{ formErrors('unit_name' + index) }}</span>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center col-md-12">
                <single-value
                  :value="unit.assignmentCount"
                  label="Daily Assignments"
                  :link="'/classroom/'+$route.params.classroomId+'/daily-assignment'"
                />
                <single-value
                  :value="unit.average_score"
                  label="Average Score"
                />
                <single-value
                  :value="unit.resources"
                  label="Resources"
                  :link="'/classroom/'+$route.params.classroomId+'/resources'"
                />
              </div>
              <div class="row justify-content-center col-md-12">
                <single-value
                  :value="unit.first_score"
                  label="First score"
                />
                <single-value
                  :value="unit.last_score"
                  label="Last Score"
                />
                <single-value
                  :value="unit.progress + '%'"
                  label="Progress"
                />
              </div>

              <div class="col-md-12 mt-3">
                <doughnut-graph
                  v-if="unit.pieGraphData.length"
                  :key="unit.id"
                  :graph-data="unit.pieGraphData"
                />
              </div>
              <div class="col-md-12 mt-3">
                <bar-line-graph 
                  v-if="unit.assignment_data.length"
                  :key="unit.id"
                  line-label="Average score"
                  bar-label="Total attempts"
                  :line-data="unit.assignment_data.map(node=>node.average_score)"
                  :bar-data="unit.assignment_data.map(node=>node.total_attempt)"
                  :x-axis-labels="unit.assignment_data.map(node=>node.attempt_date)"
                />
              </div>

              <div class="col-md-12">
                <vue-table-component
                  :key="unit.id"
                  :columns="assignmentColumn"
                  :rows="unit.assignment_data"
                >
                  <div slot="emptystate">
                    <p class="mt-3">
                      {{ 'Currently no assignments has been added to this unit.' }}
                    </p>
                  </div>
                </vue-table-component>
              </div>
            </accordion>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import FormMixin from '../../../components/mixins/form-mixin.js';
import Accordion from '../../../components/accordion';
import DoughnutGraph from '../../../components/graphs/DoughnutGraph';
import BarLineGraph from '../../../components/graphs/BarLineGraph';
import ClassroomHeader from '../../../components/ClassroomHeader';
import SingleValue from '../../../components/SingleValue';
import VueTableComponent from '../../../components/vue-table-component.vue';

export default {
	components: {
		Accordion,
		ClassroomHeader,
		SingleValue,
		DoughnutGraph,
		BarLineGraph,
		VueTableComponent
	},
	mixins:[FormMixin],
	data() {
		return {
			showLoader:true,
			unitData: [],
			assignmentColumn: [
				{
					label: 'Attempt Date',
					field: 'attempt_date',
				},
				{
					label: 'Total attempt',
					field: 'total_attempt',
				},
				{
					label: 'Average score',
					field: 'average_score',
				},
				{
					label: 'Average duration',
					field: 'average_duration',
				},
				{
					label: 'Total questions',
					field: 'total_questions',
				},
			],
		};
	},
	computed:{
		latestUnit(){
			return this.unitData.length ? this.unitData[0].unit_no : 0;
		},
	},
	mounted() {
		this.getUnitDetails();
	},
	methods: {
		getUnitDetails(){
			this.axios.get('/api/classroom/' + this.$route.params.classroomId + '/unit-details').then((resp) => {
				this.unitData = resp.data.success.unitData;
				let summaryData = resp.data.success.summary;

				const daily_assignment_status = resp.data.success.daily_assignment_status;
				const assignment_data = resp.data.success.assignment_data.map(node=>{
					// node.attempt_date = dayjs(node.attempt_date,'YYYY-MM-DD').format('D MMM, YYYY');
					if(node.average_duration){
						node.average_duration =  this.formatDuration(node.average_duration);
					}
					return node;
				});
				this.unitData.map((node)=>{
					let summary = summaryData.find(node2=>node2.id===node.id);
					node.assignmentCount=summary.assignmentCount;
					node.first_score=summary.first_score;
					node.last_score=summary.last_score;
					node.average_score=summary.average_score;
					node.progress=((summary.last_score-summary.first_score)/summary.last_score)*100;
					node.resources=summary.resources;
					node.pieGraphData = daily_assignment_status.filter(node2=>node2.unit_id===node.id).map(node2=>{
						node2.label = node2.status;
						node2.count = node2.assignmentCount;
						return node2;
					});
					node.assignment_data = assignment_data.filter(node2=>node2.unit_id===node.id);
					return node;
				});
				this.showLoader=false;
			});
		},
		addUnit() {
			this.unitData.unshift({
				'unit_no': this.latestUnit + 1,
				'unit_name': '',
			});

		},
		updateUnitName(unit_no,event) {
			this.showLoader = true;
			//call api and update field
			this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/update-unit',{
				unit_no: unit_no,
				unit_name: event.target.value
			}).then(()=>{
				this.showLoader = false;
			});
		}
	}
};

</script>
