<template>
<div class="mcq_page">
  <div class="row">
  <div class="col-md-6">
   <div class="form-group mcq_que">
            <label>Question</label>
            <textarea name="" id=""></textarea>
        </div>
  </div>
  </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label>Option 1:</label>
            <input type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-3">
            <label>Option 2:</label>
            <input type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-3">
            <label>Option 3:</label>
            <input type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-3">
            <label>Option 4:</label>
            <input type="text" class="form-control"/>
        </div>
        <!-- <div class="form-group col-md-3">
            <label>Answer</label>
            <input type="text" class="form-control"/>
        </div> -->
      <div class="form-group col-md-3">
            <label>Answer</label>
            <div class="right_answer">
                <ul>
                  <li class="right_active">1</li>
                  <li>2</li>
                  <li>3</li>
                  <li>4</li>
                </ul>
            </div>  
        </div>

      </div>  
          <div class="row">
           <div class="col-md-6">
           <div class="form-group mcq_que">
               <label>Some description about answer</label>
               <textarea name="" id=""></textarea>
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
      image:''
    };
  },
  mounted(){
	  EventBus.$on('validateStep2', () => {
      const data = {image:this.image}
			this.$store.commit('set_post_document_content', data);
		  EventBus.$emit('validateWizard',2,true);
	  })
  },
  methods: {
    inputUpdate(files) {
      this.image=files[0];
    },
  }
}
</script>