<template>
  <div class="category_list_page">
    <div class="container">
      <div class="row">
        <div class="col-md-3 center-col">
          <div class="category_part">
            <div class="cat_head">
              <h6>Subjects</h6>
            </div> 
            <div class="cat_list">
              <p
                v-for="(subject,index) in subjects"
                :key="index"
              >
                <a :href="'/subject/'+subject.url">{{ subject.name }}</a>
              </p>
            </div>     
          </div>
        </div>
        <div class="col-md-6">
          <div
            v-for="(post,index) in posts"
            :key="index"
          >
            <post-card :post="post" />
          </div>

          <div
            v-if="posts.length" 
            class=" card mb-1 border-0 text-center"
          >
            <p
              class="mb-0"
              @click="loadPosts"
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
        <div class="col-md-3 center-col">
          <div class="category_part">
            <div class="cat_head">
              <h6>Courses</h6>
            </div> 
            <div class="cat_list">
              <p
                v-for="(course,index) in courses"
                :key="index"
              >
                <a :href="'/course/'+course.url">{{ course.name }}</a>
              </p>
            </div>     
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style  scoped>
a.btn.p-0.btn-link.font-size-12 {
    display: flex;
    align-items: center;
    margin: 4px 0;
}
.category_list_page {
    padding: 130px 0;
}

/* catergorry list css */

.cat_head {
    border-bottom: solid 1px #ccc;
    padding: 0px 0 5px;
    margin-bottom: 20px;
}

.cat_list a {
    color: black;
    font-weight: 600;
}
.cat_list a:hover
{
    text-decoration: none;
}
.cat_list {
    margin-left: 25px;
}
.cat_list p {
    /* margin: 0; */
    position: relative;
}

.cat_list p:before {
    position: absolute;
    content: '';
     background-color: #F2F2F2;
    width: 15px;
    height: 15px;
    border-radius: 50px;
    left: -25px;
    border: solid 1px #ccc;
    top: 3px;
}

</style>

<script>
import { mapState } from 'vuex';
import PostCard from '../post/PostCard.vue';

export default {
	props:['query'],
	computed: {
		...mapState({
			posts: state => state.common.dashboardPosts
		}),
		courses(){
			return this.posts.reduce((acc,currVal)=>{
				let index=acc.findIndex(node=>node.url===currVal.course_id);
				if(index=== -1){
					let new_node={};
					new_node.url=currVal.course_id;
					new_node.name=currVal.course_name;
					acc.push(new_node);  
				}
				return acc;
			},[]);
		},
		subjects(){
			return this.posts.reduce((acc,currVal)=>{
				let index=acc.findIndex(node=>node.url===currVal.subject_url);
				if(index=== -1){
					let new_node={};
					new_node.url=currVal.subject_url;
					new_node.name=currVal.subject_name;
					acc.push(new_node);  
				}
				return acc;
			},[]);
		},
	},
	components: {
		PostCard
	},
	mounted() {
		this.loadPosts();
	},
	methods:{

		loadPosts(){
			var route= '/get-posts';
			var params='';
			if(this.$route.name==='search'){
				params='query='+this.$route.query.query;
			}
			this.showLoader = true;
			this.$store.dispatch('common/getDashboardPosts',{route:route,params:params}).then(() => {
				this.showLoader = false;
			});
			return true;
		},
	},
	data() {
		return {
			showLoader: false
		};
	},
};
</script>
