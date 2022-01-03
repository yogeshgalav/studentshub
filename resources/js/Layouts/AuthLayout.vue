<template>
  <main class="flex-center full-height">
    <div class="header">
      <Navbar />
    </div>
    <div class="main-area">
      <div
        id="sidebar-section"
        class="sidebar-section"
      >
        <Sidebar />
      </div>
      <div class="content">
        <slot  />
      </div>
    </div>
  </main>
</template>
<script>
import Navbar from '../Shared/Navbar.vue';
import Sidebar from '../Shared/Sidebar.vue';

export default {
	components:{
		Navbar,
		Sidebar
	}  
};
</script>