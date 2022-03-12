<template>
    <section>

     <div class="row">
        <div class="col-md-12">
          <accordion
            title="Details"
            :aria-expanded="true"
          >
            <vue-table-component
              :columns="classroomColumns"
              :rows="classroomList"
            >
              <template
                slot="table-row"
                slot-scope="props"
              >
                <span v-if="props.column.field==='classroom_name'">
                  <router-link
                    :href="'/classroom/'+props.row.classroom_id"
                    class="text-underline"
                  >{{ props.row['classroom_name'] }}</router-link>
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

import SidebarLayout from '@/Layouts/SidebarLayout';
export default {
    layout:SidebarLayout,
    components:{
		VueTableComponent,
		Accordion
	},
    data() {
		return {
            classroomList:[],
			classroomColumns: [
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
    }
}

</script>
