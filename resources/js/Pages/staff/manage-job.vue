<template>
  <section>
    <Head>
      <title>Manage Careers</title>
    </Head>
    <div>
      <div class="row">
        <div class="col-md-12">
          <h1>Manage Career</h1>
        </div>
      </div>
      <hr>
      <div class="mb-2">
        <button
          type="edit"
          class="btn-lg btn-primary"
          data-toggle="modal"
          data-target="#addEditCareerModal"
        >
          <i class="fas fa-plus" />&nbsp;&nbsp;
          Add Career
        </button>
      </div>
      <div class="card mb-2 pl-3">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <vue-table-component
                :columns="careerColumns"
                :rows="careerList"
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
                      data-target="#addEditCareerModal"
                      @click="editCareer(props.row)"
                    >
                      <i class="fa fa-edit" />
                    </button>
                    <button
                      class="btn btn-danger btn-sm rounded-0"
                      type="button"
                      data-toggle="tooltip"
                      data-placement="top"
                      title="Delete"
                      @click="deleteCareer(props.row)"
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
      ref="addEditCareerModal"
      name="addEditCareerModal"
      heading="Add Career"
      classes="modal-md"
      @submit="addCareer"
      @cancel="clearModalData"
    >
      <template slot="modalBody">
        <form>
          <div class="p-10">
            <div
              class="form-group"
            >
              <label>Career Name</label>
              <input
                id="career_name"
                v-model="career_name"
                v-validate="'required'"
                type="text"
                class="form-control"
                name="career_name"
              >
              <span class="error">{{ formErrors('career_name') }}</span>
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
import careersVue from '../../../../vendor/laravel/horizon/resources/js/screens/metrics';
export default {
	layout:StaffLayout,
	components:{
    	Modal,
		VueTableComponent,
		
	},
	mixins: [FormMixin],
	props:['careers','categories'],
	data() {
		return {
			showLoader: false,
			career_name:'',
			edit_category:'',
			career_id:'',
			careerList:[],
			careerColumns: [
				{
					label: 'Career Name',
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
		this.careerList=this.careers; 
	},
	methods:{
		addCareer(){	
			this.validateForm().then(valid => {
				if (valid) {
					this.careerCreateOrEditApi();
				}
			});
		},
		careerCreateOrEditApi(){
			let loader = this.$loading.show();
			  	this.axios.post(this.baseUrl + '/api/career',{
    			career_name:this.career_name,
    			category_id:this.edit_category,
				  career_id:(this.career_id),
    		})
    			.then(resp => {
					loader.hide();
    				let category_name =this.categories.find(el=>el.id===this.edit_category).name;   			
					if (this.career_id){
             	let index= this.careerList.findIndex(el=>el.career_id===this.career_id);
			        this.careerList[index]['career_name']=this.career_name;
					  	this.careerList[index]['category_id']=this.edit_category;
					  	this.careerList[index]['category_name']=category_name;
					}else{
						this.careerList.push({
							career_name:resp.data.success.career.name,
							category_id:resp.data.success.career.category_id,
							career_id:resp.data.success.career.id,
							category_name:category_name,
						});
					}
          	this.$refs.addEditCareerModal.closeModal();
					this.clearModalData();
    			});
    	},
		editCareer(career){
			this.career_name=career.career_name;
			this.edit_category=career.category_id;
			this.career_id=career.career_id;
		    },
		deleteCareer(career){  	
			let loader = this.$loading.show();             
			this.axios.delete('/api/career/'+career.career_id)
				.then(resp=>{
					loader.hide();
					let index= this.careerList.findIndex(el=>el.career_id===career.career_id);
					this.careerList.splice(index,1);		
				});
		},
    	clearModalData(){
                	this.career_name='';	
		            this.career_id='';
		            this.edit_category='';
		}
	}
};

</script>
