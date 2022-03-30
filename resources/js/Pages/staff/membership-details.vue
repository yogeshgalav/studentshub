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
	props:['members'],
	data() {
		return {
			userList:[],
			userColumns: [
				{
					label: 'User Name',
					field: 'full_name',
				},
				{
					label: 'Current Plan',
					field: 'cureent_plan',
				},
				{
					label: 'First Updated at',
					field: 'first_updated_at',
				},
				{
					label: 'Last Updated at',
					field: 'last_updated_at',
				},
				{
					label: 'Expires at',
					field: 'expires_at',
				},
				
				
			]
		};
	},
	mounted(){
    
		this.axios.get('/api/membership').then(resp=>{
			this.memberList = resp.data.success.members;
      

		});
    
	}
};

</script>
