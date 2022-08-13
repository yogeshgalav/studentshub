<template>
  <div>
    <single-value
      :value="users"
      label="Total Users"
    />
    <single-value
      :value="phones"
      label="Total Users Phone"
    />
    <single-value
      :value="institutes"
      label="Total Institute"
    />
    <single-value
      :value="students"
      label="Total Students"
    />
  </div>
</template>
<script>
    
import SingleValue from '../../components/SingleValue';
export default {
	components: {
		SingleValue
	},
	data(){
		return {
			students:0,
			users:0,
			phones:0,
			institutes:0,
		};
	},
	mounted(){
		this.axios.post('/api/insights',{days:30})
			.then((resp)=>{
				this.students = resp.data.success.students;
				this.users = resp.data.success.users;
				this.phones = resp.data.success.phones;
				this.institutes = resp.data.success.institutes;
			});
	} 
};
</script>