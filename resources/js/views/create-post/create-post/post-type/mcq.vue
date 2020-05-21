<template>
<div class="mcq_page">
  <div class="row">
  <div class="col-md-6">
   <div class="form-group mcq_que">
            <label>Question</label>
            <textarea name="" id="" v-model="question"></textarea>
        </div>
  </div>
  </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Option 1:</label>
            <input type="text" class="form-control" v-model="option1"/>
        </div>
        <div class="form-group col-md-3">
            <label>Option 2:</label>
            <input type="text" class="form-control" v-model="option2"/>
        </div>
        <div class="form-group col-md-3">
            <label>Option 3:</label>
            <input type="text" class="form-control" v-model="option3"/>
        </div>
        <div class="form-group col-md-3">
            <label>Option 4:</label>
            <input type="text" class="form-control" v-model="option4"/>
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
               <textarea name="" id="" v-model="answer"></textarea>
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

export default {
  data(){
    return {
      question:'',
      option1:'',
      option2:'',
      option3:'',
      option4:'',
      correct_option:1,
      answer:'',
    };
  },
  mounted(){
	  EventBus.$on('validateStep2', () => {
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
		  EventBus.$emit('validateWizard',2,true);
	  })
  },
  methods: {
    
  }
}
</script>