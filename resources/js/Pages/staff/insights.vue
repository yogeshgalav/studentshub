<template>
  <div>
    <div class="row">
      <div class="col-md-3">
        <form>
          <div class="form-group">
            <label for="last_days">Last days:</label>
            <select
              id="last_days"
              v-model="last_days"
              name="last_days"
              class="form-control minimal"
              @change="loadData"
            >
              <option value="7">
                Last 7 days
              </option>
              <option value="30">
                Last 30 days
              </option>
              <option value="60">
                Last 60 days
              </option>
              <option value="90">
                Last 90 days
              </option>
            </select>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
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
  </div>
</template>
<script>
import StaffLayout from '@/Layouts/StaffLayout';
import SingleValue from '../../components/SingleValue';
export default {	
	layout:StaffLayout,
	components: {
		SingleValue
	},
	data(){
		return {
			students:0,
			users:0,
			phones:0,
			institutes:0,
			last_days:7,
		};
	},
	mounted(){
		this.loadData();
	},
	methods:{
		loadData(){
			this.axios.post('/api/insights',{days:this.last_days})
				.then((resp)=>{
					this.students = resp.data.success.students;
					this.users = resp.data.success.users;
					this.phones = resp.data.success.phones;
					this.institutes = resp.data.success.institutes;
				});
		}
	}
};
</script>