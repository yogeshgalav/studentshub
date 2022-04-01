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
                      @click="deleteCourse(props.row)"
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
      @cancel="clearModalData"
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
                v-validate="'required'"
                type="text"
                class="form-control"
                name="course_name"
              >
              <span class="error">{{ formErrors('course_name') }}</span>
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
                v-validate="'required'"
                type="text"
                class="form-control"
                name="course_alias"
              >
              <span class="error">{{ formErrors('course_alias') }}</span>
            </div>
          </div>
          <div
            class="form-group"
          >
            <label for="category">Category</label>
            <select
              id="category"
              v-model="edit_category"
              v-validate="'required'"
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
import FormMixin from '@/components/mixins/form-mixin.js' ;
import StaffLayout from '@/Layouts/StaffLayout';
import coursesVue from '../../../../vendor/laravel/horizon/resources/js/screens/metrics';

export default {
	layout:StaffLayout,
	components:{
    	Modal,
		VueTableComponent	
	},
  	mixins: [FormMixin],
  	props:['courses','categories'],
	data() {
		return {
      	showLoader: false,
       	course_name:'',
			course_alias:'',
      	edit_category: '',
			course_id:'',
		
			
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
		addCourse(){	this.validateForm().then(valid => {
			if (valid) {
				let loader = this.$loading.show();
    		  this.axios.post(this.baseUrl + '/api/add-course',{
    			course_name:this.course_name,
					course_alias:this.course_alias,
    			category_id:this.edit_category,
				  course_id:(this.course_id),
				      	})
    			.then(resp => {
            
						let category_name =this.categories.find(el=>el.id===this.edit_category).name;
						window.location.href='/manage-courses'; 
				     	if (this.course_id){
					   	  let index= this.courseList.findIndex(el=>el.course_id===this.course_id);
			          this.courseList[index]['course_name']=this.course_name;
					    	this.courseList[index]['course_alias']=this.course_alias;
					    	this.courseList[index]['category_id']=this.edit_category;   
					    	this.courseList[index]['category_name']=category_name;           
				            	}	else{
					              	this.courseList.push({
				           	      course_name:resp.data.success.course.course_name,
						             	course_alias:resp.data.success.course.alias,
				                	category_id:resp.data.success.course.edit_category,
				                	course_id:resp.data.success.course.course_id,
						            	category_name:category_name,
						                                	});						
				                  	}    			
    				this.$refs.addEditCourseModal.closeModal();
				  	this.clearModalData();
    		  	})
			
    			.catch(err => {});
          	}
		});
                	},
                  	// set course data in add edit modal
          	editCourse(course) {
			                this.course_alias=course.course_alias;    	    
			                this.course_id=course.course_id;
             	        this.course_name=course.course_name; 
                    	this.edit_category=course.category_id;  
			        },
              

		       deleteCourse(course){  
		            	this.axios.delete('/api/course/'+course.course_id)
			          	.then(resp=>{
				           	let index= this.courseList.findIndex(el=>el.course_id===course.course_id);
				          	this.courseList.splice(index,1);		
			                      	});
		                },

	      	clearModalData(){
                	this.course_name='';
				        	this.course_alias='';		
		            	this.course_id='';
		            	this.edit_category='';
                        	}
	}
};

</script>

