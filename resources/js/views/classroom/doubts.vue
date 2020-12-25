<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
    </div>
    <doubt-list 
      :classroom-id="$route.params.classroomId" 
      :subject-id="$store.state.classroom.classroomDetail.subject_id" 
    />
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