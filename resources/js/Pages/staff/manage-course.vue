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
                      @click="editCourse(props.row)"
                    >
                      <i class="fa fa-edit" />
                    </button>
                    <button
                      class="btn btn-danger btn-sm rounded-0"
                      type="button"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Delete"
                      @click="deleteCourse"
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
        <form>
          <div class="p-10">
            <div
              class="form-group"
            >
              <label>Course Name</label>
              <input
                id="course_name"
                v-model="course_name"
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
              <label>Alias</label>
              <input
                id="course_alias"
                v-model="course_alias"
                type="text"
                class="form-control"
                name="aname"
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
  	props:['courses','categories'],
	data() {
		return {
       	course_name:'',
			course_alias:'',
      	edit_category: 14,
			courseList:[],
			courseColumns: [
        
				{
					label: 'Course Name',
					field: 'course_name',
				},
				{
					label: 'Course Alias',
					field: 'course_alias',
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
		this.courseList=this.courses; 
	},
	methods:{
		addCourse()
    	{
			console.log('xyz');
    		this.axios.post(this.baseUrl + '/api/add-course',{
    			course_name:this.course_name,
				course_alias:this.course_alias,
    			category_id:this.edit_category,
    		} )
    			.then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addEditCourseModal.closeModal();
    				this.course_name='';
					window.location.reload();
    			})
    			.catch(err => {
    				
    			});
    	},
	},
	editCourse(course) {
		console.log(course);
		this.course_name= course.course_name;

	},
	deleteCourse(course) {
		console.log(course);
		this.axios.delete(this.baseUrl + '/api/delete-course',{
    		course_id:courseId,
    		}).then((resp) => {
		
			window.location.reload();
		});

	},
};

</script>

