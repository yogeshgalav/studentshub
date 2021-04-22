<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
    </div>
    <div class="col-md-12">
      <div class="card mt-2">
        <div class="card-header bg-white">
          <h4 class="mb-1 mt-1">
            {{ 'Classroom Overview' }}
          </h4>
        </div>
        <div class="card-body">
          <div class="col-md-6 col-12">
            <form>
              <div class="form-group">
                <label class="text-black font-size-14">Course
                </label>
                <input
                  id="course"
                  type="text"
                  class="form-control"
                  disabled
                  :value="classroomDetail.course_name"
                >
              </div>
              <div class="form-group">
                <label class="text-black font-size-14">Subject
                </label>
                <input
                  id="subject"
                  type="text"
                  class="form-control"
                  disabled
                  :value="classroomDetail.subject_name"
                >
              </div>
              <div class="form-group">
                <label class="text-black font-size-14">Batch:
                </label>
                {{ classroomDetail.batch_start_year }} - {{ classroomDetail.batch_end_year }}
              </div>
              <div class="form-group">
                <label class="text-black font-size-14">Classroom
                  Name
                </label>
                <input
                  id="duration"
                  v-model="form_data.name"
                  type="text"
                  class="form-control"
                  @blur="updateClassroomDetail"
                >
              </div>
              <div class="form-group">
                <label class="text-black font-size-14">
                  Meeting Link
                </label>
                <input
                  id="duration"
                  v-model="form_data.meet_link"
                  type="text"
                  class="form-control"
                  placeholder="Paste Google meet or zoom link here"
                  @blur="updateClassroomDetail"
                >
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="row mt-5 mb-2">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header bg-white">
              <h4 class="mb-1 mt-1">
                Join Id
              </h4>
            </div>
        
            <div class="card-body row">
              <div class="col-md-12">
                Share Registration Link or Join Id with your students to directly join this classroom.
              </div>
              <div
                v-if="showCopied"
                class="col-md-12 copied"
              >
                <div class="alert alert-success">
                  <strong><i class="fas fa-check" /> &nbsp;Copied to clipboard!</strong>
                </div>
              </div>
              <div
                v-if="classroomDetail.id"
                class="col-md-4  col-12 mt-2 mb-3"
              >
                <div
                  class="join_id_box"
                  @click="copyText('joinId')"
                >
                  <i class="fa  text-blue  fa-arrow-right mr-3" />  <span
                    class="text-blue font-size-14 weight-800 join-id line-height-25-px"
                  >
                    {{ 'Copy Join Id' }}: {{ classroomDetail.classroom_join_id }}
                    <strong class="right_positions hide"><i class="fa fa-copy text-success font-size-15" /> </strong>  
                  </span>
                </div>
              </div>
              <div
                v-if="classroomDetail.batch_id"
                class="col-md-4  col-12 mt-2 mb-3"
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
          </div>
        </div> 
      </div>

      <div
        v-if="classroomDetail.total_students===0"
        class="card mt-5"
      >
        <div class="card-header bg-white">
          <h4 class="mb-1 mt-1">
            {{ 'Delete Classroom' }}
          </h4>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              {{ 'Click the button below to delete this classroom. You can delete this classroom until any student has joined. This will permanently delete the classroom.' }}
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 mt-2 delete_btn">
              <button
                type="button"
                class="btn btn-white"
                @click="deleteClassroom"
              >
                {{ 'Delete' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.delete_btn .btn {
  padding: 10px 35px;
}
.card {
  box-shadow: 0px 2px 50px rgba(0,0,0,0.15) !important;
}

.copied{
  margin-top: -20px;
  animation-name: alert;
  animation-duration: 0.3s;
  animation-iteration-count: 1;
  animation-fill-mode: forwards;
}
@keyframes alert {
  from {margin-top: -20px;}
  to {margin-top: 0px;}
} 
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
				meet_link: '',
			},

			showCopied: false
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
					meet_link: val.meet_link,
			  };
			}
		}
	},
	methods:{
		updateClassroomDetail(){
			this.axios.post('/api/classroom/'+this.classroomDetail.id+'/update-detail',this.form_data);
		}, 
		deleteClassroom(){
			this.axios.delete('/api/classroom/'+this.classroomDetail.id+'/delete').then(()=>{
				window.location.href = this.baseUrl + '/classrooms';
			});
		}, 
		copyText(copyType){
			const el = document.createElement('textarea');
			if(copyType==='RegisterationLink'){
				el.value = this.baseUrl+'/get-started?joinId='+this.classroomDetail.classroom_join_id;
			}else{
				el.value = this.classroomDetail.classroom_join_id;
			}
			document.body.appendChild(el);
			el.select();
               
			document.execCommand('copy');
			document.body.removeChild(el);
			this.showCopied = true;
			setTimeout(() => this.showCopied = false , 3000);
		},     
	},
};

</script>
