<template>
  <div class="background">
    <div class="container">
      <div class="panel pricing-table">
        <div class="pricing-plan">
          <img
            src="https://s22.postimg.cc/8mv5gn7w1/paper-plane.png"
            alt=""
            class="pricing-img"
          >
          <h2 class="pricing-header">
            Accelarate
          </h2>
          <ul class="pricing-features">
            <li class="pricing-features-item">
              Daily Assignments
            </li>
            <li class="pricing-features-item">
              Student's subject report
            </li>
            <li class="pricing-features-item">
              Doubts
            </li>
          </ul>
          <span class="pricing-price">Free</span>
          <button
            type="button"
            class="pricing-button"
            @click="choosePlan('Accelarate')"
          >
            Get Started
          </button>
        </div>
      
        <div class="pricing-plan">
          <img
            src="https://s28.postimg.cc/ju5bnc3x9/plane.png"
            alt=""
            class="pricing-img"
          >
          <h2 class="pricing-header">
            Scale
          </h2>
          <ul class="pricing-features">
            <li class="pricing-features-item">
              Private branding
            </li>
            <li class="pricing-features-item">
              Notifications
            </li>
            <li class="pricing-features-item">
              Student Evaluation
            </li>
            <li class="pricing-features-item">
              Classroom Report
            </li>
            <li class="pricing-features-item">
              Teacher Report
            </li>
          </ul>
          <span class="pricing-price">$95</span>
          <button
            type="button"
            class="pricing-button is-featured"
            @click="choosePlan('scale')"
          >
            Free trial
          </button>
        </div>
      
        <div class="pricing-plan">
          <img
            src="https://s21.postimg.cc/tpm0cge4n/space-ship.png"
            alt=""
            class="pricing-img"
          >
          <h2 class="pricing-header">
            Transform
          </h2>
          <ul class="pricing-features">
            <li class="pricing-features-item">
              Comming soon.
            </li>
          </ul>
          <!-- <span class="pricing-price">$150</span> -->
          <a
            href="#/"
            class="pricing-button"
          >Free trial</a>
        </div>
      </div>
    </div>

    <modal
      name="memberModal"
      class="doubt_model"
    >
      <form @submit.prevent="memberRequest">
        <div class="model_box_inner card p-0">
          <div class="card-header">
            <div class="edit_profile_head">
              <h4>Enter Details:</h4>
            </div> 
          </div>
          <div class="row card-body">
            <div class="col-md-6 col-12">
              <div class="model_input">
                <label class="text-gray">Institute name</label>
                <input
                  v-model="institute_name"
                  v-validate="'required'"
                  name="institute_name"
                  type="text"
                  class="form-control"
                >
                <span class="error">{{ formErrors('institute_name') }}</span>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="model_input">
                <label class="text-gray">Your full name</label>
                <input
                  v-model="full_name"
                  v-validate="'required'"
                  name="full_name"
                  type="text"
                  class="form-control"
                >
                <span class="error">{{ formErrors('full_name') }}</span>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="model_input">
                <label class="text-gray">Email</label>
                <input
                  v-model="email"
                  v-validate="'required|email'"
                  name="email"
                  type="text"
                  class="form-control"
                >
                <span class="error">{{ formErrors('email') }}</span>
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="model_input">
                <label class="text-gray">Contact number</label>
                <input
                  v-model="phone_no"
                  v-validate="'required'"
                  name="phone_no"
                  type="text"
                  class="form-control"
                >
                <span class="error">{{ formErrors('phone_no') }}</span>
              </div>
            </div>
            <div class="col-md-12">
              <div class="model_btn">
                <button
                  type="submit"
                  class="btn btn-primary"
                >
                  Submit
                </button>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="$modal.hide('memberModal')"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </modal>
    <loading 
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
  </div>
