<template>
  <main class="doubt_main_page">
    <div class="container pt-100">
      <form
        class="doubt_search_box"
        @submit.prevent="searchDoubt"
      >
        <div class="row">
          <div class="col-md-8">
            <label for="doubt">Search Doubt</label>
            <input
              v-model="search_doubt"
              type="text"
              name="doubt"
              class="form-control"
              placeholder="Ask Question"
              @input="debounceSearch"
            >
            <span
              class="doubt_search_btn"
            ><button
              type="submit"
              class="btn btn-link"
            >
              <i class="fa fa-search text-black weight-400" /></button></span>
          </div>

          <div class="col-md-4">
            <button
              type="button"
              class="ask_doubt_btn"
              @click="addDoubtModal"
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
        :is-full-page="false"
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
              <div class="cat_sub_name">
                <p class="mb-0 text-muted">
                  {{ doubt.subject_name }}
                </p>
              </div>

              <div class="dashboard_post">
                <div class="avatar doubt_user_img">
                  <profile-image :post="doubt" />
                  <!-- <span>Y</span> -->
                </div>
                <div class="info-post ml-2 dash_insititue_name">
                  <p class="usernamedash mb-0 dash_user_date">
                    {{ doubt.user_name }}<span> {{ doubt.time }}</span>
                  </p>
                  <p class="usernamedash mb-0">
                    {{ doubt.inst_name }}
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
                  <p class="username">
                    {{ doubt.user_name }}
                  </p>
                  <!-- <p class="date text-muted">{{doubt.created_at}}</p> -->
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
              <div class="doubt_like_view">
                <div class="doubt_like">
                  <span
                    class="badge-text"
                  ><i class="fa fa-thumbs-up" /> {{ doubt.total_likes }}</span>
                </div>
                <div class="doubt_answer">
                  <p>
                    <router-link :to="'/doubt/'+doubt.id">
                      Answer
                    </router-link>
                  </p>
                </div>
              </div>
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
        name="add_doubt_modal"
        class="doubt_model"
      >
        <form @submit.prevent="addDoubt">
          <div class="model_box_inner">
            <div class="row">
              <div class="col-md-12">
                <p class="model_box_head">
                  Ask Doubt about concepts which belongs to your Course.
                  Initially this doubt will be shared with students of your
                  batch and course.
                </p>
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
              <div class="col-md-12">
                <div class="model_btn">
                  <button
                    type="submit"
                    class="ask_doubt_btn"
                  >
                    submit
                  </button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </modal>
    </div>
  </main>
</template>
<style scoped></style>
<script>
import VModal from 'vue-js-modal';
import Loading from 'vue-loading-overlay';
import AutoComplete from '../../components/AutoComplete.vue';
import ProfileImage from '../post/ProfileImage';


export default {
  	components:{
		VModal,
		Loading,
		AutoComplete,
		ProfileImage
	},
	props:['classroomId','subjectId'],
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
			selected_subject: {
				'id': null,
				'subject_name': '',
			},
		};

	},
	mounted() {
		this.getdata();
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
    		this.$modal.show('add_doubt_modal');
    	},
    	searchDoubt(){
    		this.axios.post(this.baseUrl + '/api/search-doubts/',{query:this.search_doubt})
    			.then(response => {this.doubtList = response.data.success.doubtList;});
    	},
    	addDoubt()
    	{

    		this.axios.post(this.baseUrl + '/api/add-doubt/',{
    			doubt:this.question,
    			subject:this.selected_subject,
    			classroomId:this.classroomId ?this.classroomId :''
    		} )
    			.then(resp => {

    				this.$modal.hide('add_doubt_modal');
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
    	},
    	setNewSubject(name) {
    		this.selected_subject = {
    			'id': 0,
    			'subject_name': name,
    		};
    	},
    }
};
</script>
