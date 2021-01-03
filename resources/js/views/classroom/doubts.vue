<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
    </div>
    <div class="col-md-12">
      <doubt-list 
        :classroom-id="$route.params.classroomId" 
        :subject-id="$store.state.classroom.classroomDetail.subject_id" 
      />
    </div>
  </div>
</template>
<script>
import DoubtList from '../../views/doubt/doubt-list.vue';
import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: { 
		DoubtList,
  	ClassroomHeader,
	},
    
};
</script>