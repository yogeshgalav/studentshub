<template>
  <main class="flex-center position-ref full-height">
    <div class="main-header">
      <Navbar />
    </div>

    <slot name="content" />
  </main>
</template>
<script>
import Navbar from './Shared/Navbar';

export default {
	components:{
		Navbar,
	}  
};
</script>