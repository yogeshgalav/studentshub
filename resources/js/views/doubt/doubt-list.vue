<template>
  <div class="row">
    <!--the edit message modal -->
    
    <div class="col-md-12">
      <h1>Doubts</h1>
    </div>
    <hr>
    <div class="col-md-10 col-sm-12">
      <div>
        <form
          class="doubt_search_box"
        >
          <div class="row">
            <div class="col-md-8">
              <div class="form-group has-search">
                <span class="fa fa-search form-control-feedback" />
                <input
                  v-model="search_doubt"
                  type="text"
                  name="doubt"
                  class="form-control"
                  placeholder="Search Question"
                  @input="debounceSearch"
                >
              </div>
            </div>

            <div
              v-if="AuthStudent"
              class="col-md-4 custom_btn"
            >
              <button
                type="button"
                data-toggle="modal"
                data-target="#addDoubtModal"
                class="btn btn-lg btn-primary"
                @click="doubt_question=search_doubt"
              >
                Ask new Doubt
              </button>
            </div>
          </div>
        </form>
        <loading
          :key="Math.random()"
          :active.sync="loading"
          :color="'#10069F'"
          :width="100"
          :is-full-page="true"
          :opacity="0.7"
          loader="dots"
          :name="'vue-table-loading' + Math.random()"
        />

        <div class="row">
          <div class="col-md-10 col-sm-12">
            <div
              v-for="(doubt,index) in doubtList"
              :key="index"
            >
              <div class="card mb-2">
                <div class="card-body">
                  <div class="dashboard_post">
                    <div class="avatar doubt_user_img">
                      <profile-image
                        :user-name="doubt.user_name"
                        :avatar="doubt.profile_image"
                      />
                    </div>
                    <div class="info-post ml-2 dash_insititue_name">
                      <p class="font-size-14 mb-0 dash_user_date">
                        {{ doubt.user_name }}<span> {{ doubt.time }}
                          <div
                            v-if="doubt.user_id===AuthUser.id"
                            class="dropdown d-inline"
                          >
                            <button
                              id="dropdownMenuButton"
                              class="btn btn-secondary dropdown-toggle p-0"
                              type="button"
                              data-toggle="dropdown"
                              aria-haspopup="true"
                              aria-expanded="false"
                            >
                              <i class="fas fa-ellipsis-v" />
                            </button>
                            <div
                              class="dropdown-menu dropdown-menu-right"
                              style="min-width: max-content;"
                              aria-labelledby="dropdownMenuButton"
                            >
                              <button
                                type="button"
                                class="dropdown-item"
                                data-toggle="modal"
                                data-target="#addDoubtModal"
                                @click="editDoubt(doubt)"
                              >Edit</button> 
                              <button
                                type="button"
                                class="dropdown-item"
                                @click="deleteDoubt(doubt.id)"
                              >Delete</button>
                            </div>
                          </div>
                        </span>
                      </p>
                      <p class="font-size-14 mb-0">
                        {{ doubt.institute_name }}
                      </p>
                    </div>
                  </div>
                  <hr class="mb-1 mt-2">
                  <div class="row">
                    <div class="col-md-12 d-flex font-size-12 mb-0">
                      <p class="text-muted post_category">
                        {{ doubt.subject_name }}
                      </p>
                    </div>
                    <div class="col-md-12">
                      <p class="font-size-24 weight-600 mb-0">
                        <router-link
                          :to="'/doubt/'+doubt.id"
                          class="weight-600 text-black"
                        >
                          {{ doubt.question }}
                        </router-link>
                      </p>
                    </div>
                  </div>
                  <hr>
                  <interaction-component
                    :user-like="doubt.user_like ? true : false"
                    :total-likes="doubt.total_likes"
                    :likable-id="doubt.id"
                    likable-type="doubt"
                    :edit-access="doubt.user_id===AuthUser.id"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <modal
          v-if="AuthStudent"
          ref="addDoubtModal"
          name="addDoubtModal"
          heading="Ask doubt:"
          size="modal-lg modal-fullscreen"
          @submit="addOrEditDoubt"
        >
          <template slot="modalBody">
            <form>
              <div class="model_box_inner">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label class="text-black font-size-14">Course
                    </label>
                    <input
                      id="course"
                      type="text"
                      class="form-control"
                      disabled
                      :value="AuthStudent.courseName"
                    >
                  </div>
                  <div
                    class="col-md-12"
                  >
                    <div class="model_input">
                      <label>Subject</label>
                      <auto-complete
                        v-validate="'required'"
                        class="width-100"
                        :items="subject_list"
                        :value="'subject_name'"
                        name="program_name"
                        :placeholder="'eg. Biology,Chemistry'"
                        :is-async="true"
                        :is-loading="subjectLoading"
                        :initial-value="selected_subject"
                        @input="getSubjects"
                        @selected="setSubject"
                        @selectNew="setNewSubject"
                      />
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="model_input">
                      <label>Doubt</label>
                      <input
                        v-model="doubt_question"
                        class="form-control"
                        type="text"
                        placeholder="Enter Your Doubt"
                      >
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </template>
        </modal>
      </div>
    </div>
  </div>
