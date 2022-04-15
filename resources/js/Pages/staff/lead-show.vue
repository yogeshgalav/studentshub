<template>
  <section>
    <div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form @submit.prevent="addLead">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div
                      class="form-group"
                    >
                      <label for="category">User Lead Status</label>
                      
                       
                      <select
                        v-model="lead_status"
                        class="form-control"
                        aria-label=".form-select-lg example"
                      >
                        <option value="raw">
                          raw
                        </option>
                        <option value="invalid">
                          Invalid
                        </option>
                        <option value="notInterested">
                          Not Intrested
                        </option>
                        <option value="interested">
                          Intrested
                        </option>
                        <option value="paymentPending">
                          Payment Pending
                        </option>
                        <option value="paymentDone">
                          Payment Done
                        </option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Description</label>
                      <textarea
                        id="exampleFormControlTextarea1"
                        v-model="description"
                        class="form-control"
                        rows="3"
                      />
                    </div>
                 
                    <div class="form-check">
                      <input
                        id="flexCheckDefault"
                        v-model="user_verified"
                        class="form-check-input"
                        type="checkbox"
                        value=""
                      >
                      <label
                        class="form-check-label"
                        for="flexCheckDefault"
                      >
                        User Verified
                      </label>
                    </div>
                  </div>
                </div>
                
                <div class="mt-2">
                  <button
                    type="submit"
                    class="btn btn-primary btn-md"
                  >
                    Submit
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
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
                  :href="'/lead/'+props.row.id"
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
  </section>
</template>
<script>
import VueTableComponent from '@/components/vue-table-component';
import Accordion from '@/components/accordion.vue';

import StaffLayout from '@/Layouts/StaffLayout';
export default {
	components:{
		VueTableComponent,
		Accordion
	},
	props:['userId'],
	layout:StaffLayout,
	
	data() {
		return {
			showLoader: false,
			lead_status:'',
			description:'',
			user_verified:'',
			userList:[],
			userColumns: [
				{
					label: 'Staff Name',
					field: 'staff_name',
				},
				{
					label: 'Assigned At',
					field: 'assigned_at',
				},
			]
		};
	},
	mounted(){
		let api='/api/lead';
		if(this.userId){
			api=api+'/'+this.userId;
		}
		this.axios.get(api).then(resp=>{
			this.userList = resp.data.success.leadAssigned;
			this.lead_status = resp.data.success.leadData.lead_status;
			this.description = resp.data.success.leadData.description;
      		});
	},
	methods:{
		addLead(){
			let loader = this.$loading.show();
  	this.axios.post('/api/lead/'+this.userId, {
    			lead_status:this.lead_status,
				description:this.description,
    		}).then(resp=>{
				this.$loading.hide(); 			
			});
				
		},
    
	}
};

</script>
