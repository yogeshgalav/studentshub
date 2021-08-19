<template>
  <div class="creat_post_card img_der artical_page">
    <main>
      <div v-if="postType === 'article'">
        <blog-article :new-post="newPost" />
      </div>
      <div v-if="postType === 'fact'">
        <fact :new-post="newPost" />
      </div>
      <div v-if="postType === 'mcq'">
        <mcq :new-post="newPost" />
      </div>
      <div v-if="postType === 'video'">
        <net-video :new-post="newPost" />
      </div>
      <div v-if="postType === 'document'">
        <document :new-post="newPost" />
      </div>
    </main>
    <div class="creat_post_btn">
      <button
        type="button"
        class="btn-white btn-lg m-0-a"
        @click="prevTab"
      >
        <span><i
          class="fa fa-arrow-left"
          aria-hidden="true"
        /></span>
        &nbsp; Back
      </button>
      <button
        type="button"
        class="btn-primary btn-lg m-0-a"
        @click="nextTab"
      >
        Next &nbsp;
        <span><i
          class="fa fa-arrow-right"
          aria-hidden="true"
        /></span>
      </button>
    </div>
  </div>
</template>
<script>
import BlogArticle from './post-type/blog-article';
import Fact from './post-type/fact.vue';
import NetVideo from './post-type/video.vue';
import Document from './post-type/document-link.vue';
import Mcq from './post-type/mcq.vue';
import EventBus from '../event-bus';

export default {
	components: {
		BlogArticle,
		Document,
		Fact,
		Mcq,
		NetVideo,
		Document
	},
	props: ['newPost'],
	computed: {
		postType() {
			return this.$store.state.new_post.post_type.toLowerCase();
		}
	},
	methods: {
		nextTab() {
			EventBus.$emit('nextTab');
		},
		prevTab() {
			EventBus.$emit('prevTab');
		}
	}
};
</script>
<style scoped>
.creat_post_btn button {
    margin: 5px 0px !important;
    min-width: 40%;
}

.creat_post_btn {
    display: flex;
    align-items: center;
    flex-wrap: wrap-reverse;
    justify-content: space-between !important;
    margin: 15px auto;
}
.creat_post_card {
    padding: 20px;
    width: 100%;
}
button.btn-primary btn-lg span {
    margin: 0px 5px;
}
.creat_post_card .form-control {
    border-radius: 0;
    transform: inherit;
}
</style>
