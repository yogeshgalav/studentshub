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
