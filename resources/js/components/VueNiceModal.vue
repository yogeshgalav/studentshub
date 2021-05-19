<template>
  <div
    :id="name"
    :ref="name"
    class="modal fade"
    role="dialog"
    tabindex="-1"
    :aria-labelledby="name"
    aria-hidden="true"
  >
    <div
      :class="['modal-dialog', size]"
    >
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header pt-3 pb-2">
          <h4 class="weight-800 font-size-18">
            {{ heading }}
          </h4>
        </div>
        <div class="modal-body add-client">
          <slot name="modalBody" />
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-primary mt-3"
            type="button"
            @click.prevent="$emit('submit')"
          >
            {{ 'Submit' }}
          </button>  <button
            ref="cancelButton"
            type="button"
            class="btn btn-white mt-3"
            data-dismiss="modal"
            @click.prevent="closeModal"
          >
            {{ 'Cancel' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.modal-dialog{
  position: absolute;
    width: 90%;
    /* margin-top: 50%; */
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
    margin: 0 !important;
}
</style>

<script>
export default {
	props:{
		name:{
			default:'',
			required:true,
		},
		heading:{
			default:'',
			required:true,
		},
		size:{
			default:'',
			required:false,
		},
	},
	data(){
	    return {
			
		};
	},
	methods:{
		closeModal(){
			this.$refs.cancelButton.click();
		}
	}
};
</script>
