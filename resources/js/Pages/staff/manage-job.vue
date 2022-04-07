<template>
  <section>
    <div class="row">
      <div class="col-md-12">
        <accordion
          title="Details"
          :aria-expanded="true"
        >
          <vue-table-component
            :columns="userColumns"
            :rows="userList"
          >
            <template
              slot="table-row"
              slot-scope="props"
            >
              <span v-if="props.column.field==='full_name'">
                <router-link
                  :href="'/lead/'+props.row.user_id"
                  class="text-underline"
                >{{ props.row['full_name'] }}</router-link>
              </span>
            </template>
            <template slot="emptystate">
              No user found.
            </template>
          </vue-table-component>
        </accordion>
      </div>
    </div>
        
    <modal
      ref="addEditCareerModal"
      name="addEditCareerModal"
      heading="Add Career"
      classes="modal-md"
      @submit="addOrEditCareer"
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
                type="text"
                class="form-control"
                name="jname"
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
import VueTableComponent from '@/components/vue-table-component';
import Accordion from '@/components/accordion.vue';

import StaffLayout from '@/Layouts/StaffLayout';
import FormMixin from '@/components/mixins/form-mixin.js';

export default {
	layout:StaffLayout,
	components:{
		VueTableComponent,
		Accordion
	},
	mixins:[FormMixin],
	props:['careers','categories'],
	data() {
		return {
			userList:[],
			userColumns: [
				{
					label: 'User Name',
					field: 'user_name',
				},
				{
					label: 'Phone Number',
					field: 'phone_no',
				},
				
				{
					label: 'Onboarded At',
					field: 'onboarded_at',
				},
			]
		};
	},
	mounted(){
		this.careerList=this.careers; 
	},
	methods:{
		addOrEditCareer(){	
			this.validateForm().then(valid => {
				if (valid) {
					this.careerCreateOrUpdateApi();
				}
			});
		},
		careerCreateOrUpdateApi(){
			let loader = this.$loading.show();
			this.axios.post(this.baseUrl + '/api/career',{
				career_name:this.career_name,
				category_id:this.edit_category,
				career_id:(this.career_id),
			}).then(resp => {
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
			this.career_alias='';		
			this.career_id='';
			this.edit_category='';
		}

	}
};

</script>
