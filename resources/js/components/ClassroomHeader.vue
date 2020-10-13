<template>
<div>
    <div class="row">
       <div class="row">
            <div class="col-md-12">
            <a @click="$router.back()" class="btn btn-link ml-2 mb-2 font-size-18">
Back
                </a>
        </div>
       </div>
        <div class="col-md-12">
            <h2 class="font-size-40 text-black weight-800 mb-0 line-height-25-px">
                  {{ classroomDetail.name }}
                </h2>
                <p class="font-size-18 text-black mb-0 line-height-25-px">
                {{'Teacher:' +' '+classroomDetail.teacher_name}}  
                </p>
               
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr/>
        </div>
    </div>
    </div>
</template>
<style scoped>
.font-size-15 {
    font-size: 15px;
}
.line-height-25-px {
    line-height: 30px !important;
}
.join-id {
    cursor: copy;
}
</style>
<script>
    export default {
      data() {
          return {
               displayText: false,
                displayText1: true,

          };
      },
        mounted() {
          this.$store.dispatch('classroom/getClassroomDetail',this.$route.params.classroomId);  
        },
        computed:{
            classroomDetail(){
                return this.$store.state.classroom.classroomDetail;
            }
        },
       
        methods:{
          copyText(){
                const el = document.createElement('textarea');
                el.value = this.classroomDetail.classroom_live_id;
                document.body.appendChild(el);
                el.select();
               
                document.execCommand('copy');
                this.displayText = true;
                this.displayText1 = false;
                document.body.removeChild(el);
               
               
                
            },
            
        },
    }

</script>
