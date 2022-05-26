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
            <div
              class="single_page_user_like"
            >
              <button
                @click="sendUserVote()"
              >
                <p
                  v-if="vote_active"
                  class="text-primary"
                >
                  <span><i class="fas fa-thumbs-up mx-auto" /></span>
                  {{ totalVotes }} 
                </p>
                <p
                  v-else-if="totalVotes===0"
                >
                  <span><i class="fas fa-thumbs-up mx-auto" /></span>
                </p>
                <p
                  v-else
                >
                  <span><i class="fas fa-thumbs-up" /></span>
                  {{ totalVotes }}
                </p>
              </button>
            </div>
            <p class="like">
              Upvote
            </p>
            <div
              class="single_page_user_like"
            >
              <button
                @click="sendUserDownVote()"
              >
                <span><i class="fas fa-thumbs-down" /></span>
              </button>
            </div>
            <p class="like">
              Downvote
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
	props:['subject'],
	data() {
		return {
			vote_active: '',
			totalVotes:0
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

		}
	}
};

</script>
