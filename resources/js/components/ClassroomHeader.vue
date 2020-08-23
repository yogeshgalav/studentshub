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
                <h3 class="text-blue font-size-24 weight-800" @click="copyText">
                  {{ 'Join id' }}: {{ classroomDetail.classroom_live_id }}
                </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr/>
        </div>
    </div>
    </div>
</template>

<script>
    export default {
      
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
                document.body.removeChild(el);
            }
        }
    }

</script>
