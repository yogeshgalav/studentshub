<template>
  <div class="col-md-12">
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div>
      <a
        v-if="AuthTeacher"
        href="/create-classroom"
        class="btn btn-primary btn-lg mb-1" 
        type="button"
      >Create Classroom</a>

      <button 
        class="btn btn-success btn-lg mb-1" 
        type="button"
        @click="$modal.show('join_classroom_modal')"
      >
        Join Classroom
      </button>
      <modal
        name="join_classroom_modal"
        class="doubt_model"
      >
        <form @submit.prevent="joinClassroom">
          <div class="model_box_inner card p-0">
            <div class="card-header">
              <div class="edit_profile_head">
                <h4>Join Classroom</h4>
              </div> 
            </div>
            <div class="row card-body">
              <div class="col-md-12">
                <div class="model_input">
                  <label class="text-gray">Enter Classroom Name</label>
                  <input
                    v-model="join_classroom_name"
                    type="text"
                    class="form-control"
                  >
                  <span class="error">{{ id_error }}</span>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_btn">
                  <button
                    type="submit"
                    class="btn btn-primary"
                  >
                    Request
                  </button>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="$modal.hide('join_classroom_modal')"
                  >
                    Cancel
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </modal>
    </div>
    <div v-if="myClassrooms.length">
      <div class="row">
        <div class="col-md-12 mt-3">
          <h3>My Classrooms </h3>
          <hr>
        </div>
      </div>
      <div class="row">
        <div
          v-for="(classroom,index) in myClassrooms"
          :key="index"
          class="col-md-4"
        >
          <div class="clas_roo_main_box">
            <div class="cl_box_top">
              <p>{{ classroom.classroom_live_id }}</p>
            </div>
            <div class="classroom_box">
              <div class="clss_username">
                <p>
                  <img
                    src="/images/Group.svg"
                    alt=""
                  >
                </p>
                <h5>{{ classroom.teacher_name }}</h5>
              </div>
              <div class="classroom_content">
                <a :href="'/classroom/'+classroom.id">{{ classroom.subject_name }}</a>
                <p>{{ classroom.name }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="classroomList.length">
      <div class="col-md-12 mt-3">
        <h3>Joined Classrooms </h3>
        <hr>
      </div>
      <div class="row">
        <div
          v-for="(classroom,index) in classroomList"
          :key="index"
          class="col-md-4"
        >
          <div class="cl_box_top">
            <p>{{ classroom.classroom_live_id }}</p>
          </div>
          <div class="classroom_box">
            <div class="clss_username">
              <p>
                <img
                  src="/images/Group.svg"
                  alt=""
                >
              </p>
              <h5>{{ classroom.teacher_name }}</h5>
            </div>
            <div class="classroom_content">
              <a :href="'/classroom/'+classroom.id">{{ classroom.subject_name }}</a>
              <p>{{ classroom.name }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VModal from 'vue-js-modal';
import swal from '../../components/swal';

export default {
	components:{
		VModal
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
				this.$modal.hide('join_classroom_modal');
				this.showLoader=false;
				swal.successDialog('Request sent', 'Successfully!', 'success');
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
