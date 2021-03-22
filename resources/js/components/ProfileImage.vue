<template>
  <div id="profileImage">
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
    <div
      v-if="!avatar"
    >
      {{ getNameImage(userName) }}
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
	props:{
		'avatar':{
			type:String,
			default:'',
			required:false,
		},
		'userName':{
			type:String,
			required:true,
		},
		size:{
			type:String,
			default:'normal',
			required:false,
		}
	},
	methods:{
		getNameImage(name){
			return name.charAt(0);
		}
	}
};
</script>
