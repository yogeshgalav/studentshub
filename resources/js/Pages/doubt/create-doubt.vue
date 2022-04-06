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
                <div class="col-md-5 col-10">
                  <div
                    class="form-group"
                  >
                    <label for="category">Category</label>
                    <select
                      id="category"
                      v-model="edit_category"
                      v-validate="'required'"
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
                      v-validate="'required'"
                      name="doubt_question"
                      class="form-control"
                      type="text"
                      placeholder="Enter Your Question"
                    >
                    <span class="error">{{ formErrors('doubt_question') }}</span>
                  </div>
                  <div class="">
                    <label for="subject_tags">Subject tags</label>
                    <vue-tags-input
                      v-model="tag"
                      name="subject_tags"
                      :tags="tags"
                      :autocomplete-items="filteredItems"
                      @tags-changed="newTags => tags = newTags"
                    />
                  </div>
                </div>
              </div>
              <div class="row">
                      <div class="p-3">
                        <button
                          type="button"
                          class="btn btn-primary btn-md"
                        >
                          Submit
                        </button>
                      </div>
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
import FormMixin from '@/components/mixins/form-mixin.js' ;
export default {
	components:{
		VueTagsInput
	},
	mixins: [FormMixin],
	props:['categories'],
	data()
	{
		return {
			tag: '',
			edit_category: 14,
			tags: [],
			showLoader: false,
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
        	this.validateForm().then(valid => {
				if (valid) {
					let loader = this.$loading.show();
    		this.axios.post(this.baseUrl + '/api/add-doubt',{
    			question:this.doubt_question,
    			category_id:this.edit_category,
    			selected_subjects:this.tags,
          
    		} )
    			.then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				// this.$refs.addDoubtModal.closeModal();
    				// this.doubt_question='';
    				// this.subject='';
    				// this.getdata();
							window.location.href='/doubt/'+resp.data.success.doubt_id;
    			})
    			.catch(err => {
							this.showLoader = true;
    				
    			});
      	}
			});
		}
	}
};

</script>