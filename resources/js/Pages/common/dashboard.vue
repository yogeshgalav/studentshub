<template>
  <div>
    <PostContainer />
  </div>
</template>
<script>
import PostContainer from './post-container.vue';
import AuthLayout from '@/Layouts/AuthLayout';

export default {
  layout:AuthLayout,
	components: {
		PostContainer
	}
};
</script>
