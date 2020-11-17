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
    <div class="mt-2">
      <add-button
        name="Add Assignment"
        size="lg"
        @submit="addAssignment"
      />
    </div>
    <div
      v-for="(daily,index) in dailyAssignmentData"
      :key="index+''+daily.id"
      class="card mt-5"
    >
      <daily-assignment-accordian
        :assignment="daily"
        :unit-list="unitList"
        @deleteAssignment="deleteAssignment(index)"
      />
    </div>
  </div>
</template>
<style scoped>
.delete_btn {
  padding: 0 22px 0 22px;
  font-size: 18px;
}
.border-bottom-1px  {
  border-bottom:1px dashed #ccc !important;
}
</style>
<script>
import Vue from 'vue';

import AddButton from '../../../components/AddButton';
import FormMixin from '../../../components/mixins/form-mixin.js';
import ClassroomHeader from '../../../components/ClassroomHeader';
import DailyAssignmentAccordian from './daily-assignment-accordian';

export default {
	components: {
		AddButton,
		ClassroomHeader,
		DailyAssignmentAccordian
	},
	mixins: [FormMixin],
	data() {
		return {
			showLoader:true,

			dailyAssignmentData: [],
			unitList: [],
		};
	},
	computed: {
		latestDate() {
			return new Date();
		},
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
				.get('/api/classroom/' + this.$route.params.classroomId + '/daily-questions')
				.then((resp) => {
					this.unitList = resp.data.success.unitList;
					this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
					this.showLoader=false;
				});
		},
		addAssignment() {
			this.dailyAssignmentData.unshift({
				unit_id: '',
				attempt_date: '',
				daily_questions: [],
			});
		},
		deleteAssignment(assignmentIndex) {
			this.dailyAssignmentData.splice(assignmentIndex,1);
		}
	}
};
</script>
