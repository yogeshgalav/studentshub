<template>
  <div class="col-md-12">
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div
      v-if="!AuthStudent && !AuthTeacher"
      class="card"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p>
              <a :href="'/education-details'">
                Please fill out education details </a>{{ " to join classrooms from your institute." }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div>
      <modal
        ref="joinClassroomModal"
        name="joinClassroomModal"
        heading="Join Classroom"
        @submit="joinClassroom"
      >
        <template slot="modalBody">
          <form>
            <div class="model_input">
              <label class="text-gray">Enter Classroom Name</label>
              <input
                v-model="join_classroom_name"
                type="text"
                class="form-control uc"
              >
              <span class="error">{{ id_error }}</span>
            </div>
          </form>
        </template>
      </modal>
    </div>
    <div v-if="myClassrooms.length">
      <div class="row">
        <div class="col-md-12 mt-3">
          <h3>My Classrooms</h3>
          <hr>
        </div>
      </div>
      <div class="row">
        <div
          v-for="(classroom, index) in myClassrooms"
          :key="index"
          class="col-md-4"
        >
          <a
            :href="'/classroom/'+classroom.id"
            class="card rounded-lg pt-3 pb-3 mb-2"
            style="text-align: -webkit-center;"
          >
            <div style="text-align: -webkit-center;">
              <profile-image
                :user-name="classroom.teacher_name"
                size="large"
              />
            </div>

            <h4 class="mt-2 font-weight-normal text-muted">
              {{ classroom.teacher_name }}
            </h4>
            <h3 class="font-weight-bold text-info font-weight-bold">
              {{ classroom.name }}
            </h3>
            <h4 class="font-weight-normal text-muted">
              {{ classroom.subject_name }}
            </h4>
          </a>
        </div>
      </div>
    </div>
    <div v-if="classroomList.length">
      <div class="col-md-12 mt-3">
        <h3>Joined Classrooms</h3>
        <hr>
      </div>
      <div class="row">
        <div
          v-for="(classroom, index) in classroomList"
          :key="index"
          class="col-md-4"
        >
          <a
            :href="'/classroom/'+classroom.id"
            class="card rounded-lg pt-3 pb-3 bg-light"
            style="text-align: -webkit-center;"
          >
            <div style="text-align: -webkit-center;">
              <profile-image
                :user-name="classroom.teacher_name"
                size="large"
              />
            </div>

            <h4 class="mt-2 font-weight-normal text-muted">
              {{ classroom.teacher_name }}
            </h4>
            <h3 class="font-weight-bold text-info font-weight-bold">
              {{ classroom.name }}
            </h3>
            <h4 class="font-weight-normal text-muted">
              {{ classroom.subject_name }}
            </h4>
          </a>
        </div>
      </div>
    </div>
    <hr>
    <button
      v-if="AuthTeacher"
      type="button"
      class="btn-lg btn-primary"
      @click="createClassroom()"
    >
      <i class="fas fa-plus" />&nbsp;&nbsp;Create Classroom
    </button>
    <button
      v-if="AuthStudent"
      type="button"
      class="btn-primary btn-lg mb-1"
      data-toggle="modal"
      data-target="#joinClassroomModal"
      @click="joinClassroomModal"
    >
      <i class="fas fa-plus" />&nbsp;&nbsp;Join Classroom
    </button>

    <div class="card mt-3 mb-3">
      <div class="card-body">
            <div class="card-header">
                Details
            </div>
            <vue-table-component
                :columns="classroomColumns"
                :rows="classroomRows"
            />
      </div>
    </div>
  </div>

</template>

<script>
import Modal from '../../components/VueNiceModal';
import swal from '../../components/swal';
import AddButton from '../../components/AddButton';
import VueTableComponent from '../../../../resources/js/components/vue-table-component'

export default {
	components:{
		Modal,
		AddButton,
        VueTableComponent
	},
	props: ['myClassrooms', 'classroomList'],
	data() {
		return {
			id_error: '',
			showLoader: false,
			join_classroom_name: '',
            classroomRows:[],
            classroomColumns: [
				{
					label: 'Classroom',
					field: 'classroom_name',
				},
				{
					label: 'Teacher',
					field: 'teacher',
				},
				{
					label: 'Subject',
					field: 'subject_name',
				},
                {
					label: 'Students',
					field: 'total_students',
				},
				{
					label: 'Join Id',
					field: 'join_id',
				},
                {
					label: 'Daily Assignments',
					field: 'total_daily_assignments',
				},
				{
					label: 'Doubts',
					field: 'total_doubts',
				},
                {
					label: 'Resources',
					field: 'total_resources',
				},
                {
					label: 'Messages',
					field: 'total_messages',
				},
                {
					label: 'Avg. Score',
					field: 'average_score',
				}
			]
		};
	},
    mounted(){
        this.axios.get('/api/classroom-list-details').then((resp)=>{
            this.classroomRows=resp.data.success.classrooms
        })
    },
	methods:{
		joinClassroom(){
			this.showLoader=true;
			this.axios.post('/api/classroom/join',{
				name:this.join_classroom_name
			}).then(()=>{
				this.$refs.joinClassroomModal.closeModal();
				this.showLoader=false;
				swal.successDialog('Classroom joined', 'Successfully!', 'success');
				location.reload();
			}).catch((err)=>{
				if(err.response.status===422){
					let error_data = err.response.data.error;
					if(error_data.field==='classroom_id'){
						this.id_error = error_data.message;
					};
				}
				this.showLoader=false;
			});
		},
		createClassroom() {
			window.location.href = '/create-classroom';
		}
	}
};
</script>

