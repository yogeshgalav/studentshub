<template>
  <div>
    <h1>Anjum</h1>
    <hr>
    <form>
      <div class="">
        <div class="row">
          <div
            class="form-group col-md-6 col-12"
          >
            <label for="category">Category</label>
            <select
              id="category"
              v-model="edit_category"
              name="category"
              class="form-control"
            >
              <option
                v-for="category in categories"
                :key="category.id"
                :value="category.id"
              >
                {{ category.name }}
              </option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="doubt_question">Question</label>
            <input
              id="doubt_question"
              v-model="doubt_question"
              class="form-control"
              type="text"
              placeholder="Enter Your Question"
            >
          </div>
          <div class="form-group col-md-12">
            <label for="subject_tags">Subject tags</label>
            <vue-tags-input
              v-model="tag"
              :tags="tags"
              :autocomplete-items="filteredItems"
              @tags-changed="newTags => tags = newTags"
            />
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import VueTagsInput from '@johmun/vue-tags-input';
export default {
	components:{
		VueTagsInput
	},
	props:['categories'],
	data()
	{
		return {
			tag: '',
			edit_category: 14,
			tags: [],
			doubt_question:'',
            subject_list:[],
		};
	},
	computed:{
		filteredItems() {
			return this.subject_list.filter(i => {
				return i.subject_name.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
			});
		},
	},
	
};
</script>