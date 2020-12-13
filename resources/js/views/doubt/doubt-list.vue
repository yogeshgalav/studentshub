<template>
   <main class="doubt_main_page">
       <div class="container pt-100">

           
               <form @submit.prevent="searchDoubt" class="doubt_search_box">
                    <div class="row">
                   <div class="col-md-8 center-col">
                       <div class="doubt_header doubt_box_page">
                        <div class="dount_search">
                        <input type="text"  name="doubt" @input="debounceSearch" v-model="search_doubt" class="form-control" placeholder="Ask Question">
                        <span class="doubt_search_btn"><button type="submit" class="btn btn-link"><i class=" fa fa-search text-black weight-400"></i> </button></span>
                        </div>
                        <div class="ask_btn">
                       <button type="button" @click="addDoubtModal" class="ask_doubt_btn">Ask new Doubt</button>
                   </div>
                   </div>
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
           
<div v-for="(doubt,index) in doubtList" :key="index">
    <div  class="row">
        <div class="col-md-8 center-col">
							<div class="doubt_lsit">
                                <div class="cat_sub_name">
                       <p class="mb-0 text-muted">{{doubt.subject_name}}</p>
            </div>

              <div class="dashboard_post">
                  <div class="avatar doubt_user_img">
                      <profile-image :post="doubt" />
                      <!-- <span>Y</span> -->
                    </div>
                    <div class="info-post ml-2 dash_insititue_name">
                      
                      <p class="usernamedash mb-0 dash_user_date">  {{doubt.user_name}}<span> {{doubt.time}}</span></p>
                      <p class="usernamedash mb-0">{{doubt.inst_name}}</p>

                    </div>   
              </div>  
									<div class="d-flex mt-2">
										<div class="avatar">
											<img v-lazy="'/images/4.jpg'" class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{doubt.user_name}}</p>
											<!-- <p class="date text-muted">{{doubt.created_at}}</p> -->
                                            <h3 class="card-title  font-size-16">
										<router-link :to="'/doubt/'+doubt.id"  class="weight-600 text-black">
											{{doubt.question}}
										</router-link>
									</h3>
                                    </div>
									</div>
                                    <div class="doubt_like_view">
										<div class="doubt_like">                                            
											<span class="badge-text"><i class="fa fa-thumbs-up"></i> {{doubt.total_likes}}</span>
										</div>
										<div class="doubt_answer">
											<p><router-link :to="'/doubt/'+doubt.id">Answer</router-link></p>
										</div>
									</div>
										
									

								
							</div>
						</div>
    </div>
    <div class="row">
        <div class="col-md-12">
<div class="divider"></div>
        </div>
    </div>
</div>
<modal name="add_doubt_modal" class="doubt_model">
    
        <form @submit.prevent="addDoubt">
            <div class="model_box_inner">
            <div class="row">
                <div class="col-md-12">
                  <p class="model_box_head">  Ask Doubt about concepts which belongs to your Course.
                    Initially this doubt will be shared with students of your batch and course.</p>
                </div>
            <div class="col-md-12">
                <div class="model_input">
                    <label>Doubt</label>
                    <input class="form-control" type="text" placeholder="Enter Your Doubt" v-model="question">
                </div>
            </div>
            <div class="col-md-12">
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
                    <button type="submit" class="ask_doubt_btn">submit</button>
                </div>    
            </div>
            </div>
            </div>
        </form>
    
</modal>
       </div>
   </main>
</template>
<style scoped>

</style>
<script>
import VModal from 'vue-js-modal'
import Loading from 'vue-loading-overlay';
import AutoComplete from '../../components/AutoComplete.vue';


export default {
    components:{
        VModal,
        Loading,
        AutoComplete
    },
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
            course_list: [],
			courseLoading: false,
			no_course_found: false,
			selected_course: {
				'id': null,
				'course_name': '',
				'category_id': ''
            },
            subjectLoading: false,
			selected_subject: {
				'id': null,
				'subject_name': '',
			},
        };

    },
    mounted() {
    this.getdata()

},
    methods:
    {	getFirstChar(str){
			var matches = str.match(/\b(\w)/g);
			var acronym = matches.join('');
			return acronym.toUpperCase();
		},
        getdata(){
            this.loading=true
            this.axios.get("api/get-doubts/")
    .then(response => {this.doubtList = response.data.success.doubtList;this.loading=false})

        },
        debounceSearch(event) {
      
      clearTimeout(this.debounce)
      this.debounce = setTimeout(() => {
        
        this.filterinput()
      }, 600)
    },
        
    //whenever someone enter someting in input box this function will trigger  
      filterinput()
      {
        //   let tempArr=[]
        //   if(this.search_doubt.length==0)
        //   {
        //       this.getdata()
        //   }
        //   for(let i=0;i<this.doubtList.length;i++)
        //   {
        //       let oneobj=this.doubtList[i]
        //       let objquestion=oneobj["question"]
        //      console.log(objquestion)
        //       if(this.search_doubt[0]==objquestion[0])
        //       {
        //           tempArr.push(oneobj)
        //       }
              
        //   }
        //   this.doubtList=tempArr;
        this.loading=true
        this.axios.get("api/get-doubts?search="+this.search_doubt)
            .then(response => {this.doubtList= response.data.success.doubtList;this.loading=false})
      },
        addDoubtModal(){
            this.question=this.search_doubt
            this.$modal.show('add_doubt_modal');
        },
        searchDoubt(){
            this.axios.post("api/search-doubts/",{query:this.search_doubt})
            .then(response => {this.doubtList = response.data.success.doubtList;console.log(response)})
        },
        addDoubt()
        {     
            
        this.axios.post('/api/add-doubt/',{doubt:this.question,subject:this.subject} )
    .then(resp => {
        
            this.$modal.hide('add_doubt_modal');
            this.question="";
            this.subject="";
            this.getdata()
    })
    .catch(err => {
      reject(err)
    })
        },
        getSubjects	(search) {
            console.log("Hy")
            console.log(search)
			this.selected_subject = {
				'id': null,
				'subject_name': search,
			};
			this.classroom_id = this.getFirstChar(search)+'BY'+this.getFirstChar(this.AuthUser.full_name);
			this.subjectLoading = true;
			this.axios
				.post(this.baseUrl + '/api/search-subject', {
					searchTerm: search
				})
				.then(resp => {
          this.subject_list = resp.data.success.subjects;
          this.subject_list=["Maths","Chemistry","Bio"]
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
			this.classroom_id=this.getFirstChar(result.subject_name)+'BY'+this.getFirstChar(this.AuthUser.full_name);
		},
		setNewSubject(name) {
			this.selected_subject = {
				'id': 0,
				'subject_name': name,
			};
		},
    }
}
</script>
