<template>
<div>
    <div class="avatar" v-if="post.profile_image">
    <img class="card-img-top img-responsive" v-lazy="post.profile_image" alt="Card image cap">
    </div>
    <div id="profileImage" v-if="!post.profile_image">{{ getNameImage(post.user_name)}}</div>
</div>
</template>
<style scoped>
#profileImage {
  width: 150px;
  height: 150px;
  border-radius: 50%;
  background: #512DA8;
  font-size: 35px;
  color: #fff;
  text-align: center;
  line-height: 150px;
  margin: 20px 0;
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
}
</script>