<template>
    <div class="row">
        <div class="col-md-8"></div>
        <div class="row">
        <div class="form-group">
            <label>Question</label>
            <input type="text"/>
        </div>
        </div>
        <div class="row">
        <div class="form-group col-md-4">
            <label>Option 1:</label>
            <input type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-4">
            <label>Option 2:</label>
            <input type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-4">
            <label>Option 3:</label>
            <input type="text" class="form-control"/>
        </div>
        <div class="form-group col-md-4">
            <label>Option 4:</label>
            <input type="text" class="form-control"/>
        </div>
        </div>
        <div class="row">
        <div class="form-group">
            <label>Some description about answer</label>
            <input type="text"/>
        </div>
        </div>
    </div>
</template>
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