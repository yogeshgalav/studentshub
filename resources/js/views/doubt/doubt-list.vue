<template>
   <main>
       <div class="container">
           <div class="row">
               <form @submit.prevent="addDoubt"  >
                   <div class="col-md-8 form-group">
                       <input type="text"  name="doubt" v-model="new_doubt" class="form-control" placeholder="Ask Question">

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
         new_doubt:'',
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
        addDoubt()
        {     
        this.axios.post('/api/add-doubt/',{doubt:this.new_doubt,doubt_type:this.new_doubt_type} )
    .then(resp => {
        
     
    })
    .catch(err => {
      reject(err)
    })
        }
    }
}
</script>
