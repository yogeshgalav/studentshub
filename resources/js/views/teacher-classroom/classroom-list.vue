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
                Please fill out education details
              </a>{{ ' to join classrooms from your institute.' }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div>
      <add-button
        v-if="AuthTeacher"
        button-class="btn-primary mb-1"
        type="button"
        size="lg"
        name="Create Classroom"
        bg-class="bg-primary-accent"
        @submit="createClassroom()"
      />
      <add-button
        v-if="AuthStudent"
        button-class="btn-success mb-1"
        type="button"
        size="lg"
        name="Join Classroom"
        data-toggle="modal"
        data-target="#joinClassroomModal"
        @submit="joinClassroomModal"
      />
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
  </div>
</template>
<style scoped>
.clss_username h5 {
color:#333;
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
	data(){
		return {
			id_error:'',
			showLoader:false,
			join_classroom_name:'',
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
		createClassroom(){
			window.location.href='/create-classroom';
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
        background-color: #0f6bff;
        background: linear-gradient(90deg, #020024 0%, #090979 0%, #0475c0 0%, #00d4ff 79%);
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
