<template>
  <div>
    <div>
      <h1>My Reports</h1>
      <hr>
    </div>
    <div
      v-if="AuthUser.role_intended==='student' && !classrooms.length"
      class="card mb-2 pl-3"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p class="text-blue weight-600">
              Ask your teachers to share Classroom Join Id with you.
            </p>
            <p style="line-height:1px;">
              You will be able to see overall progress of classroom assignment here.
            </p>
          </div>
        </div>
      </div>
    </div>
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