<template>
  <div class="form-group">
    <label class="mb-1"> {{ ('Institute Name') }} </label>
    <div class="">
      <div class="">
        <auto-complete
          :key="'institute'"
          v-model="selected_institute"
          :items="institute_list"
          :label="'name'"
          name="institute_name"
          placeholder="School/Coaching/College/University"
          :is-async="true"
          :is-loading="instituteLoading"
          @search="getInstitutes"
          @selected="setInstitute"
        />
      </div>
    </div>
  </div>
</template>
<script>
import AutoComplete from './AutoComplete.vue';
export default {
	components:{
		AutoComplete
	},
	props:{
		value: {
			type: Object,
			required: true,
			default: () => {},
		},
	},
	data(){
		return {
			institute_list: [],
			instituteLoading: false,
			selected_institute: this.value,
		};
	},
	watch:{
		value(val){
			this.selected_institute = val;
		}
	},
	methods:{
		getInstitutes(search) {
			this.selected_institute = {
				'id': null,
				'name': search,
			};
			this.instituteLoading = true;
			this.axios
				.get(this.baseUrl + '/api/search-institute?searchTerm='+search)
				.then(resp => {
					this.institute_list = resp.data.success.institutes;
					this.instituteLoading = false;
				}).catch(() => {
					this.instituteLoading = false;
				});
			this.$emit('change');
			this.$emit('input', this.selected_institute);
		},
		setInstitute(result) {
			this.$emit('input', result);
		},
	}
};
</script>