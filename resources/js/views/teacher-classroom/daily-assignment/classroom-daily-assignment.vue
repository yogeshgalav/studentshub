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
    <div
      v-if="!unitList.length"
      class="card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p>
              {{ 'No unit created.This page will populate once unit setup is done. ' }}
              <router-link :to="'/classroom/'+$route.params.classroomId+'/setup'">
                Click here to to create unit
              </router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
    <div
      v-else
      class="mt-2"
    >
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
        @loader="changeLoader"
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
		changeLoader(status){
			this.showLoader=status;
		},
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
