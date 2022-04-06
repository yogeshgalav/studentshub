<template>
  <main class="flex-center position-ref full-height">
    <div class="main-header">
      <Navbar />
    </div>

    <slot />
  </main>
</template>
<script>
import Navbar from '../Shared/Navbar';

export default {
	components:{
		Navbar,
	}  
};
</script>