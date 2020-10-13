<template>
    <div class="row">
        <div class="col-md-12">
               <classroom-header />
        </div>
          <div class="col-md-12">
             <span class="text-blue font-size-24 weight-800 join-id line-height-25-px" @click="copyText">
                  {{ 'Join id' }}: {{ classroomDetail.classroom_live_id }}  
                  <span v-if="displayText"  ><i class="fa fa-check text-success font-size-15" ></i> </span>
                </span>
                <span v-if="displayText1" ><i class="fa fa-copy text-blue font-size-15" ></i> </span>
        </div>
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-header">
                    <h4 class="mb-1">
                        {{ 'Classroom Overview' }}
                    </h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group mb-0 row">
                            <label class="col-sm-2 col-form-label text-black font-size-14">Name
                            </label>
                            <div class="col-sm-10">
                                <div class="text-black">{{ classroomDetail.name }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 row">
                            <label class="col-sm-2 col-form-label text-black font-size-14">Subject
                            </label>
                            <div class="col-sm-10">
                                <div class="text-black">
                                    {{ classroomDetail.subject_name }} </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 row">
                            <label class="col-sm-2 col-form-label text-black font-size-14">Course
                            </label>
                            <div class="col-sm-10">
                                <div class="text-black">
                                    {{ classroomDetail.course_name }} </div>
                            </div>
                        </div>
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label text-black font-size-14">Expected
                                Students </label>
                            <div class="col-sm-3">
                                <div class="text-black"> <input type="text" class="form-control" id="expected_students">
                                </div>
                            </div>
                        </div>
                        <div class="form-group  row">
                            <label class="col-sm-2 col-form-label text-black font-size-14">Classroom
                                duration </label>
                            <div class="col-sm-3">
                                <div class="text-black"><input type="text" class="form-control" id="duration"> </div>
                            </div>
                        </div>
                        <div class="form-group mb-0 row">
                            <label class="col-sm-2 col-form-label text-black font-size-14">Total
                                Units </label>
                            <div class="col-sm-10">
                                <div class="text-black">3 </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import ClassroomHeader from '../../components/ClassroomHeader';
    export default {
        components: {
            ClassroomHeader
        },
           data() {
          return {
               displayText: false,
                displayText1: true,

          };
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
