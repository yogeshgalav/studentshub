<template>
  <div>
    <Head>
      <title>Home</title>
    </Head>
    <div class="row">
      <div class="col-md-10 col-12">
        <div v-if="student_submited">
          <div class="card">
            <div class="card-body">
              You can now access My Institute and My Course from sidebar. Enjoy Exploring!
            </div>
          </div>
        </div>
        <div v-if="studentDetailsRequired && !student_submited">
          <div class="card">
            <div class="card-body">
              <form>
                <div class="form-group">
                  <select-institute
                    v-model="preferred_institute"
                  />
                </div>
                <div class="form-group">
                  <select-course
                    v-model="preferred_course"
                  />
                </div>
                <button
                  type="button"
                  class="btn btn-primary"
                  @click="saveStudent"
                >
                  Submit
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <PostContainer
      share-route="/share-your-knowledge"
    />
  </div>
</template>
<script>
import PostContainer from './post-container.vue';
import SelectCourse from '@/components/SelectCourse.vue';
import SelectInstitute from '@/components/SelectInstitute.vue';

export default {
	components: {
		PostContainer,
		SelectInstitute,
		SelectCourse,
	},
	props:['studentDetailsRequired'],
	data(){
		return {
			preferred_institute:{
				id:null,
				name:'',
			},
			preferred_course:{
				id:null,
				course_name:'',
			},
			student_submited:false,
		};
	},
	methods:{
		saveStudent(){
			this.axios.put('/api/preferred-details',{
				preferred_institute:this.preferred_institute,
				preferred_course:this.preferred_course,
			}).then((resp)=>{
				this.student_submited = true;
			});
		}
	}
};
</script>