</template>
<style scoped>
html {
  box-sizing: border-box;
  font-family: 'Open Sans', sans-serif;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.background {
  padding: 0 25px 25px;
  position: relative;
  width: 100%;
}

.background::after {
  content: '';
  background: #60a9ff;
  background: -moz-linear-gradient(top, #60a9ff 0%, #4394f4 100%);
  background: -webkit-linear-gradient(top, #60a9ff 0%,#4394f4 100%);
  background: linear-gradient(to bottom, #60a9ff 0%,#4394f4 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#60a9ff', endColorstr='#4394f4',GradientType=0 );
  height: 350px;
  left: 0;
  position: absolute;
  top: 0;
  width: 100%;
  z-index: 1;
}

@media (min-width: 900px) {
  .background {
    padding: 0 0 25px;
  }
}

.container {
  margin: 0 auto;
  padding: 50px 0 0;
  max-width: 960px;
  width: 100%;
}

.panel {
  background-color: #fff;
  border-radius: 10px;
  padding: 95px 25px;
  position: relative;
  width: 100%;
  z-index: 10;
}

.pricing-table {
  box-shadow: 0px 10px 13px -6px rgba(0, 0, 0, 0.08), 0px 20px 31px 3px rgba(0, 0, 0, 0.09), 0px 8px 20px 7px rgba(0, 0, 0, 0.02);
  display: flex;
  flex-direction: column;
}

@media (min-width: 900px) {
  .pricing-table {
    flex-direction: row;
  }
}

.pricing-table * {
  text-align: center;
  text-transform: uppercase;
}

.pricing-plan {
  border-bottom: 1px solid #e1f1ff;
  padding: 25px;
}

.pricing-plan:last-child {
  border-bottom: none;
}

@media (min-width: 900px) {
  .pricing-plan {
    border-bottom: none;
    border-right: 1px solid #e1f1ff;
    flex-basis: 100%;
    padding: 25px 50px;
  }

  .pricing-plan:last-child {
    border-right: none;
  }
}

.pricing-img {
  margin-bottom: 25px;
  max-width: 100%;
}

.pricing-header {
  color: #888;
  font-weight: 600;
  letter-spacing: 1px;
}

.pricing-features {
  color: #016FF9;
  font-weight: 600;
  letter-spacing: 1px;
  margin: 50px 0 25px;
}

.pricing-features-item {
  border-top: 1px solid #e1f1ff;
  font-size: 12px;
  line-height: 1.5;
  padding: 15px 0;
}

.pricing-features-item:last-child {
  border-bottom: 1px solid #e1f1ff;
}

.pricing-price {
  color: #016FF9;
  display: block;
  font-size: 32px;
  font-weight: 700;
}

.pricing-button {
  border: 1px solid #9dd1ff;
  border-radius: 10px;
  color: #348EFE;
  display: inline-block;
  margin: 25px 0;
  padding: 15px 35px;
  text-decoration: none;
  transition: all 150ms ease-in-out;
}

.pricing-button:hover,
.pricing-button:focus {
  background-color: #e1f1ff;
}

.pricing-button.is-featured {
  background-color: #48aaff;
  color: #fff;
}

.pricing-button.is-featured:hover,
.pricing-button.is-featured:active {
  background-color: #269aff;
}
</style>
<script>

import FormMixin from '../../components/mixins/form-mixin.js' ;
import swal from '../../components/swal';
import VModal from 'vue-js-modal';

export default {
	components:{
		VModal,
	},
	mixins: [FormMixin],
	data(){
		return {
			showLoader:false,
			institute_name:'',
			full_name:'',
			email:'',
			phone_no:'',
			plan:'',
		};
	},
	methods:{
		choosePlan(plan){
			this.plan = plan;
			this.$modal.show('memberModal');
		},
		memberRequest(){
			this.$validator.validate().then(valid => {
				if (valid) {
					this.$modal.hide('memberModal');
					this.showLoader = true;
					this.axios.post('/api/member-request',{
						institute_name:this.institute_name,
						full_name:this.full_name,
						email:this.email,
						phone_no:this.email,
						plan:this.email,
					}).then(()=>{
						this.showLoader =false;
						swal.infoDialog('Thank you for connecting with us.');
					});
				}
			});
		}
	}
};
</script>