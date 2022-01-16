<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header 
        title="Doubts"     
      />
    </div>
    <div class="col-md-12">
      <doubt-list 
        :classroom-id="$route.params[0]" 
        :subject-id="$store.state.classroom.classroomDetail.subject_id" 
      />
    </div>
  </div>
</template>
<script>
import DoubtList from '../doubt/index.vue';
import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: { 
		DoubtList,
  	ClassroomHeader,
	},
    
};
</script>