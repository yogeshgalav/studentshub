<template>
  <section>
    <div>
      <div class="row">
        <div class="col-md-12">
          <h1>Manage Job</h1>
        </div>
      </div>
      <hr>
      <div class="mb-2">
        <button
          type="edit"
          class="btn-lg btn-primary"
          data-toggle="modal"
          data-target="#addEditJobModal"
        >
          <i class="fas fa-plus" />&nbsp;&nbsp;
          Add Job
        </button>
      </div>
      <div class="card mb-2 pl-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <vue-table-component
                :columns="jobColumns"
                :rows="jobList"
              >
                <template
                  slot="table-row"
                  slot-scope="props"
                >
                  <span v-if="props.column.field==='menu'">
                    <button
                      class="btn btn-success btn-sm rounded-0"
                      type="button"
                      data-placement="top"
                      title="Edit"
                      data-toggle="modal"
                      data-target="#addEditJobModal"
                      @click="editJob(props.row)"
                    >
                      <i class="fa fa-edit" />
                    </button>
                    <button
                      class="btn btn-danger btn-sm rounded-0"
                      type="button"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Delete"
                      @click="deleteJob(props.row)"
                    >
                      <i class="fa fa-trash" />
                    </button>
                  </span>
                </template>
                <template slot="emptystate">
                  No user found.
                </template>
              </vue-table-component> 
              <!-- Responsive table -->
            </div>
          </div>
        </div>
      </div>
    </div>
        
    <modal
      ref="addEditJobModal"
      name="addEditJobModal"
      heading="Add Job"
      classes="modal-md"
      @submit="addJob"
    >
      <template slot="modalBody">
        <form>
          <div
            class="form-group"
          >
            <label>Job Name</label>
            <input
              id="career_name"
              v-model="career_name"
              type="text"
              class="form-control"
              name="jname"
            >
          </div>
          <div
            class="form-group"
          >
            <label for="category">Category</label>
            <select
              id="category"
              v-model="edit_category"
              name="category"
              class="form-control"
            >
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
        </form>
      </template>
    </modal>
  </section>
</template>
<script>
import Modal from '../../components/VueNiceModal';
import VueTableComponent from '@/components/vue-table-component';
import StaffLayout from '@/Layouts/StaffLayout';
import jobsVue from '../../../../vendor/laravel/horizon/resources/js/screens/metrics/jobs.vue';
export default {
	layout:StaffLayout,
	components:{
    	Modal,
		VueTableComponent,
	
	},
  	props:['careers','categories'],
	data() {
		return {
     	career_name:'',
      	edit_category: 14,
			jobList:[],
			jobColumns: [
				{
					label: 'Job Name',
					field: 'career_name',
				},
				{
					label: 'Category',
					field: 'category_name',
				},
				
				{
					label: 'Menu',
					field: 'menu',
				},
			]
		};
	},
  
	mounted(){
		this.jobList=this.careers; 
	},
	methods:{
    
		addJob()
    	{
			console.log('xyz');
    		this.axios.post(this.baseUrl + '/api/career',{
    			career_name:this.career_name,
    			category_id:this.edit_category,
    		} )
    			.then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addEditJobModal.closeModal();
    				this.career_name='';
					window.location.reload();
    			})
    			.catch(err => {
    				
    			});
    	},
		editJob(career){
         
               	this.axios.post('/api/career',{
				career_name:this.career_name,
    		        	category_id:this.edit_category,
				career_id:career.career_id,
			})
				.then(resp=>{
					let index= this.jobList.findIndex(el=>el.career_id===career.career_id);
					this.jobList[index]['career_name']=this.career_name;
					this.jobList[index]['category_id']=this.edit_category;
				});
		
		},
		deleteJob(career){                 
			this.axios.delete('/api/career/'+career.career_id)
				.then(resp=>{
					let index= this.jobList.findIndex(el=>el.career_id===career.career_id);
					this.jobList.splice(index,1);
				});
     
		}
   
	}
  
};

</script>
