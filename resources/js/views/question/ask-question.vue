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
           <div class="row">
               <div v-for="(doubt,index) in doubtList" :key="index">
                   {{ doubt }}
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
    .then(response => {this.doubtList = response.data.doubtList})

},
    methods:
    {
        addDoubt()
        {     
        this.axios.post(window.App.baseUrl+'/api/add-doubt/',{doubt:this.new_doubt,doubt_type:this.new_doubt_type} )
    .then(resp => {
        
     
    })
    .catch(err => {
      reject(err)
    })
        }
    }
}
</script>
