<template>
  <main>
    <explore-carousal-post />
    <category-filter :categories="categories" />  
    <site-footer />
  </main>
</template>
<script>
import {mapState} from 'vuex';
import CategoryFilter from '../category/CategoryFilter';
import ExploreCarousalPost from '../post-containers/ExploreCarousalPost';
import SiteFooter from '../footer/SiteFooter';
 
export default {
	components: {
		CategoryFilter,
		ExploreCarousalPost,
		SiteFooter
	},
	methods:{
		getData(){
			this.$store.dispatch('guest/getWelcomePageContent');
		}
	},
	computed:{
		...mapState({
			'categories': state=>state.guest.categories,
		}),
	},
	mounted(){
		this.getData();
	}
};
</script>

