<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <h1>{{ editDoubtDetails?'Edit Doubt':'Ask Doubt' }}</h1>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form @submit.prevent="handleSubmit">
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
                          type="submit"
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
	props:['categories','editDoubtDetails'],
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
	watch:{
		tag(val){
			this.getSubjects(val);
		}
	},

	mounted: function () {
		if(this.editDoubtDetails){
			this.doubt_question=this.editDoubtDetails.question;
			this.edit_category=this.editDoubtDetails.category_id;
			this.tags=this.editDoubtDetails.subjects.map(el=>{
				el.text= el.subject_name;
				return el;
			});
			console.log(this.editDoubtDetails.id);
		}
	},  
 

	methods:{
		getSubjects(search) {
			this.axios
				.get(this.baseUrl + '/api/search-subject?searchTerm='+search)
				.then(resp => {
					this.subject_list = resp.data.success.subjects.map(node=>{
    					node['text']=node.subject_name;
    					return node;
    				});
				})
				.catch(() => {
				});
		},
		handleSubmit()
		{
        	this.validateForm().then(valid => {
				if (valid) {
					if(this.editDoubtDetails){
						this.editDoubtapi();
					}
					else{
						this.addDoubtapi();
					}
      	}
			});
		},

		addDoubtapi(){
			let loader = this.$loading.show();
      	this.axios.post(this.baseUrl + '/api/add-doubt',{
    			question:this.doubt_question,
    			category_id:this.edit_category,
    			selected_subjects:this.tags,
          
    		} )
    			.then(resp => {
    			window.location.href='/doubt/'+resp.data.success.doubt_id;
    			});
    		},
		editDoubtapi()
		{
			let loader = this.$loading.show();
      	this.axios.put(this.baseUrl + '/api/doubt/'+this.editDoubtDetails.id,{
    			question:this.doubt_question,
    			category_id:this.edit_category,
    			selected_subjects:this.tags,
          
    		} )
    			.then(resp => {
					window.location.href='/doubt/'+resp.data.success.doubt_id;
    			});
		},


	
	}
};

</script>