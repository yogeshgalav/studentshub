<template>
  <section>
    <div>
      <div class="row">
        <div class="col-md-12">
          <h1>Manage Course</h1>
        </div>
      </div>
      <hr>
      <div class="mb-2">
        <button
          type="edit"
          class="btn-lg btn-primary"
          data-toggle="modal"
          data-target="#addEditCourseModal"
        >
          <i class="fas fa-plus" />&nbsp;&nbsp;
          Add Course
        </button>
      </div>
    
    
      <div class="card mb-2 pl-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <vue-table-component
                :columns="courseColumns"
                :rows="courseList"
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
                      data-target="#addEditCourseModal"
                    >
                      <i class="fa fa-edit" />
                    </button>
                    <button
                      class="btn btn-danger btn-sm rounded-0"
                      type="button"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Delete"
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
      ref="addEditCourseModal"
      name="addEditCourseModal"
      heading="Add Course"
      classes="modal-md"
      @submit="addCourse"
    >
      <template slot="modalBody">
        <form @submit.prevent="addCourse">
          <div class="p-10">
          <div
            class="form-group"
          >
            <label>Course Name</label>
            <input
              id="cname"
              type="text"
              class="form-control"
              name="cname"
            >
          </div>
          </div>
          <div class="m-8-a">
          <div
            class="form-group"
          >
            <label>Alis</label>
            <input
              id="cname"
              type="text"
              class="form-control"
              name="cname"
            >
            </div>
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
export default {
	layout:StaffLayout,
	components:{
    	Modal,
		VueTableComponent,
	
	},
  	props:['course','categories'],
	data() {
		return {
      	edit_category: 14,
			courseList:[],
			courseColumns: [
        
				{
					label: 'Course Name',
					field: 'course_name',
				},
        {
					label: 'Course Alias',
					field: 'course alias',
				},
				{
					label: 'Category',
					field: 'category',
				},
				
				
        {
					label: 'Menu',
					field: 'menu',
				},
			]
		};
	},
   methods:{
	addCourse()
    	{
        console.log('xyz');
      }
   },
	mounted(){
    
		this.axios.get('/api/leads').then(resp=>{
			this.courseList = resp.data.success.leads;
      

		});
    
	}
  
};

</script>
