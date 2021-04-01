<template>
  <div
    id="profileImage"
    :class="size"
  >
    <div
      v-if="avatar"
      class="avatar"
    >
      <img
        v-lazy="avatar"
        class="card-img-top img-responsive"
        alt="Card image cap"
        style="border-radius: 50%;"
      >
    </div>
    <div v-if="!avatar">
      {{ userName | getFirstChar }}
    </div>
  </div>
</template>
<style scoped>
#profileImage {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px !important;
    margin: 0 !important;
    border-radius: 50%;
    background: #512da8;
    color: #fff;
    text-align: center;
    line-height: 40px;
}
.normal {
    width: 40px;
    height: 40px;
}
.large {
    width: 60px;
    height: 60px;
}
.small {
    width: 20px;
    height: 20px;
}
</style>
<script>
export default {
	filters: {
		getFirstChar(name) {
			return name ? name.charAt(0) : '';
		}
	},
	props: {
		avatar: {
			type: String,
			default: '',
			required: false
		},
		userName: {
			type: String,
			required: true
		},
		size: {
			type: String,
			default: 'normal',
			required: false
		}
	}
};
</script>
