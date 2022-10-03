<template>
	<div class="container max-w-full bg-slate-100">
		<div class="mx-auto flex max-w-screen-sm flex-col justify-center lg:max-w-full lg:flex-row">
			<PostCard></PostCard>
		</div>
	</div>
</template>
<script lang="ts">
import { defineComponent } from 'vue'
import PostCard from '@/views/pages/post/PostCard.vue';

export default defineComponent({
    setup() {
    },
    components: { PostCard }
})
</script>