<template>
  <section>
    <Head>
      <title>Membership Details</title>
    </Head>
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
	props:['members','userId'],
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
					field: 'current_plan',
				},
				{
					label: 'First Purchase at',
					field: 'first_purchase_at',
				},
				{
					label: 'Last Purchase at',
					field: 'last_purchase_at',
				},
				{
					label: 'Expires at',
					field: 'expires_at',
				},
				
				
			]
		};
	},
	mounted(){	
		let api='/api/membership';
		if(this.userId){
			api=api+'/'+this.userId;
		}
		this.axios.get(api).then(resp=>{
			this.userList = resp.data.success.members;
      		});
    
	}
};

</script>
