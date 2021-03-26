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
          <div class="clas_roo_main_box">
            <div class="cl_box_top">
              <p>{{ classroom.classroom_join_id }}</p>
            </div>
            <a
              :href="'/classroom/' + classroom.id"
              class="classroom_box"
            >
              <div class="clss_username">
                <p>
                  <img
                    src="/images/Group.svg"
                    alt=""
                  >
                </p>
                <h5 class="mt-3">
                  {{ classroom.teacher_name }}
                </h5>
              </div>
              <div class="classroom_content">
                <p>
                  {{ classroom.subject_name }} <br>
                  <span>{{ classroom.name }}</span>
                </p>
              </div>
            </a>
          </div>
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
          <div class="clas_roo_main_box">
            <div class="cl_box_top">
              <p>{{ classroom.classroom_join_id }}</p>
            </div>
            <a
              :href="'/classroom/' + classroom.id"
              class="classroom_box"
            >
              <div class="clss_username">
                <p>
                  <!-- <img
                    src="/images/Group.svg"
                    alt=""
                  > -->
                  <profile-image
                    :user-name="classroom.teacher_name"
                    :size="large"
                  />
                </p>
                <h5 class="mt-3">
                  {{ classroom.teacher_name }}
                </h5>
              </div>
              <div class="classroom_content">
                <p>
                  {{ classroom.subject_name }} <br>
                  <span>{{ classroom.name }}</span>
                </p>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <hr>
    <button
      v-if="AuthTeacher"
      type="button"
      class="btn-lg btn-primary"
      @submit="createClassroom()"
    >
      <i class="fas fa-plus" />&nbsp;&nbsp;Create Classroom
    </button>
    <button
      v-if="AuthStudent"
      type="button"
      class="btn-primary btn-lg mb-1"
      data-toggle="modal"
      data-target="#joinClassroomModal"
      @submit="joinClassroomModal"
    >
      <i class="fas fa-plus" />&nbsp;&nbsp;Join Classroom
    </button>
  </div>
</template>
<style scoped>
.clss_username h5 {
    color: #333;
}

.classroom_content p {
    font-size: 20px;
    font-weight: bold;
}
.clas_roo_main_box a:hover {
    text-decoration: none;
}
.classroom_content p:hover {
    text-decoration: none;
}
.classroom_content p span {
    font-size: 16px;
    font-weight: normal;
}
.uc{
  text-transform:uppercase;
}
</style>
<script>
import Modal from '../../components/VueNiceModal';
import swal from '../../components/swal';
import AddButton from '../../components/AddButton';

export default {
	components:{
		Modal,
		AddButton
	},
	props: ['myClassrooms', 'classroomList'],
	data() {
		return {
			id_error: '',
			showLoader: false,
			join_classroom_name: ''
		};
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

<style>
.clas_roo_main_box {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.16);
    margin-bottom: 30px;
    border-radius: 4px;
}

.cl_box_top p {
    color: white;
    font-size: 24px;
    font-weight: 700;
}

.cl_box_top {
    padding: 50px;
    text-align: center;
    background: #bdc3c7;
    background: -webkit-linear-gradient(
        to right,
        #2c3e50,
        #bdc3c7
    );
    background: linear-gradient(
        #2c3e50,
        #bdc3c7
    ); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.classroom_box p {
    color: #868686;
}

.classroom_box a {
    font-size: 20px;
    color: black;
    font-weight: 700;
}

.classroom_box {
    position: relative;
}

.clss_username {
    display: flex;
    align-items: center;
    position: absolute;
    top: -52px;
    width: 100%;
    padding: 0px 15px;
}

.clss_username img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #f6f6f6;
    border: solid 1px #ccc;
}

.classroom_content {
    padding: 44px 0 0;
}

.clss_username h5 {
    /* padding: 25px 12px; */
    margin: 20px 10px 0;
}

.classroom_content {
    padding: 60px 18px 10px;
}
</style>
