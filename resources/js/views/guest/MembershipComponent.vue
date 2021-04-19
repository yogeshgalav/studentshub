<template>
  <div>
    <loading
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="blank" />
    <div class="p-5 container">
      <h3 class="pb-4 display-4 text-center">
        Earn more from your Students
      </h3>
      <p class="text-center">
        A new approach to LMS.
      </p>
    </div>
    <div class="container">
      <hr>
    </div>
    <div class="p-5 container">
      <h3 class="text-center pb-4 pt-4">
        Our pricing fits your strength
      </h3>
      <div class="row">
        <p class="col-12 col-sm-6">
          With StudentsHub you get more than just an assignment tool. Our reporting Platform delivers powerful analytics built on a modern data stack -- as well as embedded analytics, valuable connected services, customizable data applications, comprehensive professional services, and world-class support.
        </p>
        <p class="col-12 col-sm-6">
          StudentsHub pricing is customized for you, based on factors such as number of students and the scale of your deployment. Pricing is designed to fit Educational Institutes large and small. Sthub’s pricing specialists work directly with you to ensure the ideal pricing structure for your institute.
        </p>
      </div>
      <div class="text-center">
        <a
          
          class="demo"
          @click="scrollMeTo('requestDemo')"
        >Request a demo <i class="fas fa-arrow-right" /></a>
      </div>
    </div>
    <div class="p-5 highlighter">
      <h3 class="text-center pb-4 pt-4">
        Student's Hub is free for individual students and teachers
      </h3>
      <div class="text-center">
        <router-link
          :to="'/get-started'" 
          type="button"
          class="btn btn-outline-secondary"
        >
          Get Started &nbsp;<i class="fas fa-arrow-right" />
        </router-link>
      </div>
    </div>
    <div class="p-5 container">
      <h3 class="text-center pb-4 pt-4">
        More than just a Assignment tool, Student's Hub is a modern data platform
      </h3>
      <p>
        Student's Hub provides the foundation you need to build a data strategy to grow your Institute. With Student's Hub at the center of your data strategy, you can go beyond standard reporting (although it is great for that too). From dashboards to reporting, Student's Hub is your one-stop-shop for Assignment, analytics, visualization and data management.
      </p>
      <div>
        <h4 class="text-center pb-4 pt-4">
          What you get
        </h4>
        <div class="row">
          <div class="col-12 col-sm-6  text-center">
            <p>Student Report</p>
            <p>Teacher Report</p>
            <p>Classroom Report</p>
            <p>Batch Report</p>
          </div>
          <div class="col-12 col-sm-6 text-center">
            <p>Parent Report Notification</p>
            <p>Private branding</p>
            <p>24/7 live chat support</p>
            <p>API access</p>
          </div>
        </div>
      </div>
      <div>
        <h4 class="text-center pb-3 pt-3">
          The bottom line
        </h4>
        <p class="text-center">
          We want to help you extract more value from your data.
        </p>
        <p class="text-center">
          Plain and simple.
        </p>
      </div>
    </div>
    <div class="container">
      <hr>
    </div>
    <div class="p-5 container">
      <div>
        <h3 class="text-center p-4">
          Benefits of Using Data Analytics Tools
        </h3>
      </div>
      <div class="row">
        <div class="col-12 col-sm-4">
          <h5 class="pb-2 pt-2">
            Create a Data-Driven Decision-Making Culture
          </h5>
          <p>
            With data analytics, there’s no need to rely on blind faith when making decisions. You’ll have numbers and statistics to back up your decisions, which can lead to more successful outcomes.
          </p>
        </div>
        <div class="col-12  col-sm-4">
          <h5 class="pb-2 pt-2">
            Access Data Easier
          </h5>
          <p>
            Data analytics tools depend on the same type of technological infrastructure to capture, store and organize information, so it’s easy to find what you need.
          </p>
        </div>
        <div class="col-12 col-sm-4">
          <h5 class="pb-2 pt-2">
            Find Information More Quickly
          </h5>
          <p>
            Since your data lives in one place, there’s no need to search through dozens of files and folders to find one report, making the process much quicker.
          </p>
        </div>
      </div>
      <div class="text-center">
        <a
          
          role="button"
          class="demo"
          @click="scrollMeTo('requestDemo')"
        >Request a demo <i class="fas fa-arrow-right" /></a>
      </div>
    </div>
    <div class="container">
      <hr>
    </div>
    <div class="p-5 container">
      <div>
        <h3 class="text-center p-4">
          How does it benefit you?
        </h3>
        <div class="row p-4">
          <div class="col-12 col-sm-4">
            <h5 class="pb-2 pt-2">
              Real time analysis
            </h5>
            <p>
              Instead of waiting for exam results and conveying a single report to parents you will be able to see daily progress of your Students, Teachers and Institute. And schedule these reports to parents to keep them updated with your work. The real time data helps teachers, student and parents to take immediate action for better results.
            </p>
          </div>
          <div class="col-12 col-sm-4">
            <h5 class="pb-2 pt-2">
              Boost Enrollements
            </h5>
            <p>
              Deciding on where we pursue our education is one of the biggest decisions we make in our lives, and Students/Parents spend months — if not years — researching their options. Assembling data sets on your website is a great way to share information that your audience needs to make a decision.
            </p>
          </div>
          <div class="col-12 col-sm-4">
            <h5 class="pb-2 pt-2">
              Effective Learning
            </h5>
            <p>
              Student'sHub with help of Learning Analytics work with educational environments data, and convert their data into relevant information with the aim of improving the learning process. Learning Analytics further includes other methods, such as statistical and visualization
              tools and puts them into practice for studying their actual effectiveness on the improvement of teaching and learning.
            </p>
          </div>
        </div>
        <div class="text-center">
          <a
            
            role="button"
            class="demo"
            @click="scrollMeTo('requestDemo')"
          >Request a demo <i class="fas fa-arrow-right" /></a>
        </div>
      </div>
    </div>
    <div class="container">
      <hr>
    </div>
    <div class="p-5 container">
      <div>
        <h3 class="text-center p-4">
          Your students would love to...
        </h3>
        <div class="row p-4">
          <div class="col-12 col-sm-4">
            <h5 class="pb-2 pt-2">
              Classroom Report Analysis
            </h5>
            <p>
              Students love to see their daily progress in context with subjects and units. Furthermore, students can compare their report with their batch and can seek help from batchmates who have achieved a higher score in a particular subject or unit.
            </p>
          </div>
          <div class="col-12 col-sm-4">
            <h5 class="pb-2 pt-2">
              Ask Doubts
            </h5>
            <p>
              We don't believe in keeping any barrier to knowledge for students hence they can ask doubts not only from teachers but also from students with the same course globally over platform.
            </p>
          </div>
          <div class="col-12 col-sm-4">
            <h5 class="pb-2 pt-2">
              Find Interest field
            </h5>
            <p>
              Finding an interest field was near to impossible till now. We offer data of interest fields generated through the interaction of posts for free. Furthermore it helps institutes to decide their new course curriculum accordingly.
            </p>
          </div>
        </div>
      </div>

      <div>
        <h3 class="text-center pb-4 pt-4">
          Your teachers would love to...
        </h3>
        <div class="row p-4">
          <div class="col-12 col-sm-4">
            <h5 class=" pb-2 pt-2">
              Watch students progress
            </h5>
            <p>
              Knowing a student's weak and strong points is a key pathway for the learning process to be followed by the teacher. Knowing which students need more focus in which topic helps them achieve better classroom scores.
            </p>
          </div>
          <div class="col-12 col-sm-4">
            <h5 class=" pb-2 pt-2">
              Colleague Report Analysis
            </h5>
            <p>
              Teachers' performance has always been identified by classroom score till now. We offer a better way to visualize which teacher gets more engagement with students.And sharing report among teachers gives a competitive advantage to the institute.
            </p>
          </div>
          <div class="col-12 col-sm-4">
            <h5 class=" pb-2 pt-2">
              Share classroom message
            </h5>
            <p>
              Managing messaging for multiple batches through messaging platforms like whatsapp can be a very hard job when it comes to informative messages. Classroom messages keep the student updated with institute and classroom specific messages.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="p-5 highlighter">
      <h3 class="text-center pb-4 pt-4">
        Get more value out of your data<br>See how Institutes are making profit.
      </h3>
    </div>
    <div
      id="requestDemo"
      ref="requestDemo"
      class="p-5"
      style="background: #f6f6f6"
    >
      <h3 class="text-center mb-0 pt-4">
        Request a Demo
      </h3>
      <div class="form justify-content-center pt-4">
        <form
          class="col-md-4"
          @submit.prevent="memberRequest"
        >
          <div>
            <div class="form-group row">
              <div class="col-md-12 mb-2">
                <label
                  for="firstname"
                  class="mb-0 col-form-label text-md-right"
                >Your Name</label>
                <input
                  id="firstname"
                  ref="firstname"
                  v-model="full_name"
                  v-validate="'required|max:255'"
                  class="form-control"
                  type="name"
                  name="firstname"
                >
              </div>
              <div class="col-md-12 mb-2">
                <label
                  for="email"
                  class="mb-0 col-form-label text-md-right"
                >Email</label>
                <input
                  id="email"
                  ref="email"
                  v-model="email"
                  v-validate="'required|max:255'"
                  class="form-control"
                  type="email"
                  name="email"
                >
              </div>
              <div class="col-md-12 mb-2">
                <label
                  for="institute"
                  class="col-form-label text-md-right mb-0"
                >Institute Name</label>
                <input
                  id="institute"
                  ref="institute"
                  v-model="institute_name"
                  v-validate="'required|max:255'"
                  class="form-control"
                  type="name"
                  name="institute"
                >
              </div>
              <div class="col-md-12 mb-2">
                <label
                  for="students"
                  class="col-form-label text-md-right mb-0"
                >Number Of Students</label>
                <input
                  id="students"
                  ref="students"
                  v-model="student_number"
                  v-validate="'required|numeric'"
                  class="form-control"
                  type="number"
                  name="students"
                >
              </div>
              <div class="col-md-12 mb-2">
                <label
                  for="phone"
                  class="col-form-label text-md-right mb-0"
                >Phone Number</label>
                <input
                  id="phone"
                  ref="phone"
                  v-model="phone_number"
                  v-validate="'required|numeric'"
                  class="form-control"
                  type="tel"
                  name="phone"
                >
              </div>
              <div class="col-md-12 text-center">
                <button
                  type="submit"
                  class="btn btn-primary"
                >
                  Request a Demo
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <site-footer />
  </div>