</template>
<style scoped>
.has-search .form-control {
    padding-left: 2.375rem;
}
.custom_btn .btn {
  padding: 10px;
}
.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
   width: 1rem;
    height: 1rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
    top: 12px;
    left: 25px;
}
</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import Modal from '../../components/VueNiceModal.vue';
import Loading from 'vue-loading-overlay';
import AutoComplete from '../../components/AutoComplete.vue';
import InteractionComponent from '../common/InteractionComponent.vue';
import ProfileImage from '../../components/ProfileImage';


export default {
  	components:{
		Modal,
		Loading,
		AutoComplete,
		ProfileImage,
		InteractionComponent
	},
	mixins: [FormMixin],
	props:['subjectId','categories'],
	data()
	{
		return {
			edit_doubt_id:'',
			search_doubt:'',
			doubt_question:'',
			subject:'',
			doubtList:[],
			loading:false,
			debounce:null,
			subject_list:[],
			subjectLoading: false,
			show_category: false,
			selected_category: '',
			selected_subject: {
				'id': null,
				'subject_name': '',
			},
		};

	},
	mounted() {
		this.getdata();
		this.selected_category= (this.AuthStudent && this.AuthStudent.categoryId) ? this.AuthStudent.categoryId : '';
		if(this.subjectId){
			this.selected_subject.id = this.subjectId; 
		}
	},
	methods:
    {
    	getdata(){
    		this.loading=true;
    		this.axios.get('/api/get-doubts')
    			.then(response => {
    				this.doubtList = response.data.success.doubtList;
    				this.loading=false;
    			});

    	},
    	debounceSearch(event) {
    		clearTimeout(this.debounce);
    		this.debounce = setTimeout(() => {

    			this.filterinput();
    		}, 600);
    	},

    	//whenever someone enter someting in input box this function will trigger
    	filterinput()
    	{
    		this.loading=true;
    		this.axios.get(this.baseUrl + '/api/get-doubts?search='+this.search_doubt)
    			.then(response => {
    				this.doubtList= response.data.success.doubtList;
    				this.loading=false;
    			});
    	},
    	addOrEditDoubt(){
    		if(this.edit_doubt_id){
    			this.updateDoubt();
    			return true;
    		}
    		this.addDoubt();
    		return true;
    	},
    	addDoubt()
    	{
    		this.axios.post(this.baseUrl + '/api/add-doubt',{
    			doubt:this.doubt_question,
    			category:this.selected_category,
    			subject:this.selected_subject,
    		} )
    			.then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addDoubtModal.closeModal();
    				this.doubt_question='';
    				this.subject='';
    				this.getdata();
    			})
    			.catch(err => {
    				reject(err);
    			});
    	},
    	updateDoubt()
    	{
    		this.axios.post('/api/doubt/' + this.edit_doubt_id + '/edit',{
    			doubt:this.doubt_question,
    			category:this.selected_category,
    			subject:this.selected_subject,
    		}).then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addDoubtModal.closeModal();
    				this.doubt_question='';
    				this.subject='';
    				this.getdata();
    			})
    			.catch(err => {
    				reject(err);
    			});
    	},
    	getSubjects	(search) {
    		this.selected_subject = {
    			'id': null,
    			'subject_name': search,
    		};
    		this.subjectLoading = true;
    		this.axios
    			.get(this.baseUrl + '/api/search-subject?searchTerm='+search)
    			.then(resp => {
    				this.subject_list=[];
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
    		// if(result.category_id){
    		// 	this.selected_category = result.category_id;
    		// }else if(this.AuthStudent.categoryId){
    		// 	this.selected_category = this.AuthStudent.categoryId;
    		// }
    		// this.show_category = true;
    	},
    	setNewSubject(name) {
    		this.selected_subject = {
    			'id': 0,
    			'subject_name': name,
    			'category_id': '',
    		};
    	},
    	editDoubt(doubt){
    		this.edit_doubt_id = doubt.id;
    		this.doubt_question = doubt.question;
    		this.selected_subject = {
    			'id': doubt.subject_id,
    			'subject_name': doubt.subject_name,
    			'category_id': '',
    		};
    	},
    	deleteDoubt(doubtId){
    		this.axios.delete('/api/doubt/' + doubtId).then((resp)=>{
    			window.location.reload();
    		});
    	},
      
    }
};
</script>
