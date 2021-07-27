<template>
  <div>
    <create-post-content :new-post="newPost" />
    <create-post-description :new-post="newPost" />
  </div>
</template>
<script>
import {mapState} from 'vuex';
import CreatePostContent from './create-post/create-post-content';
import CreatePostDescription from './create-post/create-post-description';

export default {
	components: {
		CreatePostContent,
		CreatePostDescription
	},
	props:['post'],
	computed:{
		...mapState({
			'newPost': state=>state.new_post,
		})
	},
};
</script>