</template>
<style scoped>
.center {
  text-align: -webkit-center;
}
.highlighter {
  background: #3c4043;
}
.highlighter h3{
  color: #fff;

}
.btn-outline-secondary {
  color: #fff;
  border-color: #fff;
}
.btn-outline-secondary:hover {
  color: #000;
  border-color: #3c4043;
}
.demo {
  text-decoration: none;
}
.demo:hover {
  cursor: pointer;
  color: purple;
  text-decoration: none;
}
</style>
<script>
import FormMixin from '../../components/mixins/form-mixin.js';
import swal from '../../components/swal';
import Modal from '../../components/VueNiceModal.vue';
import SiteFooter from '../footer/SiteFooter';

export default {
	components: {
		SiteFooter
	},
	mixins: [FormMixin],
	data() {
		return {
			showLoader: false,
			institute_name: '',
			full_name: '',
			email: '',
			phone_number: '',
			student_number: '',
		};
	},
	methods: {
		memberRequest() {
			this.$validator.validate().then((valid) => {
				if (valid) {
					this.showLoader = true;
					this.axios
						.post('/api/member-request', {
							full_name: this.full_name,
							institute_name: this.institute_name,
							email: this.email,
							phone_no: this.phone_number,
							students: this.student_number,
						})
						.then(() => {
							this.showLoader = false;
							swal.infoDialog('Thank you for connecting with us.');
						});
				}
			});
		},
		scrollMeTo(refName) {
			var element = this.$refs[refName];
			element.scrollIntoView({ behavior: 'smooth' });
			// var top = element.offsetTop;
			// window.scrollTo(0, top);
		}
	},
};
</script>
