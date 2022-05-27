<template>
  <section class="single_post">
    <div class="card mb-2">
      <div class="card_subject">
        <div class="card-body">
          <div class="row">
            <div class="col-md-8 col-12">
              <p
                class="text-blue mt-0 mb-2"
              >
                <span>
                  {{ subject.subject_name }}
                </span>
              </p>
            </div>
            <hr>
            <div>
              <button
                class="like ml-2"
                @click="sendUserVote()"
              >
                <p
                  v-if="vote_active"
                >
                  <span><i
                    class="fas fa-thumbs-up"
                    aria-hidden="true"
                  /></span>
                  {{ totalVotes }} 
                </p>
                <p
                  v-else-if="totalVotes===0"
                  class="mx-auto"
                >
                  <span><i
                    class="fas fa-thumbs-up"
                    aria-hidden="true"
                  /></span>
                </p>
                <p
                  v-else
                >
                  <span><i
                    class="fas fa-thumbs-up"
                    aria-hidden="true"
                  /></span>
                  {{ totalVotes }}
                </p>
              </button>
            </div>
            <p class="like ml-2">
              Upvote
            </p>
            <div>
              <button
                class="dislike ml-5"
                @click="sendUserDownVote()"
              >
                <p
                  v-if="downvote_active"
                  class="mx-auto"
                >
                  <span><i class="fas fa-thumbs-down" /></span>
                  {{ totalDownVotes }} 
                </p>
                <p
                  v-else-if="totalDownVotes===0"
                  class="mx-auto"
                >
                  <span><i class="fas fa-thumbs-down" /></span>
                </p>
                <p
                  v-else
                >
                  <span><i class="fas fa-thumbs-down" /></span>
                  {{ totalDownVotes }}
                </p>
              </button>
            </div>
            <p class="like ml-2">
              Downvote
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style scoped>
button.like{
	width: 30px;
	height: 30px;
	margin: 0 auto;
	border-radius: 50%;
	color: rgba(0,150,136 ,1);
	background-color:rgba(38,166,154 ,0.3);
	border-color: rgba(0,150,136 ,1);
	border-width: 1px;
	font-size: 15px;
}

button.dislike{
	width: 30px;
	height: 30px;
	margin: 0 auto;
	border-radius: 50%;
	color: rgba(255,82,82 ,1);
	background-color: rgba(255,138,128 ,0.3);
	border-color: rgba(255,82,82 ,1);
	border-width: 1px;
	font-size: 15px;
}

</style>
<script>
export default {
	props:['subject'],
	data() {
		return {
			vote_active: '',
			downvote_active:'',
			totalVotes:0,
			totalDownVotes:0,
		};
	},
	methods: {
		sendUserVote() {
			this.vote_active = !this.vote_active;
			if(this.vote_active){	
				this.totalVotes += 1;
			}
			else if(!this.vote_active){
        	this.totalVotes -= 1;
			}
			this.axios.post('/api/'+this.subject.id+'/vote').catch(err => {
				this.vote_active = !this.vote_active;
			});

		},
		sendUserDownVote(){
			this.downvote_active = !this.downvote_active;
			if(this.downvote_active){	
				this.totalDownVotes += 1;
			}
			else if(!this.vote_active){
        	this.totalDownVotes -= 1;
			}
			this.axios.post('/api/'+this.subject.id+'/vote').catch(err => {
				this.vote_active = !this.downvote_active;
			});

		}
	}
};

</script>
