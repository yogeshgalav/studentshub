<template>
  <div>
    <div
      v-for="comment in comments"
      :key="comment.id"
    >
      <div class="row mb-3">
        <div class="col-md-1 col-2 pl-0">
          <div class="avatar">
            <profile-image
              :avatar="comment.avatar_url"
              :user-name="comment.user_name"
            />
          </div>
        </div>
        <div
          class="col-md-10 col-10"
        >
          <div
            class="pl-2 pt-2 pb-2 comment-margin"
            style="background-color: #f2f2f2; border-radius: 10px;"
          >
            <h5 class="pb-0 mb-0">
              {{ comment.user_name }}
            </h5> <span>
              <div
                class="dropdown d-inline"
              >
                <button
                  id="dropdownMenuButton"
                  class="btn btn-secondary dropdown-toggle p-0"
                  type="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false"
                >
                  <i class="fas fa-ellipsis-v" />
                </button>
                <div
                  class="dropdown-menu dropdown-menu-right"
                  style="min-width: max-content;"
                  aria-labelledby="dropdownMenuButton"
                >
                  <button
                    type="button"
                    class="dropdown-item"
                    data-toggle="modal"
                    data-target="#addHomeworkModal"
                    @click="editComment(comment)"
                  >Edit</button> 
                  <button
                    type="button"
                    class="dropdown-item"
                    @click="deleteComment(comment.id)"
                  >Delete</button>
                </div>
              </div>
            </span>
            <p class="mb-0">
              {{ comment.comment_text }}
            </p>
          </div>
        </div>
      </div>
    </div>
    <div
      class="row mt-2"
    >
      <div
        class="col-md-1 col-2 pl-0"
      >
        <div class="avatar">
          <profile-image
            :avatar="AuthUser.avatar_url"
            :user-name="AuthUser.full_name"
          />
        </div>
      </div>
      <div
        class="col-md-10 col-10"
      >
        <h5 class="comment-user-name pb-0 mb-0">
          {{ AuthUser.full_name }}
        </h5>
        <div class="comment-margin  d-flex">
          <input
            id="comment-input"
            v-model="comment_text"
            type="text"
            placeholder="Comment here"
            class="mt-1 pl-2 message-comment"
            @keyup.enter="savecomment($event, message)"
          >

          <div @click="savecomment">
            <i
              class="far fa-paper-plane mt-1"
              style="font-size: 25px; color: gray; cursor: pointer;"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.message-comment, .message-comment:focus{
  width:100%;
  border-radius: 20px; 
  border: none !important; 
  outline: none; 
  background-color: #f0f2f5;
}
.comment-body{
  margin-left: 15px;
}
.comment-margin{
  margin-left: -25px;
}
.comment-user-name{
  margin-left: -20px;
}
</style>
<script>
export default {
	props:{
		'commentableId':{
			'type':Number,
			'required':true,
		},
		'commentableType':{
			'type':String,
			'required':true,
		},
	},
	data(){
		return {
			comments:[],
			comment_text:'',
		};
	},
	mounted(){
		this.axios.get('/api/'+this.commentableType+'/'+this.commentableId+'/comment')
			.then((resp) => {
				this.comments=resp.data.success.comments;
			});
	},
	methods:{

		savecomment(){
			if(!this.comment_text){
				return false;
			}
			this.axios.post('/api/comment',
				{
					'commentable_id':this.commentableId,
					'commentable_type':this.commentableType,
					'comment_text': this.comment_text,
				}).then((resp)=>{
				this.comments.push({
					'id':resp.data.success.comment_id,
					'user_name':this.AuthUser.full_name,
					'avatar_url':this.AuthUser.avatar_url,
					'comment_text':this.comment_text,
					'time':'Just now'});
				this.comment_text = ''; 
			});
				
		},
		deleteComment(commentId){
    		this.axios.delete('/api/comment-delete/' + commentId).then((resp)=>{
    			// window.location.reload();
    		});
    	},

	}
};
</script>