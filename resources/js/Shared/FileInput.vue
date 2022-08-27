<template>
  <div>
    <label
      v-if="label"
      class="form-label"
    >{{ label }}:</label>
    <div
      class="form-input p-0"
      :class="{ error: errors.length }"
    >
      <input
        ref="file"
        type="file"
        :accept="accept"
        hidden
        @change="change"
      >
      <div
        v-if="!modelValue"
        class="p-2"
      >
        <button
          style="width:30px"
          @click="browse"
        >
          <i
            class="fa fa-camera"
            aria-hidden="true"
          />
        </button>
      </div>
      <div
        v-else
        class="flex items-center justify-between p-2"
      >
        <div
          v-if="label"
          class="flex-1 pr-1"
        >
          {{ modelValue.name }} <span class="text-gray-500 text-xs">({{ filesize(modelValue.size) }})</span>
        </div>
        <button
          type="button"
          :class="buttonClass"
          @click="remove"
        >
          Remove
        </button>
      </div>
    </div>
    <div
      v-if="errors.length"
      class="form-error"
    >
      {{ errors[0] }}
    </div>
  </div>
</template>
<style scoped>
button {
  background-image: url(/images/cam-icon.webp);
  background-repeat: no-repeat;
  background-position: 50% 50%;
  border-radius: 50px;
  /* put the height and width of your image here */
  border: none;
}

button span {
  display: none;
}

</style>
<script>
export default {
	props: {
		modelValue: File,
		label: String,
		buttonClass: {
			type: String,
			default: 'px-4 py-1 text-white text-xs font-medium bg-gray-500 hover:bg-gray-700 rounded-sm',
		},
		accept: String,
		errors: {
			type: Array,
			default: () => [],
		},
	},
	emits: ['update'],
	watch: {
		modelValue(value) {
			if (!value) {
				this.$refs.file.value = '';
			}
		},
	},
	methods: {
		filesize(size) {
			var i = Math.floor(Math.log(size) / Math.log(1024));
			return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
		},
		browse() {
			this.$refs['file'].click();
		},
		change(e) {
			console.log('change');
			this.$emit('update', e.target.files[0]);
		},
		remove() {
			console.log('remove');
			this.$emit('update', null);
		},
	},
};
</script>
