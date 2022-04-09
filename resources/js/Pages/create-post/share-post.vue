<template>
  <section class="container">
    <div class="logn_righ ">
      <div class="card_body">
        <form @submit.prevent="()=>{}">
          <MultiStep
            ref="multiStep"
            :step-data="step_data"
            @valdiateStep="valdiateStep"
            @onComplete="onComplete"
          >
            <template slot="header">
              <div class="justify-center col-12">
                <h1>Create Post</h1>
                <p class="text-grey font-weight-18 ">
                  What was the last thing you learned from the internet?
                </p>
              </div>
            </template>
            <template slot="step0">
              <create-post-description
                v-if="post_data"
                :post="post_data"
                :categories="categories"
                :subject-info="subjectInfo"
                :course-info="courseInfo"
                @setPostDescription="setPostDescription"
              />
            </template>
            <template slot="step1">
              <create-post-content
                v-if="post_data"
                :post="post_data"
                @setPostContent="setPostContent"
              />
            </template>
            
            <template
              v-slot:footer="props"
            >
              <div class="m-0-a">
                <div class="row">
                  <button
                    v-if="!props.isFirstStep"
                    type="button"
                    class="btn btn-md btn-primary m-0-a"
                    @click="prevClick"
                  >
                    {{ 'back' }}
                  </button>
                  <button
                    type="button"
                    class="btn btn-md btn-primary m-0-a"
                    @click="nextClick"
                  >
                    {{ props.isLastStep ? 'Create Post' : 'Next' }}
                  </button>
                </div>
              </div>
            </template>
          </MultiStep>
        </form>
      </div>
    </div>
  </section>
</template>
<style>
    .wizardHeader {
        margin-left: 4rem !important;
    }

    .custom-link .btn {
        padding: 15px 0;
    }

    .vue-form-wizard .wizard-template {
        min-height: 100px;
        padding: 0px 20px 10px;
    }

    .vue-form-wizard .wizard-card-footer {
        background: #FFFFFF;
        box-shadow: 0 -2px 50px rgba(0, 0, 0, 0.15);
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 20px 20% 20px 20%;
        z-index: 300;
        left: 0;
    }

    .wizard-btn {
        border-radius: 3px;
        text-transform: uppercase;
        border: 0 !important;
        padding: 10px 0 10px 0 !important;
    }

    @media only screen and (max-width:768px) {
        .vue-form-wizard .wizard-card-footer {
            background: #FFFFFF;
            box-shadow: 0 -2px 50px rgba(0, 0, 0, 0.15);
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 20px 5% 20px 5%;
            left: 0;
        }

        .vue-form-wizard .wizard-template {
            min-height: 100px;
            padding: 30px 0px 10px;
        }

        .wizardHeader {
            margin-left: 1rem !important;
        }

        .form-control {
            font-size: 16px;
            transform-origin: top left;
            transform: scale(0.75);

        }
    }

</style>
<script>
import {mapState} from 'vuex';
import MultiStep from '@/components/VueMultiStepForm';
import CreatePostContent from './create-post/create-post-content';
import CreatePostDescription from './create-post/create-post-description';
import swal from '../../components/swal';
import EventBus from './event-bus';

export default {
	components: {
		MultiStep,
		CreatePostContent,
		CreatePostDescription
	},
	props:['categories', 'courseInfo', 'subjectInfo', 'post'],
	data() {
		return {
			step_data: [
				{
					'step_valid': false,
					'step_skip': false,
					'show_back_button': false,
					'show_next_button': true,
					'last_step': false,
				},
				{
					'step_valid': false,
					'step_skip': false,
					'show_back_button': true,
					'show_next_button': true,
					'last_step': true,
				},
			],
			post_data:null,
			post_submited:false,
		};
	},
	mounted() {

		let subjectInfo = null;
		if(this.subjectInfo){
			subjectInfo = Object.assign(this.subjectInfo.subject_name,{
				text:this.subjectInfo.subject_name
			});
		}
		//set post data
		if(this.post){
			this.post_data = this.post;
		}else{
			this.post_data ={
				heading:'',
				category_id:7,
				subjects: this.subjectInfo ? [subjectInfo] : [],
				course: this.courseInfo ? this.courseInfo : null,
				html_content:'',
				text_content:'',
			};
		}

		//validate step
		EventBus.$on('validateWizard',(i,valid)=>{
			if(this.step_data[i] && valid){
				this.step_data[i]['step_valid']=true;
				this.$refs.multiStep.nextStep();
			}
		});
	},
	methods: {
		valdiateStep(stepIndex){
			EventBus.$emit('validateStep'+stepIndex);
		},
		setPostDescription(data){
			this.post_data.heading=data.heading;
			this.post_data.subjects=data.subjects;
			this.post_data.category_id=data.category_id;
		},
		setPostContent(data){
			this.post_data.html_content=data.content;
			this.post_data.text_content=data.text_content;
		},
		nextClick: function (e) {
			this.$refs.multiStep.nextStep();
		},
		prevClick: function (e) {
			this.$refs.multiStep.prevStep();
		},
		onComplete() {
			if(this.post_submited){
				return false;
			}
			// let loader = this.$loading.show();
      
			this.$gtag('event',msg,{
				// 'course':this.$store.state.selected_course.course_name,
				// 'subjects':this.$store.state.selected_subjects.map(el=>el.subject_name).join(','),
			});
			let api ='/api/submit-post';
			let msg ='Post Created';
			if(this.post_data.id){
				api ='/api/post/'+this.post.id+'/update';
				msg ='Post Updated';
			}
			this.axios.post(api,this.post_data)
				.then((resp)=>{
					// loader = false;
					// swal.successDialog(msg, 'Successfully!', 'success');
					this.$inertia.visit('/post/'+resp.data.success.post_id);
				});
		}
	}
};

</script>
<style scoped>
    .label {
        display: flex;
        flex-direction: row;
        align-items: center;
    }

    .index {
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        flex-shrink: 0;
        font-size: 1.5rem;
        border-radius: 50%;
        margin-right: 0.5rem;
        align-items: center;
        justify-content: center;
        box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
    }

    .divider {
        width: 100%;
        margin-left: 0.5rem;
        border-bottom: 1px solid #ffffff;
        box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.2);
        height: 1px;
        border: 1px solid #eee;
        margin-top: 15px;
        margin-bottom: 15px;
    }

</style>
