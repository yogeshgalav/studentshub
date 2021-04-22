<template>
  <main class="doubt_main_page">
    <div class="container pt-100">
      <form
        class="doubt_search_box"
        @submit.prevent="searchDoubt"
      >
        <div class="row">
          <div class="col-md-8 pl-0">
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
            class="col-md-4 custom_btn pl-0"
          >
            <button
              type="button"
              data-toggle="modal"
              data-target="#addDoubtModal"
              class="btn btn-primary"
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

      <div
        v-for="(doubt,index) in doubtList"
        :key="index"
      >
        <div class="row">
          <div class="col-md-8 center-col">
            <div class="doubt_lsit">
              <div class="dashboard_post">
                <div class="avatar doubt_user_img">
                  <profile-image
                    :user-name="doubt.user_name"
                    :avatar="doubt.profile_image"
                  />
                  <!-- <span>Y</span> -->
                </div>
                <div class="info-post ml-2 dash_insititue_name">
                  <p class="usernamedash mb-0 dash_user_date">
                    {{ doubt.user_name }}<span> {{ doubt.time }}</span>
                  </p>
                  <p class="usernamedash mb-0">
                    {{ doubt.institute_name }}
                  </p>
                </div>
              </div>
              <div class="d-flex mt-2">
                <div class="avatar">
                  <img
                    v-lazy="'/images/4.jpg'"
                    class="avatar-img rounded-circle"
                  >
                </div>
                <div class="info-post ml-2">
                  <p class="text-muted btn-category">
                    {{ doubt.subject_name }}
                  </p>
                  <h3 class="card-title font-size-16">
                    <router-link
                      :to="'/doubt/'+doubt.id"
                      class="weight-600 text-black"
                    >
                      {{ doubt.question }}
                    </router-link>
                  </h3>
                </div>
              </div>
              <like-component :post="doubt" likable-type="doubt" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="divider" />
          </div>
        </div>
      </div>
      <modal
        v-if="AuthStudent"
        ref="addDoubtModal"
        name="addDoubtModal"
        heading="Ask doubt:"
        @submit="addDoubt"
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
                <div class="col-md-12">
                  <div class="model_input">
                    <label>Doubt</label>
                    <input
                      v-model="question"
                      class="form-control"
                      type="text"
                      placeholder="Enter Your Doubt"
                    >
                  </div>
                </div>
                <div
                  v-if="!subjectId"
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
                      @input="getSubjects"
                      @selected="setSubject"
                      @selectNew="setNewSubject"
                    />
                  </div>
                </div>
              </div>
            </div>
          </form>
        </template>
      </modal>
    </div>
  </main>
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
    left: 15px;
}
</style>
<script>
import Modal from '../../components/VueNiceModal.vue';
import Loading from 'vue-loading-overlay';
import AutoComplete from '../../components/AutoComplete.vue';
import LikeComponent from '../common/LikeComponent.vue';
import ProfileImage from '../../components/ProfileImage';


export default {
  	components:{
		Modal,
		Loading,
		AutoComplete,
		ProfileImage,
		LikeComponent
	},
	props:['classroomId','subjectId','categories'],
	data()
	{
		return {
			search_doubt:'',
			question:'',
			subject:'',
			new_doubt_type:'batch',
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
    		let url = this.baseUrl + '/api/get-doubts';
    		if(this.classroomId){
    			url = url+'?classroomId=' + this.classroomId;
    		}
    		this.axios.get(url)
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
    	addDoubtModal(){
    		this.question=this.search_doubt;
    		// this.$modal.show('add_doubt_modal');
    	},
    	searchDoubt(){
    		this.axios.post(this.baseUrl + '/api/search-doubts/',{query:this.search_doubt})
    			.then(response => {this.doubtList = response.data.success.doubtList;});
    	},
    	addDoubt()
    	{
    		this.axios.post(this.baseUrl + '/api/add-doubt',{
    			doubt:this.question,
    			category:this.selected_category,
    			subject:this.selected_subject,
    			classroomId:this.classroomId ?this.classroomId :''
    		} )
    			.then(resp => {
    				// this.$modal.hide('add_doubt_modal');
    				this.$refs.addDoubtModal.closeModal();
    				this.question='';
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
    			.post(this.baseUrl + '/api/search-subject', {
    				searchTerm: search
    			})
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
    }
};
</script>
