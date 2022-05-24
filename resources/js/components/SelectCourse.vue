<template>
  <div class="">
    <label class="font-size-16 mb-0"> {{ ('Course Name') }} </label>
    <div class="">
      <div class="">
        <auto-complete
          :key="'course'"
          :items="course_list"
          :value="'course_name'"
          name="course_name"
          :is-async="true"
          :initial-value="selected_course"
          :is-loading="courseLoading"
          @input="getCourses"
          @selected="setCourse"
        />
      </div>
      <span>Please select Preparatory (3-5), Middle (6-8) or Secondary Stage (9-12) in case of school.</span>
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
			course_list: [],
			courseLoading: false,
			selected_course: this.value,
		};
	},
	watch:{
		value(val){
			this.selected_course = val;
		}
	},
	methods:{
		getCourses(search) {
			this.selected_course = {
				'id': null,
				'name': search,
			};
			this.courseLoading = true;
			this.axios
				.get(this.baseUrl + '/api/search-course?searchTerm='+search)
				.then(resp => {
					this.course_list = resp.data.success.courses;
					this.courseLoading = false;
				}).catch(() => {
					this.courseLoading = false;
				});
			this.$emit('change');
			this.$emit('input', this.selected_course);
		},
		setCourse(result) {
			this.selected_course = result;
			this.$emit('input', result);
		},
	}
};
</script>