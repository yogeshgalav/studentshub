<template>
  <div class="card mb-2">
    <div class="card_post">
      <div class="card-body">
        <div class="dashboard_post">
          <div>
            <p
              class="text-blue font-size-24 weight-600 mb-0 ml-2"
            >
              <span>
                {{ subject.subject_name }}
              </span>
            </p>
          </div>
        </div>
        
        <div
          v-if="AuthUser"
          class="row"
        >
          <hr>
          <div class="col-md-5 col-6"> 
            <button
              type="button"
              class="btn"
              @click="sendUserVote()"
            > 
              <p
                v-if="upvote_active"
                class="text-primary btn_sm pl-3 pr-3"
              >
                <span><i
                  class="fas fa-arrow-alt-circle-up text-primary"
                  aria-hidden="true"
                /></span>
                {{ totalUpVotes }} Upvote
              </p>
                
              <p
                v-else
              >
                <span><i
                  class="fas fa-arrow-alt-circle-up"
                  aria-hidden="true"
                /></span>
                {{ totalUpVotes?totalUpVotes:'' }}Upvote
              </p>
            </button>
          </div>
          <div class="col-md-5 col-6">
            <button
              type="button"
              class="btn"
              @click="sendUserDownVote()"
            >
              <p
                v-if="downvote_active"
                class="text-primary btn_sm pl-3 pr-3"
              >
                <span><i class="fas fa-arrow-alt-circle-down text-primary" /></span>
                {{ totalDownVotes }}  Downvote
              </p>
               
              <p
                v-else
              >
                <span><i class="fas fa-arrow-alt-circle-down" /></span>
                {{ totalDownVotes? totalDownVotes :'' }} Downvote
              </p>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
button{
    border: none;
    color: gray;
    display: flex;
    height: 25px;
	margin-bottom: 10px;
	margin-top: -10px;
    background-color: #fff;
}
.single_page_user_like{
    display: flex;
}
p{
	padding: 5px 0px;
	margin-bottom: 10px;
}
</style>
<script>
export default {
	props:['subject'],
	data() {
		return {
			upvote_active: '',
			downvote_active:'',
			totalUpVotes:0,
			totalDownVotes:0,
		};
	},
	mounted(){
		this.totalUpVotes=this.subject.total_upvotes;
		if(this.subject.myvote === 1){
			this.upvote_active = true;
		}else{
			this.upvote_active = false;
		}
		this.totalDownVotes=this.subject.total_downvotes; 
		if(this.subject.myvote === 0){
			this.downvote_active = true;
		}else{
			this.downvote_active = false;
		}
	},
	methods: {
		sendUserVote() {
			this.upvote_active = !this.upvote_active;
			if(this.downvote_active && this.upvote_active){
				this.totalDownVotes -= 1;
				this.downvote_active=false;
			}
			if(this.upvote_active ){	
				this.totalUpVotes += 1;	
			}
			else if(!this.upvote_active && this.totalUpVotes!==0){
        	this.totalUpVotes -= 1;
			}
			
			this.axios.post('/api/'+this.subject.id+'/vote',
				{
					status:'upvote',
					subject_id:this.subject_id,
				}).catch(err => {
				this.upvote_active = !this.upvote_active;	
			});

		},
		sendUserDownVote(){
			this.downvote_active = !this.downvote_active;
			if(this.downvote_active && this.upvote_active){
				this.totalUpVotes -= 1;
				this.upvote_active=false;
			}
			this.upvote_active = false;
			if(this.downvote_active ){	
        	this.totalDownVotes += 1;
			}
			else if(!this.downvote_active&& this.totalDownVotes!==0){
        	this.totalDownVotes -= 1;
			}
		

			this.axios.post('/api/'+this.subject.id+'/vote',
				{
					status:'downvote',
				}).catch(err => {
				this.downvote_active = !this.downvote_active;
			});

		}
	}
};

</script>
