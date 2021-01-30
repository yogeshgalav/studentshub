<template>
  <div>
    <h2 class="font-size-40 text-black weight-800 mb-2 line-height-25-px">
      {{ institute_detail.name }}
    </h2>
    <nav-tabs
      :tabs="tabs"
      :initial-tab="initialTab"
    >
      <template slot="tab-heading-members">
        {{ 'Members' }}
      </template>
      <template slot="tab-panel-members">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">
                <h2 class="weight-800 text-black font-size-18 mb-0">
                  {{ 'Members' }}
                </h2>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <vue-table-component
                      :columns="memberColumns"
                      :rows="memberRows"
                      :footer="memberFooter"
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
              </div>
            </div>
          </div>
        </div>
      </template>

      <template slot="tab-heading-teachers">
        {{ 'Teachers' }}
      </template>
      <template slot="tab-panel-teachers">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">
                <h2 class="weight-800 text-black font-size-18 mb-0">
                  {{ 'Teachers' }}
                </h2>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <vue-table-component
                      :columns="teacherColumns"
                      :rows="teacherRows"
                      :footer="teacherFooter"
                    />
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      <template slot="tab-heading-classrooms">
        {{ 'Classrooms' }}
      </template>
      <template slot="tab-panel-classrooms">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">
                <h2 class="weight-800 text-black font-size-18 mb-0">
                  {{ 'Classrooms' }}
                </h2>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <vue-table-component
                      :columns="classroomColumns"
                      :rows="classroomRows"
                      :footer="classroomFooter"
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
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      
      <template slot="tab-heading-students">
        {{ 'Students' }}
      </template>
      <template slot="tab-panel-students">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">
                <h2 class="weight-800 text-black font-size-18 mb-0">
                  {{ 'Students' }}
                </h2>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <vue-table-component
                      :columns="studentColumns"
                      :rows="studentRows"
                      :footer="studentFooter"
                    />
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
      
      <template slot="tab-heading-batches">
        {{ 'Batches' }}
      </template>
      <template slot="tab-panel-batches">
        <div class="row">
          <div class="col-md-12">
            <div class="card mt-5">
              <div class="card-header">
                <h2 class="weight-800 text-black font-size-18 mb-0">
                  {{ 'Batches' }}
                </h2>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <vue-table-component
                      :columns="batchColumns"
                      :rows="batchRows"
                      :footer="batchFooter"
                    >
                      <template
                        slot="table-row"
                        slot-scope="props"
                      >
                        <span v-if="props.column.field==='session'">
                          {{ props.row.start_year }}-{{ props.row.end_year }}
                        </span>
                        <span v-else>
                          <span>{{ props.row[props.column.field] }}</span>
                        </span>
                      </template>
                    </vue-table-component>
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </template>
    </nav-tabs>
    
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
import NavTabs from '../../components/NavTabs.vue';

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
			tabs:['members','teachers','classrooms','students','batches'],
			memberRows:[],
			memberFooter:{},
			teacherRows:[],
			teacherFooter:{},
			studentRows:[],
			studentFooter:{},
			classroomRows:[],
			classroomFooter:{},
			batchRows:[],
			batchFooter:{},
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
			teacherColumns: [
				{
					label: 'Teacher Name',
					field: 'full_name',
				},
				{
					label: 'Email',
					field: 'email',
				},
				{
					label: 'Total Classroom',
					field: 'total_classrooms',
				},
				{
					label: 'Average Score',
					field: 'avg_score',
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
			batchColumns: [
				{
					label: 'session',
					field: 'session',
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
			this.memberFooter={
				'full_name':this.memberRows.length +' Members'
			};
			let total_avg1 = 0;
			let count1 = 0;
			this.studentRows=resp.data.success.students.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
					total_avg1 = total_avg1 + node.avg_score;
					count1 = count1 + 1;
				}
				return node;
			});
			this.studentFooter={
				'full_name':this.studentRows.length +' Students',
				'avg_score':parseFloat(total_avg1/count1).toFixed(2)
			};

			let total_avg2 = 0;
			let count2 = 0;
			this.classroomRows=resp.data.success.classrooms.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
					total_avg2 = total_avg2 + node.avg_score;
					count2 = count2 + 1;
				}
				return node;
			});
			this.classroomFooter={
				'classroom_name':this.classroomRows.length +' Classrooms',
				'avg_score':parseFloat(total_avg2/count2).toFixed(2)
			};

			let total_avg3 = 0;
			let count3 = 0;
			this.batchRows=resp.data.success.batches.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
					total_avg3 = total_avg3 + node.avg_score;
					count3 = count3 + 1;
				}
				return node;
			});
			this.batchFooter={
				'batch_name':this.batchRows.length +' Batches',
				'avg_score':parseFloat(total_avg3/count3).toFixed(2)
			};
      
			let total_avg4 = 0;
			let count4 = 0;
			this.teacherRows=resp.data.success.teachers.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
					total_avg4 = total_avg4 + node.avg_score;
					count4 = count4 + 1;
				}
				return node;
			});
			this.teacherFooter={
				'full_name':this.teacherRows.length +' Teachers',
				'avg_score':parseFloat(total_avg4/count4).toFixed(2)
			};
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