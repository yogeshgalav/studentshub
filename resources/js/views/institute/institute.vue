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
              :columns="memberColumns"
              :rows="memberRows"
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
      <template slot="tab-panel-classrooms">
        <vue-table-component
          :columns="classroomColumns"
          :rows="classroomRows"
        >
          <template
            slot="table-row"
            slot-scope="props"
          >
            <span v-if="props.column.field==='classroom_name'">
              <a
                :href="'/classroom/'+props.row.id"
                class="text-underline"
              >{{ props.row['classroom_name'] }}</a>
            </span>
            <span v-else>
              <span>{{ props.row[props.column.field] }}</span>
            </span>
          </template>
        </vue-table-component>
      </template>
      
      <template slot="tab-heading-students">
        {{ 'Students' }}
      </template>
      <template slot="tab-panel-students">
        <vue-table-component
          :columns="studentColumns"
          :rows="studentRows"
        />
      </template>
    </NavTabs>
    
    <div class="col-md-12">
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
			memberRows:[],
			studentRows:[],
			classroomRows:[],
			institute_detail:{},
			new_member:{
				user_id:0,
				full_name:'',
				email:'',
				password:'',
				role:'',
			},
			memberColumns: [
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
			studentColumns: [
				{
					label: 'Student Name',
					field: 'full_name',
				},
				{
					label: 'Institute id',
					field: 'institute_id',
				},
				{
					label: 'Email',
					field: 'email',
				},
				{
					label: 'Course',
					field: 'course_alias',
				},
				{
					label: 'Average score',
					field: 'avg_score',
				},
			],
			classroomColumns: [
				{
					label: 'Name',
					field: 'classroom_name',
				},
				{
					label: 'Teacher',
					field: 'teacher_name',
				},
				{
					label: 'Total students',
					field: 'total_students',
				},
				{
					label: 'Total assignments',
					field: 'total_assignments',
				},
				{
					label: 'Average score',
					field: 'avg_score',
				},
			],
		};
	},
	mounted(){
		this.axios.get('/api/institute/'+this.instituteId+'/get-institute-details').then((resp)=>{
			this.memberRows=resp.data.success.members;
			this.studentRows=resp.data.success.students.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
				}
				return node;
			});
			this.classroomRows=resp.data.success.classrooms.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
				}
				return node;
			});
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
						this.memberRows.push(new_member);
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