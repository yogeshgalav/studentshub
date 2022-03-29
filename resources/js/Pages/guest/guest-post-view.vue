<template>
  <post-view-page :role="'guest'" />
</template>
<script>
import NoSidebarLayout from '@/Layouts/NoSidebarLayout.vue';
import PostViewPage from '../post/PostViewPage';
export default {
	layout: NoSidebarLayout,
	components: {
    	PostViewPage
	},
};
</script>
