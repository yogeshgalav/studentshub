<template>
<div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="font-size-40 text-black weight-800 mb-0">
                  {{ classroomDetail.name }}
                </h2>
                <p class="font-size-18 text-black mb-1">
                {{'Teacher:'+classroomDetail.teacher_name}}  
                </p>
                <span class="text-blue font-size-24 weight-800 join-id" @click="copyText">
                  {{ 'Join id' }}: {{ classroomDetail.classroom_live_id }}  
                  <span v-if="displayText"  ><i class="fa fa-check text-success font-size-15" ></i> </span>
                </span>
                <span v-if="displayText1" ><i class="fa fa-copy text-blue font-size-15" ></i> </span>
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
