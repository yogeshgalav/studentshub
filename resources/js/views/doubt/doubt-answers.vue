<template>
  <div>
    <div class="row">
      <loading
        :active.sync="showLoader"
        :color="'#10069F'"
        :width="250"
        :is-full-page="true"
      />
      <div class="row">
        <div class="col-md-12">
          <div class="">
            <router-link
              v-if="AuthUser"
              class="btn btn-link ml-2 mb-2 font-size-18"
              :to="'/doubts'"
            >
              <i
                class="fa fa-arrow-left"
                aria-hidden="true"
              />
              Back
            </router-link>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h2 class="font-size-18 text-black mb-0 line-height-25-px">
          {{ doubt.category_name }}  
        </h2>
        <h1 class="font-size-24 text-black weight-800 mb-2 line-height-25-px mobile-size-heading">
          {{ doubt.question }}
        </h1>    
        <p
          class="text-blue mb-0"
        >
          <span 
            v-for="sub in doubt.subjects"
            :key="sub.id"
          >
            #{{ sub.subject_name }}
          </span>
        </p>
      </div>      
      <div class="col-md-12">
        <p class="font-size-18 text-black mb-0 line-height-25-px">
          {{ 'Asked by:' +' '+doubt.user_name }}  
        </p>
        <p class="font-size-18 text-grey mb-0 line-height-25-px">
          {{ 'Added: ' }}{{ doubt.created_at ? $dayjs(doubt.created_at).fromNow() :'' }}
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr>
      </div>
    </div>
    <div class="row">
      <div class="col-md-10">
        <accordion
          v-if="!isAnswered"
          class=" mb-2"

          title="Post Answer"
          :aria-expanded="false"
        >
          <div class="">
            <div class="col-md-12 mt-2"> 
              <div class="d-flex mb-1">
                <profile-image
                  size="small"
                  :user-name="AuthUser.full_name"
                  :avatar="AuthUser.avatar_url"
                />&nbsp;
                {{ AuthUser.full_name }}
              </div>
              <div>
                <rich-text-editor
                  id="ArticleEditor"
                  v-model="new_answer"
                />
                <span class="text-danger">{{ error }}</span>
                <div class="text-right mt-1">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    @click="submitAnswer"
                  >
                    Post Answer
                  </button>
                </div>
              </div>
            </div>
          </div>
        </accordion>
      </div>
      <div class="col-md-10">
        <div
          v-for="(post,index) in posts"
          :key="index"
        >
          <post-card
            :post="post"
            :doubt-type="true"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.answer_que p {
    color: #868686;
}
h4.main_que {
    background-color: white;
    padding: 15px 15px;
    color: #868686;
    box-shadow: 0 0 2px rgba(0,0,0,0.12);
    margin-bottom: 20px;
}
</style>
<script>
import RichTextEditor from '../../components/RichTextEditor';
import PostCard from '../post/PostCard.vue';
import Accordion from '../../components/accordion.vue';

export default {
	components:{
		PostCard,
		RichTextEditor,
		Accordion,
	},
	data() {
		return {
			doubt: {},
			isAnswered: false,
			add_answer: false,
			new_answer: '',
			posts: [],
			//
			files:[],
			error:'', 
			showLoader:false,
		};

	},
	computed:{
		description(){
			if(this.new_answer.trim()===''){
				return '';
			}
			var span= document.createElement('span');
			span.innerHTML= this.new_answer;
        
			var children= span.querySelectorAll('*');
			for(var i = 0 ; i < children.length ; i++) {
				if(children[i].textContent)
					children[i].textContent+= ' ';
				else
					children[i].innerText+= ' ';
			}
			return [span.textContent || span.innerText].toString();
		},
	},
	mounted() {
		this.getDoubtAnswerData();
	},
	methods: {
		getDoubtAnswerData(){
			this.showLoader= true;
			this.axios.get('/api/doubt/' + this.$route.params.doubtId + '/get-answers/')
				.then(response => {
					this.showLoader= false;
					this.doubt = response.data.success.doubt;
					this.posts = response.data.success.answerList;
					this.isAnswered = response.data.success.isAnswered;
				}); 

		},
		submitAnswer() {
			if(!this.description){
				this.error='Post content cannot be empty.';
				return false;
			}
			this.showLoader= true;
			this.axios.post('/api/doubt/' + this.$route.params.doubtId + '/add-answer', {
				answer_html: this.new_answer,
				answer_text: this.description
			})
				.then(resp => {
					window.location.href = this.baseUrl+'/post/'+resp.data.success.post_id;
					this.add_answer = false;
					this.new_answer = '';
					this.error = '';
				})
				.catch(err => {
					this.showLoader= false;
					reject(err);
				});
		},
		cancelAnswer(){
			this.add_answer = false;
			this.new_answer = '';
			this.error = '';
		}
	}
};

</script>
