<template>
  <section>
    <Head>
      <title>User Feedbacks</title>
    </Head>
    <div class="row">
      <div class="col-md-12">
        <h1>User Feedbacks</h1>
        
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
      </div>
    </div>
  </section>
</template>
<script>
import VueTableComponent from '@/components/vue-table-component';

import StaffLayout from '@/Layouts/StaffLayout';
export default {
	layout:StaffLayout,
	components:{
		VueTableComponent,
	},
	data() {
		return {
			userList:[],
			userColumns: [
				{
					label: 'Email',
					field: 'email',
				},
				{
					label: 'User Name',
					field: 'full_name',
				},
				{
					label: 'Feedback',
					field: 'description',
				},
				{
					label: 'Created At',
					field: 'created_at',
				},
			]
		};
	},
	mounted(){
    
		this.axios.get('/api/user-feedbacks').then(resp=>{
			this.userList = resp.data.success.feedbacks;
		});
    
	}
};

</script>
