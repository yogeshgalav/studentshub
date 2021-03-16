<template>
  <main class="ml-2">
    <div class="container pt-100">
      <div class="row">
        <div class="col-md-9 center-col">
          <div class="answer_main_card"> 
            <div class="dashboard_post">
              <div
                v-if="doubt"
                class="avatar doubt_user_img"
              >
                <profile-image
                  :user-name="doubt.user_name"
                  :avatar="doubt.profile_image"
                />
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
            <div class="answer_que">
              <p class="text-muted btn-category">
                {{ doubt.subject_name }}
              </p>
              <h4 class="main_que">
                {{ doubt.question }}
              </h4>
            </div>
            <div
              v-if="!isAnswered"
              class="ans_input_sec"
            >
              <div
                v-if="!add_answer"
                class="ans_input_button"
              >
                <button
                  type="submit"
                  class="ans_btn"
                  @click="add_answer = true"
                >
                  Answer this doubt
                </button>
              </div>
              <div v-if="add_answer">
                <vue-editor
                  id="ArticleEditor"
                  v-model="new_answer"
                  :editor-options="editorSettings"
                  :height="'100%'"
                />
                <span>{{ countContent }}/100</span>&nbsp;<span class="text-danger">{{ error }}</span>
                <button
                  type="submit"
                  class="ans_btn"
                  @click="cancelAnswer"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  class="ans_btn"
                  @click="submitAnswer"
                >
                  Submit
                </button>
              </div>
            </div>
            <div
              v-for="(post,index) in posts"
              :key="index"
            >
              <doubt-card :post="post" />
            </div>
          </div>
        </div> 
      </div>
    </div>
  </main>
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

import { VueEditor,Quill } from 'vue2-editor';

import ImageResize from 'quill-image-resize-vue';
import { ImageDrop } from 'quill-image-drop-module';
Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageResize', ImageResize);
import DoubtCard from '../post/DoubtCard.vue';


export default {
	components:{
		VueEditor,
		DoubtCard,
	
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
			editorSettings: {
				modules: {
					imageDrop: true,
					imageResize: {},
				}
			},
			error:'', 
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
		countContent(){
			return this.description.toString().trim().split(/\s+/).length;
		}
	},
	mounted() {
		this.getDoubtAnswerData();
	},
	methods: {
		getDoubtAnswerData(){
      		axios.get('/api/doubt/' + this.$route.params.doubtId + '/get-answers/')
				.then(response => {
					this.doubt = response.data.success.doubt;
					this.posts = response.data.success.answerList;
					this.isAnswered = response.data.success.isAnswered;
				}); 

		},
		submitAnswer() {
			if(this.countContent<100){
				this.error='An answer should be of minimum 100 words.';
				return false;
			}
			this.axios.post('/api/doubt/' + this.$route.params.doubtId + '/add-answer/', {
				answer_html: this.new_answer,
				answer_text: this.description
			})
				.then(resp => {
					this.getDoubtAnswerData();
					this.add_answer = false;
					this.new_answer = '';
					this.error = '';
				})
				.catch(err => {
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
