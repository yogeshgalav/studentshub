<template>
   <div>
       <div class="row">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header">
                    <h4 class="mb-1">
                        {{ 'Accept Join Request' }}
                    </h4>
                </div>
                <div class="card-body">
                  <button class="btn btn-md btn-success" @click="acceptJoinRequest"> Accept </button>
                  <button class="btn btn-md btn-danger"> Decline </button>
                </div>
            </div>
        </div>
    </div>
    </div> 
</template>
<script>
export default {
     data() {
            return {
                accepted: '',
               
            };
            
        },
             computed:{
          
            classroomDetail(){
                return this.$store.state.classroom.classroomDetail;
            }
        },
          methods: {
            acceptJoinRequest(){
                this.axios.post('/api/classroom/accept',{
                    user_id:this.classroomDetail.user_id,
                    classroom_id:this.classroomDetail.id,
                }).then((resp) => {
                    this.accepted = resp.data.success.classroom_user
                });;
                
            },
          },
     
}
</script>