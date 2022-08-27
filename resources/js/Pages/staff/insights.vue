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
        :value="registeration"
        label="Total Registerations"
      />
      <single-value
        :value="active_user"
        label="Total Active User"
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
      <single-value
        :value="posts"
        label="Total Posts"
      />
      <single-value
        :value="sthub_posts"
        label="Total Sthub Posts"
      />
      <single-value
        :value="doubts"
        label="Total Doubts"
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
			registeration:0,
			active_user:0,
			posts:0,
			doubts:0,
			sthub_posts:0,
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
					this.registeration = resp.data.success.registeration;
					this.active_user = resp.data.success.active_user;
					this.posts = resp.data.success.posts;
					this.doubts = resp.data.success.doubts;
					this.sthub_posts = resp.data.success.sthub_posts;
					this.phones = resp.data.success.phones;
					this.institutes = resp.data.success.institutes;
				});
		}
	}
};
</script>