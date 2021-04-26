<template>
  <div>
    <div class="row">
      <div class="row">
        <div class="col-md-12">
          <div class="">
            <a
              class="btn btn-link ml-2 mb-2 font-size-18"
              @click="$router.back()"
            >
              <i
                class="fa fa-arrow-left"
                aria-hidden="true"
              />
              Back
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <h2 class="font-size-40 text-black weight-800 mb-2 line-height-25-px mobile-size-heading">
          {{ title ? title : classroomDetail.name }}
        </h2>       
      </div>      
      <div class="col-md-12">
        <h3
          v-if="title"
          class="font-size-18 text-black mb-0 line-height-25-px"
        >
          {{ 'Classroom:' + " "+ classroomDetail.name }}
        </h3>
        <p class="font-size-18 text-black mb-0 line-height-25-px">
          {{ 'Teacher:' +' '+classroomDetail.teacher_name }}  
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr>
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
.custom-margin {
  margin:0
}
@media only screen and (max-width: 600px) { 
  .mobile_header {
     width: 100%;
    left: 0;
    right: 0;
    position: fixed;
    z-index: 99;
    background-color: white;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
    margin-top: -26px;
    height: 40px;
}
.custom-margin {
margin-top: 3rem !important;
}

}
</style>
<script>
export default {
	props: {
		title: String
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
	mounted() {
		this.$store.dispatch('classroom/getClassroomDetail',this.$route.params.classroomId);  
	},
       
	methods:{
		copyText(){
			const el = document.createElement('textarea');
			el.value = this.classroomDetail.classroom_join_id;
			document.body.appendChild(el);
			el.select();
               
			document.execCommand('copy');
			this.displayText = true;
			this.displayText1 = false;
			document.body.removeChild(el);
               
               
                
		},
            
	},
};

</script>
