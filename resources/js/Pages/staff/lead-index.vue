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
                  :href="'/user-details/'+props.row.id"
                  class="text-underline"
                >{{ props.row['full_name'] }}</router-link>
              </span>
              <span v-else-if="props.column.field==='is_pro_member'">
                {{ props.row['is_pro_member']?'yes':'no' }}
              </span>
              <span v-else>
                {{ props.row[props.column.field] }}
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
	data() {
		return {
			userList:[],
			userColumns: [
				{
					label: 'User Name',
					field: 'full_name',
				},
				{
					label: 'Phone Number',
					field: 'phone_no',
				},
				{
					label: 'Onboarded At',
					field: 'onboarded_at',
				},
				{
					label: 'Role',
					field: 'role',
				},
				{
					label: 'Is Pro Member',
					field: 'is_pro_member',
				},
        	{
					label: 'Total sthub Posts',
					field: 'total_sthub_posts',
				},
				{
					label: 'Total Membership',
					field: 'total_membership_details',
				},
				
				{
					label: 'Total Transactions',
					field: 'total_transaction_details',
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
