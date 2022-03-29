<template>
  <section class="row">
    <div class="col-md-12">
      <h1>Category</h1>
    </div>
    <hr>
    <div class="col-md-10 col-sm-12">
      <div
        v-for="(interest,index) in interests"
        :key="index"
        class="interest card mb-2"
      >
        <router-link
          :href="'/category/'+interest.category_url"
          class="row"
        >
          <div class="text-center col-md-4">
            <p class="font-size-60 weight-600 text-blue percentage">
              {{ interest.percent }}%
            </p>
          </div>
          <div class="col-md-7 mt-2 mb-1">
            <p class="font-size-24 weight-400">
              {{ interest.name }}
            </p>
            <p class="text-grey action-section">
              <span>
                <i
                  class="fa fa-thumbs-up"
                  aria-hidden="true"
                />{{ interest.total_likes }} Like
              </span>
              <span> <i class="fas fa-eye" />{{ interest.total_views }} Views </span>
              <span> <i class="fas fa-share" />{{ interest.total_posts }} Share </span>
            </p>
          </div>
        </router-link>
      </div>
    </div>
  </section>
</template>
<script>
export default {
	data() {
		return {
			interests:[],
		};
	},
	mounted() {
		this.axios.get('/api/get-profile').then((resp) => {
			let total = 0;
			this.interests = resp.data.success.interests.map(node=>{
				node.total=node.total_views+(node.total_likes*3)+(node.total_posts*7);
				total += node.total;
				return node;
			}).map(node=>{
				node.percent=total>0 ? parseInt((node.total/total)*100) : 0;
				return node;
			})
				.sort((a,b)=>a.percent>b.percent ? -1 : 1);
		});
	},
};
</script>