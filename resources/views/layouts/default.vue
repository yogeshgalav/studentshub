
<template>
	<main class="w-100% min-h-screen bg-slate-100">
		<header id="header" class="w-full bg-white">
      <Navbar></Navbar>
    </header>
  <section id="main">
  <section id="sidebar"></section>

  <section id="content">
    <slot />
  </section>

  <aside></aside>
</section>
<footer id="footer"></footer>
</main>
</template>
<script setup lang="ts">
import Navbar from './Navbar.vue';
</script>