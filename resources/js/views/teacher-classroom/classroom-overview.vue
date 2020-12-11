<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
    </div>
    <div class="col-md-12">
      <div class="card mt-2">
        <div class="card-header">
          <h4 class="mb-1">
            {{ 'Classroom Overview' }}
          </h4>
        </div>
        <div class="card-body">
          <form>
            <div class="form-group mb-0 row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Course
              </label>
              <div class="col-sm-10">
                <div class="text-black">
                  {{ classroomDetail.course_name }}
                </div>
              </div>
            </div>
            <div class="form-group mb-0 row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Subject
              </label>
              <div class="col-sm-10">
                <div class="text-black">
                  {{ classroomDetail.subject_name }}
                </div>
              </div>
            </div>
            <div class="form-group mb-0 row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Batch
              </label>
              <div class="col-sm-10">
                <div class="text-black">
                  {{ classroomDetail.batch_start_year }} - {{ classroomDetail.batch_end_year }}
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Classroom
                Name </label>
              <div class="col-sm-3">
                <div class="text-black">
                  <input
                    id="duration"
                    v-model="form_data.name"
                    type="text"
                    class="form-control"
                    @blur="updateClassroomDetail"
                  >
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Expected
                Students </label>
              <div class="col-sm-3">
                <div class="text-black">
                  <input
                    id="expected_students"
                    v-model="form_data.expected_students"
                    type="text"
                    class="form-control"
                    @blur="updateClassroomDetail"
                  >
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Classroom
                duration </label>
              <div class="col-sm-3">
                <div class="text-black">
                  <input
                    id="duration"
                    v-model="form_data.duration"
                    type="text"
                    class="form-control"
                    @blur="updateClassroomDetail"
                  >
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div
      v-if="classroomDetail.id"
      class="col-md-4  col-12 mt-3 mb-3"
    >
      <div
        class="join_id_box"
        @click="copyText('joinId')"
      >
        <i class="fa  text-blue  fa-arrow-right mr-3" />  <span
          class="text-blue font-size-14 weight-800 join-id line-height-25-px"
        >
          {{ 'Copy Join Id' }}: {{ classroomDetail.classroom_live_id }}
          <strong class="right_positions hide"><i class="fa fa-copy text-success font-size-15" /> </strong>  
        </span>
      </div>
    </div>
    <div
      v-if="classroomDetail.batch_start_year && classroomDetail.batch_end_year"
      class="col-md-4  col-12 mt-3 mb-3"
    >
      <div
        class="join_id_box"
        @click="copyText('RegisterationLink')"
      >
        <i class="fa  text-blue  fa-arrow-right mr-3" />  <span
          class="text-blue font-size-14 weight-800 join-id line-height-25-px"
        >
          {{ 'Copy Registration Link' }}
          <strong class="right_positions hide"><i class="fa fa-copy text-success font-size-15" /> </strong>
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.join_id_box {
 border:1px solid #eee;
 border-radius: 5px;
 padding: 8px 5px 8px 15px;
 cursor: pointer;
}
.join_id_box:hover {
 background-color: #f3f9e8;
 border-color: #e1ebb3;
}
.right_positions {
  position: absolute;
  right: 40px;
}
.join_id_box:hover strong{
	display: block;
	margin-top: -20px;
}
.hide {
  display: none;
}
</style>
<script>

import ClassroomHeader from '../../components/ClassroomHeader';

export default {
	components: {
		ClassroomHeader,
	},
	data() {
		return {
			form_data:{
				name: '',
				expected_students: 0,
				duration: 0
			},
		};
	},
	computed:{
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		},
	},
	watch:{
		classroomDetail(val){
			if(val.id){
				this.form_data={
					name: val.name,
					expected_students: val.expected_students,
					duration: val.classroom_duration
			  };
			}
		}
	},
	methods:{
		updateClassroomDetail(){
			this.axios.post('/api/classroom/'+this.classroomDetail.id+'/update-detail',this.form_data);
		}, 
		copyText(copyType){
			const el = document.createElement('textarea');
			if(copyType==='RegisterationLink'){
				el.value = this.baseUrl+'/get-started?joinId='+this.classroomDetail.classroom_live_id;
			}else{
				el.value = this.classroomDetail.classroom_live_id;
			}
			document.body.appendChild(el);
			el.select();
               
			document.execCommand('copy');
			document.body.removeChild(el);
		},     
	},
};

</script>
