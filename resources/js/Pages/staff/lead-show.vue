<template>
  <section>
    <div>
      <div class="row">
        <div class="col-md-12">
          <h1>Anjum Shaikh</h1>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div
                      class="form-group"
                    >
                      <label for="category">User Lead Status</label>
                      
                       
                      <select
                        class="form-control"
                        aria-label=".form-select-lg example"
                      >
                        <option selected>
                          Lead Status
                        </option>
                        <option value="1">
                          row
                        </option>
                        <option value="2">
                          Invalid
                        </option>
                        <option value="3">
                          Not Intrested
                        </option>
                        <option value="4">
                          Intrested
                        </option>
                        <option value="5">
                          Payment Pending
                        </option>
                        <option value="6">
                          Payment Done
                        </option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleFormControlTextarea1">Description</label>
                      <textarea
                        id="exampleFormControlTextarea1"
                        class="form-control"
                        rows="3"
                      />
                    </div>
                 
                    <div class="form-check">
                      <input
                        id="flexCheckDefault"
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
          title="Lead Assign"
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
  </section>
</template>
<script>
import VueTableComponent from '@/components/vue-table-component';
import Accordion from '@/components/accordion.vue';

import StaffLayout from '@/Layouts/StaffLayout';
export default {
	layout:StaffLayout,
	components:{
		VueTableComponent,
		Accordion
	},
 props:['lead'],
	data() {
		return {
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
		this.axios.get('/api/leads').then(resp=>{
			this.userList = resp.data.success.leads;
		});
	}
};

</script>
