<template>
  <form
    method="GET"
    action="/search"
  >
    <div id="custom-search-input">
      <div class="input-group">
        <input
          type="text"
          class="search-query form-control"
          name="query"
          placeholder="Search..."
        >
        <auto-complete
          :items="course_list"
          :value="'course_name'"
          :is-async="true"
          :is-loading="courseLoading"
          @input="getCourses"
          @selected="setCourse"
          @selectNew="setNewCourse"
        />
        <span class="input-group-btn">
          <button
            class="btn btn-link"
            type="submit"
          >
            <i class=" fa fa-search text-black weight-400" />
          </button>
        </span>
      </div>
    </div>
  </form>
</template>
<script>
import AutoComplete from '../../components/AutoComplete.vue';

export default {
	components:{
		AutoComplete
	}
};
</script>
