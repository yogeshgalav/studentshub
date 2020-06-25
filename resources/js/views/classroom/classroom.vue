<template>
  <div class="pt-100">
    <div class="container">
      <div class="row">
        <div class=" col-md-12">
          <div class="card-body">
            <div class="row">
              <div class="col-md-10 centerr-col">
                <h3 class="font-size-30 text-black weight-800 mb-0">
                  {{ classroomDetail.name }}
                </h3>
                <p class="font-size-14 text-black mb-1">
                  <span> {{ classroomDetail.subject_name }}  </span>
                </p>
                <h3 class="text-blue font-size-18">
                  {{ 'By ' }}: {{ classroomDetail.teacher_name }}
                </h3>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <NavTabs
                  size="large"
                  :tabs="tabs"
                  :initial-tab="initialTab"
                >
                  <template slot="tab-heading-Setup">
                    {{ 'Setup' }}
                  </template>
                  <template slot="tab-panel-Setup">
                    <div class="row">
                      <div class="col-md-12">
                     <div class="card mt-5">
                       <div class="card-body">
                            <form>
  <div class="form-group mb-0 row">
    <label  class="col-sm-2 col-form-label text-black font-size-14">Name </label>
    <div class="col-sm-10">
      <div class="text-black">{{ classroomDetail.name }} </div>
    </div>
  </div>
  <div class="form-group mb-0 row">
   <label  class="col-sm-2 col-form-label text-black font-size-14">Subject  </label>
    <div class="col-sm-10">
      <div class="text-black">{{ classroomDetail.subject_name }}  </div>
    </div>
  </div>
  <div class="form-group mb-0 row">
   <label  class="col-sm-2 col-form-label text-black font-size-14">Course </label>
    <div class="col-sm-10">
      <div class="text-black">{{ classroomDetail.course_name }}  </div>
    </div>
  </div>
  <div class="form-group mb-0 row">
   <label  class="col-sm-2 col-form-label text-black font-size-14">Total Units </label>
    <div class="col-sm-10">
      <div class="text-black">3  </div>
    </div>
  </div>
  <div class="form-group  row">
   <label  class="col-sm-2 col-form-label text-black font-size-14">Expected Students </label>
    <div class="col-sm-3">
      <div class="text-black"> <input type="text" class="form-control" id="expected_students" >  </div>
    </div>
  </div>
  <div class="form-group  row">
   <label  class="col-sm-2 col-form-label text-black font-size-14">Classroom duration </label>
    <div class="col-sm-3">
      <div class="text-black"><input type="text" class="form-control" id="duration" >  </div>
    </div>
  </div>
</form>
                       </div>
                     </div>
                        </div>
                    </div>
                  </template>
                  <template slot="tab-heading-Students">
                    {{ 'Students' }}
                  </template>
                  <template slot="tab-panel-Students">
                    
                  </template>
                </NavTabs>
              </div>
            </div>
            <div class="divider1 mt-2 mb-2" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>

</style>
<script>
import NavTabs from '../../components/NavTabs.vue';
import Accordion from '../../components/accordion.vue';
export default {
    components:{
      NavTabs,Accordion
    },
    props:['classroomDetail'],
    data(){
      return {
        tabs:['Setup','Students'],
        initialTab:'Setup'
      };
    }
}
</script>