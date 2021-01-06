<template>
<div class="mcq_page">
  <div class="row">
  <div class="col-md-6">
   <div class="form-group mcq_que">
            <label>Question</label>
            <input type="text" class="form-control" id="question" v-model="question" name="question" v-validate="'required'">
            <span class="text-danger">{{ formErrors('question') }}</span>
        </div>
  </div>
  </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Option 1:</label>
            <input type="text" class="form-control" v-model="option1" name="option_1" v-validate="'required'"/>
            <span class="text-danger">{{ formErrors('option_1') }}</span>
        </div>
        <div class="form-group col-md-3">
            <label>Option 2:</label>
            <input type="text" class="form-control" v-model="option2" name="option_2" v-validate="'required'"/>
            <span class="text-danger">{{ formErrors('option_2') }}</span>
        </div>
        <div class="form-group col-md-3">
            <label>Option 3:</label>
            <input type="text" class="form-control" v-model="option3" name="option_3" v-validate="'required'"/>
            <span class="text-danger">{{ formErrors('option_3') }}</span>
        </div>
        <div class="form-group col-md-3">
            <label>Option 4:</label>
            <input type="text" class="form-control" v-model="option4" name="option_4" v-validate="'required'"/>
            <span class="text-danger">{{ formErrors('option_4') }}</span>
        </div>
      <div class="form-group col-md-3">
            <label>Answer</label>
            <div class="right_answer">
                <ul>
                  <li v-for="num in 4" :key="num" 
                  :class="correct_option===num ? 'right_active' : ''"
                  @click="correct_option=num"
                  >{{num}}</li>
                </ul>
            </div>  
        </div>

      </div>  
          <div class="row">
           <div class="col-md-6">
           <div class="form-group mcq_que">
               <label>Some description about answer</label>
               <textarea name="answer" v-validate="'required'" id="" v-model="answer"></textarea>
               <span class="text-danger">{{ formErrors('answer') }}</span>
              </div>
          </div>
          </div>

    
</div>
</template>
<style>
.form-group.mcq_que textarea {
    width: 100%;
    border-radius: 4px;
    height: 70px;
}
.right_answer ul li {
    list-style: none;
    border: solid 1px #ccc;
    color: #868686;
    border-radius: 50px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.right_answer ul {
    display: flex;
    justify-content: space-between;
    padding: 0;
    background-color: white;
    box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 5px;
}
.right_active {
    border: solid 1px green;
    background-color: green;
 color: white !important;
}
.mcq_page .row {
    flex-direction: inherit !important;
}

</style>
<script>

import { mapState } from 'vuex'
import EventBus from '../../event-bus';
    import FormMixin from "../../../../components/mixins/form-mixin.js";

export default {
  props:['newPost'],
  mixins:[FormMixin],
  data(){
    return {
      question:this.newPost.heading,
      option1:this.newPost.mcq_option1,
      option2:this.newPost.mcq_option2,
      option3:this.newPost.mcq_option3,
      option4:this.newPost.mcq_option4,
      correct_option:this.newPost.mcq_correct_option,
      answer:this.newPost.mcq_answer,
    };
  },
  mounted(){
	  EventBus.$on('validateStep4', () => {
      this.$validator.validate().then(valid => {
        if(valid){
          const data = {
            option1:this.option1,
            option2:this.option2,
            option3:this.option3,
            option4:this.option4,
            correct_option:this.correct_option,
            answer:this.answer,
          };
          this.$store.commit('set_post_mcq_content', data);
          this.$store.commit('set_post_heading', {'post_heading':this.question});
          EventBus.$emit('validateWizard',4,true);
        }else{
          EventBus.$emit('validateWizard',4,false);
        }
      });
	  });
  },
  methods: {
    
  }
}
</script>