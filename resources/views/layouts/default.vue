<script setup lang="ts">
// This is a persistent layout
// Include me with <template layout="default" />
</script>

<template>
	<header>Header Component</header>
	<section id="main">
		<section id="sidebar"></section>

		<section id="content">
			<slot />
		</section>

		<aside></aside>
	</section>
	<footer>Footer Component</footer>
</template>
