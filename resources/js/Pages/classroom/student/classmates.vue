<template>
  <div>
    <Head>
      <title>Classmates</title>
    </Head>
    <div class="col-md-12">
      <h1>Classmates</h1>
    </div>
    <hr>
    <div
      v-if="AuthUser.role==='student' && !classmates.length"
      class="card mb-2 pl-3"
    >
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <p class="text-blue weight-600 mb-0">
              Ask your teachers to share Classroom Join Id with you.
            </p>
            <p class="mb-0">
              You will be able to see overall progress of classroom assignment here.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-10 col-sm-12">
      <div 
        v-for="classmate in classmates"
        :key="classmate.id"
        class="classmate-card mb-2"
      >
        <div class="row">
          <div class="text-center col-md-3">
            <div style="text-align: -webkit-center">
              <profile-image
                :user-name="classmate.user_name"
                size="large"
              />
            </div>

            <h4 class="mt-2 font-weight-normal text-muted">
              {{ classmate.user_name }}
            </h4>

            <!-- </a> -->
          </div>
          <div class="col-md-7 mt-2 mb-1">
            <div class="progress-section mb-1">
              <div class="progress-desc">
                <div class="progress-bar-haeding">
                  {{ classmate.category1.category_name }}
                </div>
                <div class="progress-bar-percent">
                  {{ classmate.category1.interest_score }}
                </div>
              </div>
              <div class="progress-bar-limit">
                <div
                  class="progress"
                  :style="'width:'+classmate.category1.interest_per+'%;background-color:'+reportColorCodes[0]+';'"
                  :background-color="reportColorCodes[0]"
                />
              </div>
            </div>
            <div class="progress-section mb-1">
              <div class="progress-desc">
                <div class="progress-bar-haeding">
                  {{ classmate.category2.category_name }}
                </div>
                <div class="progress-bar-percent">
                  {{ classmate.category2.interest_score }}
                </div>
              </div>
              <div class="progress-bar-limit">
                <div
                  class="progress"
                  :style="'width:'+classmate.category2.interest_per+'%;background-color:'+reportColorCodes[1]+';'"
                  :background-color="reportColorCodes[1]"
                />
              </div>
            </div>
            <div class="progress-section mb-1">
              <div class="progress-desc">
                <div class="progress-bar-haeding">
                  {{ classmate.category3.category_name }}
                </div>
                <div class="progress-bar-percent">
                  {{ classmate.category3.interest_score }}
                </div>
              </div>
              <div class="progress-bar-limit">
                <div
                  class="progress"
                  :style="'width:'+classmate.category3.interest_per+'%;background-color:'+reportColorCodes[2]+';'"
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.classmate-card {
    padding: 20px 10px;
}
.row {
    display: flex;
    align-items: center;
    justify-content: space-evenly;
}
.classmates-section {
    margin: auto;
}
.progress-section {
    margin: 2px 1px;
}
.progress-desc {
    display: flex;
    justify-content: space-between;
    flex-wrap: nowrap;
    align-items: center;
}
.progress-bar-limit {
    width: 100%;
    height: 10px;
    background-color: rgb(231, 231, 231);
    border-radius: 10px;
}
.progress {
    height: 100%;
}
</style>
<script>
export default {
	data(){
		return {
			classmates:[],
		};
	},
	mounted(){
		this.axios.get('/api/classmates').then(resp=>{
			let categories = resp.data.success.categories;
			this.classmates = resp.data.success.classmates;
			let classmates_interests = resp.data.success.classmates_interests;
			let interest_details = [];
			this.classmates.map(node=>{
				node['category1']=categories[0];
				node['category1']['interest_score']=0;
				node['category1']['interest_per']=0;
				node['category2']=categories[1];
				node['category2']['interest_score']=0;
				node['category2']['interest_per']=0;
				node['category3']=categories[2];
				node['category3']['interest_score']=0;
				node['category3']['interest_per']=0;
				node.total_score =classmates_interests.filter(node2=>node2.user_id===node.user_id)
					.reduce((acc,currVal)=>acc+currVal.interest_score,0);

				let interest_arr = classmates_interests.filter(node2=>node2.user_id===node.user_id)
					.sort((a,b)=>b.interest_score-a.interest_score);
				
				if(interest_arr[0]){
					node['category1']=interest_arr[0];
				  node['category1']['interest_per']=parseInt((interest_arr[0]['interest_score']/node.total_score)*100);
				} 
				if(interest_arr[1]){
					node['category2']=interest_arr[1];
				  node['category2']['interest_per']=parseInt((interest_arr[1]['interest_score']/node.total_score)*100);
				} 
				if(interest_arr[2]){
					node['category3']=interest_arr[2];
				  node['category3']['interest_per']=parseInt((interest_arr[2]['interest_score']/node.total_score)*100);
				} 
				return node;
			});
		});
	}
};
</script>
