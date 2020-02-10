<template>
   <main>
       <div class="container">
           
<div v-for="(answer,index) in answerList" :key="index">
    <div  class="row">
        <div class="col-md-9">
							<div class="card-post">
						<div>
									<div class="d-flex mt-2">
										<div class="avatar">
											<img v-lazy="'/images/4.jpg'" class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{answer.user_name}}</p>
											<p class="date text-muted">{{answer.created_at}}</p>
                                            <h3 class="card-title  font-size-16">
										<p  class="weight-600 text-black">
											{{answer.answer}}
										</p>
									</h3>
                                    <div class="row">
										<div class="col-md-6">
											<i class="fa fa-thumbs-up"></i>
											<span class="badge-text">{{answer.total_likes}}</span>
										</div>
									</div>
										</div>
									</div>

									
								
									

                                   
								</div>
							</div>
						</div>
    </div>
    <div class="row">
        <div class="col-md-12">
<div class="divider"></div>
        </div>
    </div>
</div>
<div class="row">
               <form @submit.prevent="addDoubtAnswer"  >
                   <div class="col-md-8 form-group">
                       <input type="text"  name="answer" v-model="new_answer" class="form-control" placeholder="Ask Question">

                   </div>
                   <div class=" col-md-2 form-group">
                       <button type="submit" class="btn btn-primary">Answer this doubt</button>
                   </div>
               </form>
           </div>
       </div>
   </main>
</template>
<style scoped>
 
</style>
<script>
export default {
    data()
    {
        return {
         new_answer:'',           
            answerList:[],
        };

    },
    mounted() {
    axios.get('/api/doubt/'+this.$route.params.doubtId+'/get-answers/')
    .then(response => {this.answerList = response.data.success.answerList})

},
    methods:
    {
        addDoubtAnswer()
        {     
        this.axios.post('/api/doubt/'+this.$route.params.doubtId+'/add-answer/',{answer:this.new_answer} )
    .then(resp => {
        
     
    })
    .catch(err => {
      reject(err)
    })
        }
    }
}
</script>
