<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <h1>Ask Doubt</h1>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="addDoubt">
              <div class="row">
                <div class="col-md-6 col-12">
                  <div
                    class="form-group"
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
                  <div class="form-group">
                    <label for="doubt_question">Question</label>
                    <input
                      id="doubt_question"
                      v-model="doubt_question"
                      class="form-control"
                      type="text"
                      placeholder="Enter Your Question"
                    >
                  </div>
                  <div class="">
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
                
              <div class="mt-2">
                <button
                  type="submit"
                  class="btn btn-primary btn-md"
                >
                  Submit
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
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
  methods:{
	addDoubt()
    	{
        console.log('xyz');
    		this.axios.post(this.baseUrl + '/api/add-doubt',{
    			question:this.doubt_question,
    			category_id:this.edit_category,
    			selected_subjects:this.tags,
    		} )
    			.then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addDoubtModal.closeModal();
    				this.doubt_question='';
    				this.subject='';
    				this.getdata();
    			})
    			.catch(err => {
    				
    			});
    	},
  }
};
</script>