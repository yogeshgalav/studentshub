<template>
  <div>
    <Head>
      <title>StudentsHub</title>
    </Head>
    <PostContainer
      share-route="/share-your-knowledge"
    />
  </div>
</template>
<script>
import PostContainer from './post-container.vue';

export default {
	components: {
		PostContainer
	}
};
</script>
