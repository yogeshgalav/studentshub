<template>
  <div>
    <div
      v-if="post.profile_image"
      class="avatar"
    >
      <img
        v-lazy="post.profile_image"
        class="card-img-top img-responsive"
        alt="Card image cap"
      >
    </div>
    <div
      v-if="!post.profile_image"
      id="profileImage"
    >
      {{ getNameImage(post.user_name) }}
    </div>
  </div>
</template>
<style scoped>
#profileImage {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #512DA8;
  font-size: 22px;
  color: #fff;
  text-align: center;
  line-height: 40px;
  margin: 5px 0;
}
</style>
<script>
export default {
	props:['post'],
	methods:{
		getNameImage(name){
			return name.charAt(0);
		}
	}
};
</script>