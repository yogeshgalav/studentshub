<template>
  <div class="creat_post_card img_der">
    <div class="row">
      <div class="col-md-12 ml-2">
        <div class="logn_right">
          <div class="form-group">
            <div class="text-center">
              <p class="title weight-600 font-size-16 text-black">
                Post Description.
              </p>
            </div>
            <label class="weight-500">Heading</label>
            <div class="input_icon_frm">
              <span class="icon_design_input"><i class="fa fa-user" /></span>
              <input
                v-model="heading"
                type="text"
                class="form-control"
                :disabled="newPost.post_type==='mcq'"
              >
            </div>
          </div>

          <div class="form-group">
            <label for="category"> {{ 'Category' }} </label>
            <div class="inner-addon left-addon">
              <div class="input_icon_frm">
                <span class="icon_design_input"><i
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
              <span class="error">{{ errors.first('category') }}</span>
            </div>
          </div>
          <div class="form-group">
            <label
              class="weight-500"
              for="subject"
            >Subject</label>
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
                  v-validate="'required'"
                  class="width-100"
                  :items="subject_list"
                  :value="'subject_name'"
                  name="subject_name"
                  :is-async="true"
                  :is-loading="subjectLoading"
                  @input="getSubjects"
                  @selected="setSubject"
                  @selectNew="setNewSubject"
                />
                <span class="error">{{ errors.first('subject') }}</span>
              </div>
            </div>
          </div>
          <div class="creat_post_btn">
            <button
              type="button"
              class="btn-primary btn-lg m-0-a"
              @click="prevTab"
            >
              <span><i
                class="fa fa-arrow-left"
                aria-hidden="true"
              /></span> Back
            </button>
            <button
              type="button"
              class="btn-primary btn-lg m-0-a"
              @click="nextTab"
            >
              Finish <span><i
                class="fa fa-arrow-right"
                aria-hidden="true"
              /></span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style  scoped>
.login_img img {
    width: 70%;
    margin: 0 auto;
}
.creat_post_btn button {
    margin: 0px 15px 0px 0;
}
button.btn-primary btn-lg span {
    margin: 0px 5px;
}
.creat_post_btn {
    margin-top: 30px;
}

.creat_post_btn {
    display: flex;
    /* margin-top: 22px; */
    justify-content: space-between;
}
.creat_post_card .form-control
{
    border-radius: 0;transform: inherit
    }
</style>
<script>
import EventBus from '../event-bus';
import {mapState} from 'vuex';
import AutoComplete from '../../../components/AutoComplete.vue';

export default {
	components:{AutoComplete},
	props:['newPost'],
	data(){
		return{
			heading:this.newPost.heading,
			subject_list: [],
			subjectLoading: false,
			selected_subject: {
				'id': null,
				'subject_name': this.newPost.subject_name,
			},
			selected_category:this.newPost.category_id,
		
		};
	},
	computed:{
		...mapState({
			'categories': state=>state.categories,
		}),
	},
	mounted(){
		EventBus.$on('validateStep3',()=>{
			this.$validator.validate().then(valid => {
				if(valid){
					this.$store.commit('set_post_subject',{
						'subject_name':this.selected_subject.subject_name,
						'selected_category':this.selected_category
					});
					this.$store.commit('set_post_heading',{'post_heading': this.heading});
					EventBus.$emit('validateWizard',3,true);
				}else{
					EventBus.$emit('validateWizard',3,false);
				}
			});
		});

		this.selected_category= (this.AuthStudent && this.AuthStudent.categoryId) ? this.AuthStudent.categoryId : '';
	
	},
	methods:{
		getSubjects	(search) {
			this.selected_subject = {
				'id': null,
				'subject_name': search,
			};
			this.subjectLoading = true;
			this.axios
				.post(this.baseUrl + '/api/search-subject', {
					searchTerm: search
				})
				.then(resp => {
					this.subject_list = resp.data.success.subjects;
					this.subject_list.find(node => {
						if (node.subject_name.toLowerCase() === this.selected_subject.subject_name
							.toLowerCase()) {
							this.selected_subject = node;
							return true;
						}
					});
					this.subjectLoading = false;
				}).catch(() => {
					this.subjectLoading = false;
				});

		},
		setSubject(result) {
			this.selected_subject = result;
			if(this.selected_subject.category_id){
				this.selected_category = this.selected_subject.category_id;
			}
		},
		setNewSubject(name) {
			this.selected_subject = {
				'id': 0,
				'subject_name': name,
			};
		},
		nextTab(){
			EventBus.$emit('nextTab');
		},
		prevTab(){
			EventBus.$emit('prevTab');
		},
	}
};
</script>
