<template>
  <main class="flex-center position-ref full-height">
    <div class="main-header">
      <Navbar />
    </div>

    <slot />

    <SiteFooter />
  </main>
</template>
<script>
import Navbar from '../Shared/Navbar';
import SiteFooter from '../Shared/SiteFooter';

export default {
	components:{
		Navbar,
    SiteFooter
	}  
};
</script>