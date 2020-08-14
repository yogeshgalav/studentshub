<template>
   <main class="doubt_main_page">
       <div class="container pt-100">

           
               <form @submit.prevent="searchDoubt" class="doubt_search_box">
                    <div class="row">
                   <div class="col-md-8 center-col">
                       <div class="doubt_header doubt_box_page">
                        <div class="dount_search">
                        <input type="text"  name="doubt" v-model="search_doubt" class="form-control" placeholder="Ask Question">
                        <span class="doubt_search_btn"><button type="submit" class="btn btn-link"><i class=" fa fa-search text-black weight-400"></i> </button></span>
                        </div>
                        <div class="ask_btn">
                       <button type="button" @click="addDoubtModal" class="ask_doubt_btn">Ask new Doubt</button>
                   </div>
                   </div>
                   </div>
                   
                   </div>
               </form>
           
<div v-for="(doubt,index) in doubtList" :key="index">
    <div  class="row">
        <div class="col-md-8 center-col">
							<div class="doubt_lsit">
                                <div class="cat_sub_name">
                       <p class="mb-0 text-muted">{{doubt.subject_name}}</p>
            </div>

              <div class="dashboard_post">
                  <div class="avatar doubt_user_img">
                      <profile-image :post="doubt" />
                      <!-- <span>Y</span> -->
                    </div>
                    <div class="info-post ml-2 dash_insititue_name">
                      
                      <p class="usernamedash mb-0 dash_user_date">  {{doubt.user_name}}<span> {{doubt.time}}</span></p>
                      <p class="usernamedash mb-0">{{doubt.inst_name}}</p>

                    </div>   
              </div>  
									<div class="d-flex mt-2">
										<div class="avatar">
											<img v-lazy="'/images/4.jpg'" class="avatar-img rounded-circle">
										</div>
										<div class="info-post ml-2">
											<p class="username">{{doubt.user_name}}</p>
											<!-- <p class="date text-muted">{{doubt.created_at}}</p> -->
                                            <h3 class="card-title  font-size-16">
										<router-link :to="'/doubt/'+doubt.id"  class="weight-600 text-black">
											{{doubt.question}}
										</router-link>
									</h3>
                                    </div>
									</div>
                                    <div class="doubt_like_view">
										<div class="doubt_like">                                            
											<span class="badge-text"><i class="fa fa-thumbs-up"></i> {{doubt.total_likes}}</span>
										</div>
										<div class="doubt_answer">
											<p><router-link :to="'/doubt/'+doubt.id">Answer</router-link></p>
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
<slot/>
       </div>
   </main>
</template>
<script>
export default {
    data()
    {
        return {
         search_doubt:'',           
            doubtList:[],
        };

    },
    mounted() {

},
    methods:
    {
        addDoubtModal(){
            this.$modal.show('add_doubt_modal');
        },
        
    }

}
</script>