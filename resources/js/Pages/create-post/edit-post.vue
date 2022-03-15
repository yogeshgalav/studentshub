<template>
  <div>
    <loading 
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div
      v-if="new_post"
      class="creat_post_card img_der"
    >
      <div class="row">
        <div class="col-md-12">
          <div class="">
            <div class="form-group">
              <div class="text-center">
                <p class="title weight-600 font-size-16 text-black">
                  Edit Post
                </p>
              </div>
              <label class="weight-500">Heading</label>
              <div class="input_icon_frm">
                <span
                  class="icon_design_input"
                ><i
                  class="fa fa-user"
                /></span>
                <input
                  v-model="new_post.heading"
                  type="text"
                  class="form-control"
                  :disabled="new_post.post_type === 'mcq'"
                >
              </div>
            </div>

            <div class="form-group">
              <label for="category"> {{ "Category" }} </label>
              <div class="inner-addon left-addon">
                <div class="input_icon_frm">
                  <span
                    class="icon_design_input"
                  ><i
                    class="fa fa-file"
                    aria-hidden="true"
                  /></span>
                  <select
                    v-model="selected_category"
                    name="category"
                    class="form-control"
                  >
                    <option value="">
                      Select Category
                    </option>
                    <option
                      v-for="category in categories"
                      :key="category.id"
                      :value="category.id"
                    >
                      {{ category.name }}
                    </option>
                  </select>
                </div>
                <span class="error">{{
                  formErrorst("category")
                }}</span>
              </div>
            </div>
            <div class="form-group">
              <label
                class="weight-500"
                for="subject"
              >Subject (optional)</label>
              <div class="inner-addon left-addon">
                <div class="input_icon_frm">
                  <span
                    class="icon_design_input"
                    style="height: 44px"
                  >
                    <i
                      class="fa fa-certificate"
                      aria-hidden="true"
                    /></span>
                  <auto-complete
                    class="width-100"
                    :items="subject_list"
                    :value="'subject_name'"
                    name="subject_name"
                    :is-async="true"
                    :is-loading="subjectLoading"
                    :initial-value="selected_subject"
                    @input="getSubjects"
                    @selected="setSubject"
                    @selectNew="setNewSubject"
                  />
                  <span class="error">{{
                    formErrors("subject")
                  }}</span>
                </div>
              </div>
            </div>
            <div class="creat_post_btn" />
          </div>
          <rich-text-editor
            id="ArticleEditor"
            v-model="content"
          />
          <span>{{ countContent }}/100</span>&nbsp;<span class="text-danger">{{ error }}</span>
        </div>
        <div class="creat_post_btn">
          <button
            class="btn btn-primary"
            type="button"
            @click="handleSubmit"
          >
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import EventBus from './event-bus';
import { mapState } from 'vuex';
import AutoComplete from '../../components/AutoComplete.vue';
import swal from '../../components/swal';
import RichTextEditor from '../../components/RichTextEditor';

export default {
	components: {
		AutoComplete,
		RichTextEditor
	},
	props:['post'],
	data() {
		return {
			content:this.post.article_html_content,
			files:[],
			error:'',
			new_post:null,
			subject_list: [],
			subjectLoading: false,
			selected_subject: {
				id: this.post.subject.id,
				subject_name: this.post.subject.subject_name
			},
			selected_category: this.post.category.id,
			showLoader:false,
		};
	},
	computed:{
		...mapState({
			categories: state => state.categories
		}),
		description(){
			if(this.content.trim()===''){
				return '';
			}
			var span= document.createElement('span');
			span.innerHTML= this.content;
        
			var children= span.querySelectorAll('*');
			for(var i = 0 ; i < children.length ; i++) {
				if(children[i].textContent)
					children[i].textContent+= ' ';
				else
					children[i].innerText+= ' ';
			}
			return [span.textContent || span.innerText].toString();
		},
		countContent(){
			return this.description.toString().trim().split(/\s+/).length;
		}
	},
	mounted() {
		this.$store.dispatch('post/getCategories');
		this.new_post = {
			article_html_content: this.post.postable['html_content'],
			category_id: this.post.category_id,
			description: this.post.post_description,
			document_link: this.post.postable['link'],
			// fact_image:'',
			// fact_image_url:this.post.primary_image_path,
			heading:this.post.post_heading,
			post_type:this.post.post_type,
			// subject_course:null,
			subject_id:this.post.subject.id,
			subject_name:this.post.subject.subject_name,
			video_id: this.post.postable['video_id'],
		};
	},
	methods: {
		getSubjects(search) {
			this.selected_subject = {
				id: null,
				subject_name: search
			};
			this.subjectLoading = true;
			this.axios
				.get(this.baseUrl + '/api/search-subject?searchTerm='+search)
				.then(resp => {
					this.subject_list = resp.data.success.subjects;
					this.subject_list.find(node => {
						if (
							node.subject_name.toLowerCase() ===
                            this.selected_subject.subject_name.toLowerCase()
						) {
							this.selected_subject = node;
							return true;
						}
					});
					this.subjectLoading = false;
				})
				.catch(() => {
					this.subjectLoading = false;
				});
		},
		setSubject(result) {
			this.selected_subject = result;
			if (this.selected_subject.category_id) {
				this.selected_category = this.selected_subject.category_id;
			}
		},
		setNewSubject(name) {
			this.selected_subject = {
				id: 0,
				subject_name: name
			};
		},
		handleSubmit(){
			this.$store.commit('set_post_heading',{'post_heading': this.new_post.heading});
			this.$store.commit('set_post_subject',{
				'subject_name':this.selected_subject.subject_name,
				'selected_category':this.selected_category
			});
			EventBus.$emit('validateStep2');
			EventBus.$on('validateWizard',(i,valid)=>{
				if(valid){
					this.$validator.validate().then((result)=>{
						if(result && !this.showLoader){
							this.showLoader=true;
							this.axios.put('/api/post/'+this.post.id,this.$store.state.post)
								.then(resp=>{
									this.showLoader=false;
									swal.successDialog('Post Updated', 'Successfully!', 'success');
									window.location.href ='/post/'+this.post.id;
								});
						}
					});
				}
			});
		}
	}
};
</script>
<style scoped>

/* Create-Post-Content */

.creat_post_btn button {
    margin: 5px 0px !important;
    min-width: 40%;
}

.creat_post_btn {
    display: flex;
    align-items: center;
    flex-wrap: wrap-reverse;
    justify-content: space-between !important;
    margin: 15px auto;
}
.creat_post_card {
    padding: 20px;
    width: 100%;
}
button.btn-primary btn-lg span {
    margin: 0px 5px;
}
.creat_post_card .form-control {
    border-radius: 0;
    transform: inherit;
}

/* Create-Post_description */

.login_img img {
    width: 70%;
    margin: 0 auto;
}
button.btn-primary btn-lg span {
    margin: 0px 5px;
}
.creat_post_btn {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    flex-wrap: wrap-reverse;
}
.creat_post_card .row {
    -webkit-box-align: center;
    align-items: center;
    width: 100%;
}
.creat_post_btn button {
    margin: 5px 0px !important;
    min-width: 40%;
}
.creat_post_card {
    padding: 20px;
    display: -webkit-box;
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: center;
}

.creat_post_card .form-control {
    border-radius: 0;
    transform: inherit;
}
</style>