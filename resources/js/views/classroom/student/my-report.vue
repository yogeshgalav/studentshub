<template>
  <div>
    <div>
      <h1>My Report</h1>
      <hr>
    </div>
    <accordion
      :title="'Overall Classroom Report'"
      :aria-expanded="true"
    />
    <div
      v-for="(classroom, index) in classrooms"
      :key="index"
      class="mt-2"
    >
      <accordion
        :title="classroom.name"
        :aria-expanded="true"
      >
        <student-report :classroom-id="classroom.id" />
      </accordion>
    </div>
  </div>
</template>
<script>
import accordion from '../../../components/accordion.vue';
import StudentReport from '../student-report.vue';

export default {
	components: { accordion,StudentReport },
	props:['classrooms'],
    
};
</script>