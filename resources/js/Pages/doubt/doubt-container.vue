<template>
  <div>
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <div class="card mb-3 mt-2 pt-0 pb-0">
          <div class="card-body">
            <div class="row pl-3">
              <profile-image
                size="small"
                :user-name="AuthUser.full_name"
                :avatar="AuthUser.avatar_url"
              />&nbsp;&nbsp;
              {{ AuthUser.full_name }}
            </div>
            <a
              :href="'/ask-doubt'"
            > 
              <img
                src="/images/knowledge.svg"
                alt=""
              >&emsp;
              <slot name="share">Ask Your Doubt</slot> 
              &emsp;<span><i
                class="fa fa-arrow-right"
                aria-hidden="true"
              /></span>  
            </a>
          </div>
        </div>
        <div v-if="!doubts_data.length">
          <slot name="empty">
            No doubt present yet
          </slot> 
        </div>
        <div id="infinite-list">
          <div
            v-for="(doubt,index) in doubts_data"
            :key="index"
          >
            <doubt-card
              :doubt="doubt"
            />
          </div>

          <div class=" card mb-1 border-0 text-center">
            <p
              class="mb-0"
              @click="loadDoubts"
            >
              Load More...
            </p>
            <loading
              :active.sync="showLoader"
              :color="'#10069F'"
              :loader="'bars'"
              :width="250"
              :is-full-page="true"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DoubtCard from '@/Pages/doubt/DoubtCard.vue';

export default {
	components: {
		DoubtCard
	},
	props:['doubtRoute', 'params'],
	data() {
		return {
			doubts_data: [],
			showLoader: false,
			current_page: 1
		};
	},
	mounted() {
		this.loadDoubts();
	},
	methods: {
		loadDoubts(){
			const route= this.doubtRoute ? this.doubtRoute+'/doubts' : '/doubts';
			const url= new URL(this.baseUrl+'/api'+route);
			this.showLoader = true;

			this.current_page=this.current_page+1;
			url.searchParams.set('page', this.current_page);

			this.axios.get(url.toString())
				.then(resp => {
					const doubts = resp.data.success.doubts;
					this.doubts_data = this.doubts_data.concat(doubts);
					this.current_page = this.current_page;
					this.showLoader = false;
				})
				.catch(err => {
					this.showLoader = false;
				});
		}
	}
};
</script>
