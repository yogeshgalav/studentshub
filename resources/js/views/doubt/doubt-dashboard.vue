
<template>
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
              Initially this doubt will be shared with students of your batch and course.
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
          <div class="col-md-12">
            <div class="model_input">
              <label>Subject</label>
              <input
                v-model="subject"
                class="form-control"
                type="text"
                placeholder="Enter Your Subject"
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
</template>
<script>
import VModal from 'vue-js-modal';

export default {
	components:{
		VModal
	},
	data(){
		return {
			question:'',
			subject:'',
			new_doubt_type:'batch',
		};
	}
};

</script>
