<template>
   <main>
       <div class="container pt-100">



           
           <div class="row">
               <form @submit.prevent="addDoubtModal"  >
                   <div class="col-md-8 form-group">
                       <input type="text"  name="doubt" v-model="search_doubt" class="form-control" placeholder="Ask Question">

                   </div>
                   <div class=" col-md-2 form-group">
                       <button type="submit" class="btn btn-primary">Clear your Doubt</button>
                   </div>
               </form>
           </div>
<div v-for="(doubt,index) in doubtList" :key="index">
    <div  class="row">
        <div class="col-md-9">
							<div class="card-post">
						<div>
									<div class="d-flex mt-2">
										<div class="avatar">
											<img v-lazy="'/images/4.jpg'" class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{doubt.user_name}}</p>
											<p class="date text-muted">{{doubt.created_at}}</p>
                                            <h3 class="card-title  font-size-16">
										<router-link :to="'/doubt/'+doubt.id"  class="weight-600 text-black">
											{{doubt.question}}
										</router-link>
									</h3>
                                    <div class="row">
										<div class="col-md-4">
											<i class="fa fa-eye"></i>
											<span class="badge-text">{{doubt.total_answers}}</span>
										</div>
										<div class="col-md-6">
											<i class="fa fa-thumbs-up"></i>
											<span class="badge-text">{{doubt.total_likes}}</span>
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
<modal name="add_doubt_modal">
    <div class="row">
        <form @submit.prevent="addDoubt">
            Ask Doubt from students of your course.
            If you ask for any concept, it will increase the probability of answering it.
            <div class="col-md-12">
                <label>Doubt</label>
                <input class="form-control" type="text" v-model="question">
            </div>
            <div class="col-md-12">
                <label>Subject</label>
                <input class="form-control" type="text" v-model="subject">
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">submit</button>
            </div>
        </form>
    </div>
</modal>
       </div>
   </main>
</template>
<style scoped>
 
</style>
<script>
import VModal from 'vue-js-modal'
export default {
    components:{
        VModal
    },
    data()
    {
        return {
         search_doubt:'',
         question:'',
         subject:'',
         new_doubt_type:'batch',           
            doubtList:[],
        };

    },
    mounted() {
    axios.get("api/get-doubts/")
    .then(response => {this.doubtList = response.data.success.doubtList})

},
    methods:
    {
        addDoubtModal(){
            this.$modal.show('add_doubt_modal');
        },
        searchDoubt(){
            axios.get("api/search-doubts/")
            .then(response => {this.doubtList = response.data.success.doubtList})
        },
        addDoubt()
        {     
            
        this.axios.post('/api/add-doubt/',{doubt:this.question,subject:this.subject} )
    .then(resp => {
        
            this.$modal.hide('add_doubt_modal');
            this.question="";
            this.subject="";
    })
    .catch(err => {
      reject(err)
    })
        }
    }
}
</script>
