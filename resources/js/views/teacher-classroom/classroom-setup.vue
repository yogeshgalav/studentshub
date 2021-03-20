<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <classroom-header />
    <div class="mt-2">
      <add-button
        name="Add Unit"
        size="lg"
        @submit="addUnit"
      />
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
              <div class="row add_cl_q">
                <div class="col-md-3 col-12">
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
                <div class="col-md-12">
                  <doughnut-graph :graph-data="unit.pieGraphData" />

                  <div
                    class="ml-3 mt-5"
                  >
                    <div
                      v-for="(status, index) in unit.pieGraphData"
                      :key="index"
                      class="session-report"
                    >
                      <p :class="[reportColorClasses[index] ,'weight-800 font-size-20 mb-0 mt-0']">
                        {{ status.assignmentCount }}
                        <span class="font-size-12 weight-400">{{ status.status }}</span>
                      </p>
                    </div>
                    <div class="divider mt-0 mb-0" />
                    <p class="text-black weight-800 font-size-12 mb-1 mt-0">
                      {{ unit.assignment_total }}
                      <span class="font-size-12">{{ 'Assignments' }}</span>
                    </p>
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
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import Accordion from '../../components/accordion';
import AddButton from '../../components/AddButton';
import DoughnutGraph from '../../components/graphs/PieGraph';
    
import ClassroomHeader from '../../components/ClassroomHeader';
    
export default {
	components: {
		Accordion,
		AddButton,
		ClassroomHeader,
		DoughnutGraph
	},
	mixins:[FormMixin],
	data() {
		return {
			showLoader:true,
			unitData: [],
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
				const daily_assignment_status = resp.data.success.daily_assignment_status;
				this.unitData.map((node)=>{
					node.pieGraphData = daily_assignment_status.filter(node2=>node2.unit_id===node.id).map(node2=>{
						node2.label = node2.status; 
						node2.count = node2.assignmentCount;
						return node2;
					});
					node.assignment_total = daily_assignment_status.reduce((acc,currVal)=>acc+currVal.assignmentCount,0);
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
			//call api and update field
			this.axios.post('/api/classroom/'+this.$route.params.classroomId+'/update-unit',{
				unit_no: unit_no,
				unit_name: event.target.value
			});
		},
		// dailyAssignmentStatusGraphData(unit){
		// 	let unit_data = daily_assignment_status.find(node=>node.key===unit.id);
		// 	if(unit_data && unit_data.subgroup.length){
		// 		return unit_data.subgroup;
		// 	}
		// 	return [];
		// }
	}
};

</script>
