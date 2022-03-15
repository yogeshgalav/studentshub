<template>
  <div class="">
    <div class="row">
      <div class="col-md-6">
        <div class="login_img">
          <img
            src="/images/undraw_post_online_dkuk.svg"
            alt=""
          >
        </div>
      </div>
      <div class="col-md-6">
        <div class="logn_right">
          <div class="form-group">
            <label class="weight-500">Heading</label>
            <div class="">
              <input
                id="heading"
                v-model="heading"
                v-validate="'required'"
                name="heading"
                type="text"
                class="form-control"
              >
              <span class="error">{{ formErrors('heading') }}</span>
            </div>
          </div>

          <div class="form-group">
            <label for="category"> {{ "Category" }} </label>
            <div class="">
              <div class="">
                <select
                  v-model="selected_category"
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
              <span class="error">{{
                formErrors("category")
              }}</span>
            </div>
          </div>
          <div class="form-group">
            <label for="subject_tags">Subject tags</label>
            <vue-tags-input
              v-model="tag"
              :tags="tags"
              :autocomplete-items="filteredItems"
              @tags-changed="newTags => tags = newTags"
            />
          </div>
          <div
            v-if="selected_course.id"
            class="form-group"
          >
            <label class="weight-500">Course</label>
            <div class="">
              <input
                id="course_name"
                :value="selected_course.course_name"
                disabled
                name="course_name"
                type="text"
                class="form-control"
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.post-type{
    margin: 50%;
}
.login_img img {
    width: 70%;
    margin: 0 auto;
}
.creat_post_card {
    background-color: white;
    margin-top: 30px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
}
.creat_post_card .row {
    align-items: center;
}
button.btn-primary btn-lg span {
    margin: 0px 5px;
}
.creat_post_btn {
    margin-top: 30px;
}
.creat_post_card .form-control
{
    border-radius: 0;
      transform: inherit;
    }
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

</style>

<script>
import EventBus from '../event-bus';
import { mapState } from 'vuex';
import VueTagsInput from '@johmun/vue-tags-input';
import FormMixin from './../../../components/mixins/form-mixin';

export default {
	components: { VueTagsInput },
	mixins:[FormMixin],
	data() {
		return {
			tag: '',
			tags: [],
			heading: '',
			subject_list: [],
			subjectLoading: false,
			selected_category: 14
		};
	},
	computed: {
		...mapState({
			categories: state => state.categories,
			heading: state => state.heading,
			selected_course: state => state.selected_course,
			selected_subjects: state => state.selected_subjects
		}),
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
	mounted() {
		this.tags = this.$store.state.post.selected_subjects;
		this.heading = this.$store.state.post.heading;
		this.selected_category = this.$store.state.post.selected_category_id;
		EventBus.$on('validateStep1', () => {
			this.$validator.validate().then(valid => {
				if (valid) {
					this.$store.commit('set_post_subject', {
						selected_subjects: this.tags,
						selected_category: this.selected_category
					});
					this.$store.commit('set_post_heading', {
						post_heading: this.heading
					});
					EventBus.$emit('validateWizard', 1, true);
				} else {
					EventBus.$emit('validateWizard', 1, false);
				}
			});
		});
	},
	methods: {
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
	}
};
</script>
