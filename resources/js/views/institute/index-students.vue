<template>
  <div class="row">
    <div class="col-md-12">
      <h1>Students</h1>
    </div>
    <hr>
    <div class="col-md-12 col-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <vue-table-component
                :columns="studentColumns"
                :rows="studentRows"
              >
                <template
                  slot="table-row"
                  slot-scope="props"
                >
                  <span v-if="props.column.field==='full_name'">
                    <a :href="'/student/'+props.row.id">{{ props.row.full_name }}</a>
                  </span>
                  <span v-else>
                    <span>{{ props.row[props.column.field] }}</span>
                  </span>
                </template>
              </vue-table-component>
            </div> 
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import VueTableComponent from '../../components/vue-table-component';

export default {
	components:{
		VueTableComponent
	},
	data(){
		return {
			studentRows:[],
			studentColumns: [
				{
					label: 'Student Name',
					field: 'full_name',
				},
				{
					label: 'Institute id',
					field: 'institute_id',
				},
				{
					label: 'Email',
					field: 'email',
				},
				{
					label: 'Course',
					field: 'course_alias',
				},
				{
					label: 'Average score',
					field: 'avg_score',
				},
			],
		};
	},

	mounted(){
		this.axios.get('/api/students').then((resp)=>{
			let total_avg1 = 0;
			let count1 = 0;
			this.studentRows=resp.data.success.students.map(node=>{
				if(node.avg_score){
					node.avg_score = parseFloat(node.avg_score).toFixed(2);
					total_avg1 = total_avg1 + node.avg_score;
					count1 = count1 + 1;
				}
				return node;
			});
		});
	},
};
</script>