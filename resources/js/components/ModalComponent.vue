<template>
  <div
    :id="name"
    class="modal fade"
    role="dialog"
  >
    <div
      class="modal__backdrop"
      @click="closeModal()"
    />

    <div class="modal__dialog">
      <div class="modal__header">
        <slot name="header" />
        <button
          type="button"
          class="btn-close"
          @click="closeModal"
        >
          x
        </button>
      </div>

      <div class="modal__body">
        <slot name="body" />
      </div>

      <div class="modal__footer">
        <slot name="footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal"
            @click="closeModal"
          >
            Close
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click="$emit('submit')"
          >
            Submit
          </button>
        </slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
	props:['name'],
	data() {
		return {
			show: false
		};
	},
	methods: {
		closeModal() {
			document.querySelector('body').classList.remove('overflow-hidden');
		},
		openModal() {
			$('#'+this.name).modal('show');
			document.querySelector('body').classList.add('overflow-hidden');
		}
	}
};
</script>


<style lang="scss" scoped>
.btn-close {
  border: none;
  font-size: 20px;
  padding: 20px;
  cursor: pointer;
  font-weight: bold;
  color: #4AAE9B;
  background: transparent;
}
.modal {
  overflow-x: hidden;
  overflow-y: auto;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  &__backdrop {
    background-color: rgba(0, 0, 0, 0.3);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
  }
  &__dialog {
    background-color: #ffffff;
    position: relative;
    width: 600px;
    margin: 50px auto;
    display: flex;
    flex-direction: column;
    border-radius: 5px;
    z-index: 2;
    @media screen and (max-width: 992px) {
      width: 90%;
    }
  }
  &__close {
    width: 30px;
    height: 30px;
  }
  &__header {
    padding: 20px 20px 10px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
  }
  &__body {
    padding: 10px 20px 10px;
    overflow: auto;
    display: flex;
    flex-direction: column;
    align-items: stretch;
  }
  &__footer {
    padding: 10px 20px 20px;
  }
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>