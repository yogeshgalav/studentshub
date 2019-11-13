<template>
   <main>
       <div class="container">
           <div class="col-md-6 justify-content-center">
               <form @submit.prevent="addQuestion" >
                   <div class="form-group">
                       <input type="text" name="ask-question" class="form-control" placeholder="Ask Question">

                   </div>
                   <div class="form-group">
                       <button type="submit" class="btn btn-primary">Add Question</button>
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

        };

    },
    methods:
    {
        addQuestion()
        {
        this.axios.post(window.App.baseUrl+'/api/add-question/', {question: 'questionghg'})
    .then(resp => {
        
     
    })
    .catch(err => {
      reject(err)
    })
        }
    }
}
</script>
