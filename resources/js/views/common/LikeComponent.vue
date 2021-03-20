<template>
  <div
    v-if="AuthUser"
    class="single_page_user_like"
  >
    <button
      @click="sendUserLike()"
    >
      <p v-if="like_active">
        <span><i class="fas fa-thumbs-up" /></span>
      </p>
      <p v-else>
        <span><i class="far fa-thumbs-up" /></span>
      </p>
      <p>{{ like_active ? (post.total_likes + 1) : post.total_likes }}</p>
    </button>
    <button
      @click="sendUserDislike()"
    >
      <p v-if="dislike_active">
        <span><i class="fas fa-thumbs-down" /></span>
      </p>
      <p v-else>
        <span><i class="far fa-thumbs-down" /></span>
      </p>
      <p>{{ dislike_active ? (post.total_dislikes + 1) : post.total_dislikes }}</p>
    </button>
  </div>
</template>

<script>
export default {
	props:['post', 'likableType'],
	data(){
		return {
			user_like:'',
			like_active:false,
			dislike_active:false,
		};
	},
	watch: {
		post(val) {
			if(val.user_like === 1){
				this.like_active = true;
			}
			else if(val.user_like === 0){
				this.dislike_active = true;
			}
		}
	},
	methods:{
		sendUserLike() {
			let method = (this.like_active === true) ? 'delete' : 'add';
			this.like_active = !this.like_active;
			this.dislike_active = false;
			this.axios.post('/api/user-like/'+this.likableType, {
				likable_id: this.post.id,
				type: 'like',
				method,
			}).then(resp => {
				this.user_like = resp.data.success.user_like;
				this.like_active = this.user_like===1 ? true : false;
				this.dislike_active = this.user_like===0 ? true : false;
			}).catch(err => { 
				this.like_active = this.user_like===1 ? true : false;
				this.dislike_active = this.user_like===0 ? true : false;
			});
		},
		sendUserDislike() {
			let method = (this.dislike_active === true) ? 'delete' : 'add';
			this.dislike_active = !this.dislike_active;
			this.like_active = false;
			this.axios.post('/api/user-like/'+this.likableType, {
				likable_id: this.post.id,
				type: 'dislike',
				method,
			}).then(resp => {
				this.user_like = resp.data.success.user_like;
				this.dislike_active = this.user_like===0 ? true : false;
				this.like_active = this.user_like === 1 ? true : false;
			}).catch(err => {
				this.dislike_active = this.user_like===0 ? true : false;
				this.like_active = this.user_like === 1 ? true : false;
			});
		},
	}
};
</script>

<style>

</style>