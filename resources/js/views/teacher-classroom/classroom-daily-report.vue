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
        <classroom-header />
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <select
          v-model="current_unit_id"
          class="form-control minimal"
        >
          <option
            v-for="(unit,index) in unitList"
            :key="index"
            :value="unit.id"
          >
            {{ 'Unit '+unit.unit_no+': '+unit.unit_name }}
          </option>
        </select>
      </div>
    </div>
    <div
      v-for="(assignment,index) in currentUnit.daily_assignments"
      :key="index"
      class="card mt-5"
    >
      <div>
        <div class="row">
          <div class="col-md-12">
            <accordion
              :title="assignment.attempt_date"
              :aria-expanded="true"
              :tab="'daily_assignment_'+assignment.id"
            >
              <completed-daily-assignment :assignment="assignment" />
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
import CompletedDailyAssignment from './completed-daily-assignment';

export default {
	components: {
		Accordion,
		ClassroomHeader,
		CompletedDailyAssignment,
	},
	data() {
		return {
			showLoader:true,
			current_unit_id: '',
			unitList: [],
			dailyAssignmentList: [],
			marks: 10,
		};
	},
	computed: {
		currentUnit() {
			if(this.unitList.length && this.current_unit_id){
				return this.unitList.find(node=>node.id===this.current_unit_id);
			}
			return {daily_assignments:[]};
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
					this.current_unit_id = this.unitList.length ? this.unitList[0].id : 0;
					// this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
					this.showLoader=false;
				});
		},
	},
};
</script>