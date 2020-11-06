<template>
  <div>
    <h2 class="font-size-40 text-black weight-800 mb-2 line-height-25-px">
      {{ institute_detail.name }}
    </h2>
    <NavTabs
      :tabs="tabs"
      :initial-tab="initialTab"
    >
      <template slot="tab-heading-members">
        {{ 'Members' }}
      </template>
      <template slot="tab-panel-members">
        <div class="row">
          <div class="col-md-12">
            <vue-table-component
              :columns="columns"
              :rows="users"
            />
          </div>   
      
          <div class="col-md-12">
            <button 
              class="btn btn-success" 
              type="button"
              @click="$modal.show('add_member')"
            >
              Add Member
            </button>
          </div> 
        </div>
      </template>
      
      <template slot="tab-heading-classrooms">
        {{ 'Classrooms' }}
      </template>
      <template slot="tab-panel-classrooms" />
      
      <template slot="tab-heading-students">
        {{ 'Students' }}
      </template>
      <template slot="tab-panel-students" />
    </NavTabs>
    
    <div class="col-md-12">
      <button 
        class="btn btn-success" 
        type="button"
        @click="$modal.show('add_member')"
      >
        Add Member
      </button>
      <modal
        name="add_member"
        class="doubt_model"
      >
        <form @submit.prevent="addNewMember">
          <div class="model_box_inner card p-0">
            <div class="card-header">
              <div class="edit_profile_head">
                <h4>Add Member</h4>
              </div> 
            </div>
            <div class="row card-body">
              <div class="col-md-12">
                <div class="model_input">
                  <label class="text-gray">Enter Full Name</label>
                  <input
                    v-model="new_member.full_name"
                    v-validate="'required'"
                    name="full_name"
                    type="text"
                    class="form-control"
                  >
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label class="text-gray">Enter Email</label>
                  <input
                    v-model="new_member.email"
                    v-validate="'required'"
                    name="email"
                    type="text"
                    class="form-control"
                  >
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label class="text-gray">Password</label>
                  <input
                    v-model="new_member.password"
                    v-validate="'required'"
                    name="password"
                    type="text"
                    class="form-control"
                  >
                  <a
                    href="#"
                    @click="generatePassword"
                  >Generate Password</a>
                </div>
              </div>
              <div class="col-md-12">
                <div class="model_input">
                  <label class="text-gray">Role</label>
                  <select
                    v-model="new_member.role"
                    v-validate="'required'"
                    name="role"
                    class="form-control"
                  >
                    <option value="">
                      Select Role
                    </option>
                    <option value="teacher">
                      Teacher
                    </option>
                    <option value="admin">
                      Admin
                    </option>
                    <option value="staff">
                      Staff
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <button 
                  class="btn btn-primary" 
                  type="submit"
                >
                  Add
                </button>
              </div>
            </div>
          </div>
        </form>
      </modal>
    </div>
  </div>
</template>
<script>
import VModal from 'vue-js-modal';
import swal from '../../components/swal';
import VueTableComponent from '../../components/vue-table-component';
import FormMixin from '../../components/mixins/form-mixin';
import NavTabs from '../../components/NavTabs';

export default {
	components:{
		VModal,
		NavTabs,
		VueTableComponent
	},
	mixins:[FormMixin],
	props:['instituteId'],
	data(){
		return {
			initialTab:'members',
			tabs:['members','classrooms','students'],
			users:[],
			institute_detail:{},
			new_member:{
				user_id:0,
				full_name:'',
				email:'',
				password:'',
				role:'',
			},
			columns: [
				{
					label: 'Member Name',
					field: 'full_name',
				},
				{
					label: 'Email',
					field: 'email',
				},
				{
					label: 'Role',
					field: 'role',
				},
			],
		};
	},
	mounted(){
		this.axios.get('/api/institute/'+this.instituteId+'/get-institute-details').then((resp)=>{
			this.users=resp.data.success.users;
			this.institute_detail=resp.data.success.institute_detail;
		});
	},
	methods:{
		addNewMember(){
			this.$validator.validate().then(valid => {
				if (valid) {
					this.$modal.hide('add_member');
					this.axios.post('/api/institute/'+this.instituteId+'/update-user',this.new_member).then((resp)=>{
						const new_member = this.new_member;
						this.users.push(new_member);
					});
				}
			});
		},
		generatePassword(){
			let r = Math.random().toString(36).slice(2);
			this.new_member.password = r;
		}
	}
};
</script>