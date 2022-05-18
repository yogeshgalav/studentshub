<template>
  <div class="row">
    <Head>
      <title> Classrooms</title>
    </Head>
    <div class="col-md-12">
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :width="250"
        :is-full-page="true"
      />
      <div class="row">
        <div class="col-md-12">
          <h1>Classrooms</h1>
          <hr>
        </div>
      </div>
      <div class="mb-2">
        <button
          v-if="['seeker', 'student'].includes(AuthUser.role)"
          type="button"
          class="btn-primary btn-lg mb-1"
          data-toggle="modal"
          data-target="#joinClassroomModal"
        >
          <i class="fas fa-plus" />&nbsp;&nbsp;Join Classroom
        </button>
        <button
          v-else
          type="button"
          class="btn-lg btn-primary"
          @click="createClassroom()"
        >
          <i class="fas fa-plus" />&nbsp;&nbsp;Create Classroom
        </button>
      </div>
      <div
        v-if="['seeker', 'student'].includes(AuthUser.role) && !classroomList.length"
        class="card mb-2 pl-3"
      >
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <p class="text-blue weight-600 mb-0">
                Ask your teachers to share Classroom Join Id with you.
              </p>
              <p class="mb-0">
                Classrooms will help you to visualize your progress and ease your learning process.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div
        v-if="!['seeker', 'student'].includes(AuthUser.role) && !classroomList.length"
        class="card mb-2 pl-3"
      >
        <div class="card-body">
          <div class="row">
            <div class="row">
              <div class="col-md-12">
                <p class="text-blue weight-600 mb-0">
                  Create classrooms for your students.
                </p>
                <p class="mb-0">
                  Classrooms will help you to visualize your student's progress and ease thier learning process.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <modal
          ref="joinClassroomModal"
          name="joinClassroomModal"
          heading="Join Classroom"
          classes="modal-md"
          @submit="joinClassroom"
        >
          <template slot="modalBody">
            <form>
              <div class="model_input">
                <label class="text-gray">Enter Join Id</label>
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
      <div v-if="classroomList.length">
        <div class="row">
          <div
            v-for="(classroom, index) in classroomList"
            :key="index"
            class="col-md-4 mb-2"
          >
            <router-link
              :href="'/classroom/'+classroom.classroom_id"
              class="card rounded-lg pt-3 pb-3 bg-light text-center"
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
                {{ classroom.subject_name }}
              </h3>
              <h4 class="font-weight-normal text-muted">
                {{ classroom.classroom_name }}
              </h4>
            </router-link>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <accordion
            title="Details"
            :aria-expanded="true"
          >
            <vue-table-component
              :columns="classroomColumns"
              :rows="classroomList"
            >
              <template
                slot="table-row"
                slot-scope="props"
              >
                <span v-if="props.column.field==='classroom_name'">
                  <router-link
                    :href="'/classroom/'+props.row.classroom_id"
                    class="text-underline"
                  >{{ props.row['classroom_name'] }}</router-link>
                </span>
              </template>
              <template slot="emptystate">
                No classroom found.
              </template>
            </vue-table-component>
          </accordion>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
#profileImage{
  margin:auto !important;
}
</style>
<script>
import Modal from '../../components/VueNiceModal';
import swal from '../../components/swal';
import VueTableComponent from '../../../../resources/js/components/vue-table-component';
import Accordion from '../../components/accordion.vue';

export default {
	components:{
		Modal,
		VueTableComponent,
		Accordion
	},
	data() {
		return {
			id_error: '',
			showLoader: true,
			canCreateClassroom: false,
			join_classroom_name: '',
			classroomList:[],
			classroomColumns: [
				{
					label: 'Classroom',
					field: 'classroom_name',
				},
				{
					label: 'Teacher',
					field: 'teacher_name',
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
					label: 'Avg. Score',
					field: 'average_score',
				},
				{
					label: 'Resources',
					field: 'total_resources',
				},
				{
					label: 'Messages',
					field: 'total_messages',
				},
			]
		};
	},
	mounted(){
		this.axios.get('/api/classroom-list-details').then((resp)=>{
			this.classroomList=resp.data.success.classrooms;
			this.canCreateClassroom=resp.data.success.canCreateClassroom;
			this.showLoader=false;
		});
	},
	methods:{
		joinClassroom(){
			this.showLoader=true;
			this.axios.post('/api/classroom/join',{
				name:this.join_classroom_name
			}).then((resp)=>{
				this.$refs.joinClassroomModal.closeModal();
				this.showLoader=false;
				swal.successDialog('Classroom joined', 'Successfully!', 'success');
				window.location.href = '/classroom/'+resp.data.success.classroom_id;
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

