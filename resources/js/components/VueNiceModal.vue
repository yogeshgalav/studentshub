<template>
  <div
    :id="name"
    :ref="name"
    :class="['modal fade',fullsize ? 'modal-fullscreen' : '']"
    role="dialog"
    tabindex="-1"
    :aria-labelledby="name"
    aria-hidden="true"
  >
    <div
      :class="['modal-dialog', classes]"
    >
      <!-- Modal content-->
      <div class="modal-content">
        <!-- Modal header-->
        <div class="modal-header pt-3 pb-2">
          <h4 class="weight-800 font-size-18">
            {{ heading }}
          </h4>
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click="cancel"
          >
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <!-- Modal body-->
        <div class="modal-body add-client">
          <slot name="modalBody" />
        </div>
        <!-- Modal footer-->
        <div
          v-if="showFooter"
          class="modal-footer"
        >
          <slot name="modalFooter">
            <button
              class="btn btn-md btn-primary mt-3"
              type="button"
              @click.prevent="$emit('submit')"
            >
              {{ 'Submit' }}
            </button>  <button
              ref="cancelButton"
              type="button"
              class="btn btn-md btn-white mt-3"
              data-dismiss="modal"
              @click.prevent="closeModal"
              @click="cancel"
            >
              {{ 'Cancel' }}
            </button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.modal {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 1050;
    padding: 0 !important; /* override inline padding-right added from js */
    width: 100vw !important;
    height: 100vh !important;
    outline: 0;
  }
  @media only screen  and (max-width: 540px) {
    .modal-fullscreen {
      top: 0 !important; 
      left: 0 !important;
    }
  }
  .modal-dialog-scrollable{ /* add this if you want to use modal-dialog-scrollable */
    max-height: none !important;
  }
  .modal .modal-dialog-scrollable .modal-content {
    max-height: calc(100vh - 1rem) !important;
  }
  .modal-dialog.modal-xl {
    max-width: 100vw !important;
    margin: 0;
  }
  .modal .modal-content{
    position: relative;
    width: 100%;
    min-height: 100vh;
    border-radius: 0;
  }
/* .modal-dialog{ */
   /* position: absolute; */
    /* width: 90%;  */
    /* margin-top: 20%; */
     /* top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) !important;
    margin: 0 !important; */
/* } */
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
		classes:{
			default:'',
			required:false,
		},
		fullsize:{
			default:true,
			required:false,
		},
		showFooter:{
			default:true,
			required:false,
		},
	},
	data(){
	    return {
			
		};
	},
	methods:{
		openModal(){
			// const myModal  = document.getElementById(this.name);
			// myModal.classList.add('show');
		},
		closeModal(){
			// const myModal  = document.getElementById(this.name);
			// myModal.classList.remove('show');
			this.$refs.cancelButton.click();
		},
		cancel(){
			this.$emit('cancel');
		}
	}
};
</script>
