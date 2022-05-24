<template>
  <div class="">
    <label class="font-size-16 mb-0"> {{ ('Institute Name') }} </label>
    <div class="">
      <div class="">
        <auto-complete
          :key="'institute'"
          :items="institute_list"
          :value="'name'"
          name="institute_name"
          :is-async="true"
          :initial-value="selected_institute"
          :is-loading="instituteLoading"
          @input="getInstitutes"
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
	props:['value'],
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
			this.selected_institute = result;
			this.$emit('input', result);
		},
	}
};
</script>