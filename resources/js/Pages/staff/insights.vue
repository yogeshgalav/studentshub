<template>
  <div>
    <single-value
        :value="23"
        label="Total Users"
      />
      <single-value
        :value="23"
        label="Total Users Phone"
      />
      <single-value
        :value="23"
        label="Total Institute"
      />
      <single-value
        :value="23"
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
    mounted(){
        	this.axios.post('/api/insights',{
						days:30
					}).then((resp)=>{
						console.log(resp);
					});
    } 
};
</script>