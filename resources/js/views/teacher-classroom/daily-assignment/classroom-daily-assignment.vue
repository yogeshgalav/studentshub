<template>
  <div>
    <div class="row">
            <div class="col-md-12">
               <classroom-header />
            </div>
        </div>
    <div class="mt-2">
      <add-button name="Add Assignment" @submit="addAssignment" />
    </div>
    <div class="card mt-5" v-for="(daily,index) in dailyAssignmentData" :key="index+''+daily.id">
      <daily-assignment-accordian :assignment="daily" :unitList="unitList" @deleteAssignment="deleteAssignment(index)" />
    </div>
  </div>
</template>
<style scoped>
.delete_btn {
  padding: 0 22px 0 22px;
  font-size: 18px;
}
</style>
<script>
import Vue from "vue";

import AddButton from "../../../components/AddButton";
import FormMixin from "../../../components/mixins/form-mixin.js";
import ClassroomHeader from '../../../components/ClassroomHeader';
import DailyAssignmentAccordian from './daily-assignment-accordian';

export default {
  mixins: [FormMixin],
  components: {
    AddButton,
    ClassroomHeader,
    DailyAssignmentAccordian
  },
  data() {
    return {
      dailyAssignmentData: [],
      unitList: [],
      marks: 10,
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
        .get("/api/classroom/" + this.$route.params.classroomId + "/daily-questions")
        .then((resp) => {
          this.unitList = resp.data.success.unitList;
          this.dailyAssignmentData = resp.data.success.dailyAssignmentData;
        });
    },
    addAssignment() {
      this.dailyAssignmentData.unshift({
        unit_id: "",
        attempt_date: "",
        daily_questions: [],
      });
    },
    deleteAssignment(assignmentIndex) {
      this.dailyAssignmentData.splice(assignmentIndex,1);
    }
  }
};
</script>
