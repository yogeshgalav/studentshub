<template>
  <div
    v-if="AuthUser"
  >
    <button
      type="button"
      class="btn"
      @click="sendUserLike()"
    >
      <p
        v-if="like_active"
        class="text-primary pl-3 pr-3"
      >
        <span><i class="fas fa-thumbs-up text-primary" />&nbsp;</span>
        {{ totalLikes + 1 }} Like
      </p>
      <p 
        v-else-if="userLike"
        class="text-primary"
      >
        <span><i class="far fa-thumbs-up text-primary" />&nbsp;</span>
        {{ totalLikes }} Like
      </p>
      <p 
        v-else-if="totalLikes===0"
      >
        <span><i class="far fa-thumbs-up" />&nbsp;</span>
        Like
      </p>
      <p v-else>
        <span><i class="far fa-thumbs-up" />&nbsp;</span>
        {{ totalLikes }} Like
      </p>
    </button>
    <button      
      v-if="showReply"
      type="button"
      :class="['btn pl-0', reply_active ? 'text-primary' : '']"
      @click="reply()"
    >
      <p>
        <span><i
          class="far fa-comment-alt"
        />&nbsp;</span>
        Reply
      </p>
    </button>
  </div>
</template>

<script>
export default {
	props:{
		'userLike':{
			'type':Boolean,
			'required':false,
			'default':false,
		},
		'totalLikes':{
			'type':Number,
			'required':true,
			'default':0,
		},
		'likableId':{
			'type':Number,
			'required':true,
		},
		'likableType':{
			'type':String,
			'required':true,
		},
		'showReply':{
			'type':Boolean,
			'default':false,
			'required':false,
		},
	},
	data(){
		return {
			like_active:false,
			reply_active:false,
		};
	},
	methods:{
		reply(){
			this.$emit('reply');
			this.reply_active = true;
		},
		sendUserLike() {
			this.like_active = !this.like_active;
			this.axios.post('/api/user-like/'+this.likableType, {
				likable_id: this.likableId,
				likable_type: this.likableType,
			}).catch(err => {
				this.like_active = !this.like_active;
			});
		},
	}
};
</script>

<style scoped>
button{
    border: none;
    color: gray;
    display: flex;
    height: 25px;
	margin-bottom: 10px;
	margin-top: -10px;
    background-color: #fff;
}
.single_page_user_like{
    display: flex;
}
p{
	padding: 5px 0px;
	margin-bottom: 10px;
}
p:hover{
	background-color: #f0f2f5;
}


</style>
