<template>
  <main class="ml-2">
    <!-- <div class="container pt-100">

            <div v-for="(answer,index) in answerList" :key="index">
                <div class="row">
                    <div class="col-md-8 center-col">
                        <div class="answer_card"> 
                            <div class="anser_deails">  
                                    <div class="ans_user_img">
                                        <img v-lazy="'/images/user-img.jpg'">
                                    </div>
                                    <div class="ans_user_text ml-2">
                                        <h6 class="answer_cat"> Technology  <span>{{answer.created_at}}</span></h6>
                                        <h6>Manish Agarwal {{answer.user_name}}</h6>
                                        
                                     </div>

                            </div>
                            <div class="answer_que">
                                 <h4> What is Technology ?</h4>
                                <p class="answer_like"><i class="fa fa-thumbs-up"></i><span class="badge-text">{{answer.total_likes}}</span></p>
                            </div>         
                <form @submit.prevent="addDoubtAnswer">
                    <div class="ans_input_sec">
                    <div class="ans_input_box">
                        <input type="text" name="answer" v-model="new_answer" class="form-control"
                            placeholder="Ask Question">

                    </div>
                    <div class="ans_input_button">
                        <button type="submit" class="ans_btn">Answer this doubt</button>
                    </div>
                    </div>
                </form>  
                                        <p class="date text-muted"></p>
                                        <h3 class="card-title  font-size-16">
                                            <p class="weight-600 text-black">
                                                {{answer.answer}}
                                            </p>
                                        </h3>

                                   
                         






                           
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="divider"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                    <div class="col-md-6 ">
                        <div class="answer_card"> 
           <div class="anser_deails">  
                                    <div class="ans_user_img">
                                        <img v-lazy="'/images/user-img.jpg'">
                                    </div>
                                    <div class="ans_user_text ml-2">
                                        <h6 class="answer_cat"> Technology  <span>3 Days</span></h6>
                                        <h6>Manish Agarwal </h6>
                                  </div>
                                  

            </div>
              <div class="answer_que">
                                 <h4> What is Technology ?</h4>

                                 <h3 class="card-title  font-size-16">
                                            <p class="weight-600 text-black">
                                                Answer
                                            </p>
                                        </h3>
                                <p class="answer_like"><i class="fa fa-thumbs-up"></i><span class="badge-text">5</span></p>
                            </div>  
        </div>
           </div>

            </div>
        </div> -->
    <div class="container pt-100">
      <div class="row">
        <div class="col-md-9 center-col">
          <div class="answer_main_card"> 
            <div class="anser_deails">  
              <div class="ans_user_img">
                <img v-lazy="'/images/user-img.jpg'">
              </div>
              <div class="ans_user_text ml-2">
                <h6 class="answer_cat">
                  Technology  <span>3 Daays</span>
                </h6>
                <h6>Manish Agarwal</h6>
              </div>
            </div>
            <div class="answer_que">
              <h4 class="main_que">
                What is Technology ?
              </h4>
              <p class="answer_like">
                <i class="fa fa-thumbs-up" /> <span class="badge-text">10</span>
              </p>
            </div>
            <div class="ans_input_sec">
              <div class="ans_input_box">
                <input
                  v-model="new_answer"
                  type="text"
                  name="answer"
                  class="form-control"
                  placeholder="Answer the question"
                >
              </div>
              <div class="ans_input_button">
                <button
                  type="submit"
                  class="ans_btn"
                  @click="addDoubtAnswer()"
                >
                  Answer this doubt
                </button>
              </div>
            </div> 
          </div>
        </div> 
      </div>   
      <div class="row">
        <div class="col-md-8 center-col">
          <div class="answer_card"> 
            <div class="anser_deails">  
              <div class="ans_user_img">
                <img v-lazy="'/images/user-img.jpg'">
              </div>
              <div class="ans_user_text ml-2">
                <h6 class="answer_cat">
                  Technology  <span>3 Daays</span>
                </h6>
                <h6>Manish Agarwal</h6>
              </div>
            </div>
            <div class="answer_que">
              <h4> What is Technology ?</h4>
              <p>Answer About Question</p>
              <p class="answer_like">
                <i class="fa fa-thumbs-up" /> <span class="badge-text">10</span>
              </p>
            </div> 
          </div>
        </div> 
      </div>  
      <div class="row">
        <div class="col-md-8 center-col">
          <div class="answer_card reply_box"> 
            <div class="anser_deails">  
              <div class="ans_user_img">
                <img v-lazy="'/images/user-img.jpg'">
              </div>
              <div class="ans_user_text ml-2">
                <h6 class="answer_cat">
                  Technology  <span>3 Daays</span>
                </h6>
                <h6>Manish Agarwal</h6>
              </div>
            </div>
            <div class="answer_que">
              <h4> What is Technology ?</h4>
              <p>Answer About Question</p>
              <p class="answer_like">
                <i class="fa fa-thumbs-up" /> <span class="badge-text">10</span>
                <a href="">&nbsp; &nbsp;Reply</a>
              </p>
            </div> 
          </div>
        </div> 
      </div>  
    </div>

    <modal
      name="add_answer_modal"
      class="doubt_model"
    >
      <form @submit.prevent="addDoubt">
        <div class="model_box_inner">
          <div class="row">
            <div class="col-md-12">
              <p class="model_box_head">
                Enter your answer within 100 words.
              </p>
            </div>
            <div class="col-md-12">
              <div class="model_input">
                <label>Answer</label>
                <input
                  v-model="question"
                  class="form-control"
                  type="text"
                  placeholder="Enter Your Answer"
                >
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
import VModal from 'vue-js-modal';
export default {
	components:{
		VModal
	},
	data() {
		return {
			new_answer: '',
			answerList: [],
		};

	},
	mounted() {
		axios.get('/api/doubt/' + this.$route.params.doubtId + '/get-answers/')
			.then(response => {
				this.answerList = response.data.success.answerList;
			}); 

	},
	methods: {
		activateAnswerModal()
		{
			this.$modal.show('add_answer_modal');
		},

		addDoubtAnswer() {
			this.axios.post('/api/doubt/' + this.$route.params.doubtId + '/add-answer/', {
				answer: this.new_answer
			})
				.then(resp => {


				})
				.catch(err => {
					reject(err);
				});
		}
	}
};

</script>
