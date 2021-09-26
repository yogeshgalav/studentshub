<template>
  <div class="row">
    <div
      v-if="student_detail"
      class="col-md-12"
    >
      <h1>{{ student_detail.full_name }}</h1>
    </div>
    <div class="col-md-12">
      <nav-tabs
        :tabs="tabs"
        :initial-tab="initialTab"
      >
        <template slot="tab-heading-contact">
          {{ 'Contact details' }}
        </template>
        <template slot="tab-panel-contact">
          <div class="col-md-12">
            <div
              v-if="student_detail"
              class="card mt-2"
            >
              <div class="card-header bg-white">
                <h4 class="mb-1 mt-1">
                  {{ 'Personal details' }}
                </h4>
              </div>
              <div class="card-body">
                <div class="col-md-6 col-12">
                  <form>
                    <div class="form-group">
                      <label class="text-black font-size-14">Name
                      </label>
                      <input
                        id="full_name"
                        type="text"
                        class="form-control"
                        disabled
                        :value="student_detail.full_name"
                      >
                    </div>
                    <div class="form-group">
                      <label class="text-black font-size-14">Email
                      </label>
                      <input
                        id="email"
                        type="text"
                        class="form-control"
                        disabled
                        :value="student_detail.email"
                      >
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="card mt-2">
              <div class="card-header bg-white">
                <h4 class="mb-1 mt-1">
                  {{ 'Parent Details' }}
                </h4>
              </div>
              <div class="card-body">
                <div class="col-md-6 col-12">
                  <form>
                    <div class="form-group">
                      <label class="text-black font-size-14">Name
                      </label>
                      <input
                        id="course"
                        v-model="student_detail.parent_name"
                        type="text"
                        class="form-control"
                      >
                    </div>
                    <div class="form-group">
                      <label class="text-black font-size-14">Phone Number
                      </label>
                      <VuePhoneNumberInput
                        v-model="student_detail.parent_phone_no"
                        v-validate="{required: isPhoneRequired}"
                        fetch-country
                        name="phone"
                        placeholder="Enter parent's phone number"
                        data-vv-validate-on="handleSubmit"
                        @update="phoneEventPayload"
                      />
                    </div>
                    <div class="form-group">
                      <label class="text-black font-size-14">Email (optional)
                      </label>
                      <input
                        id="email"
                        v-model="student_detail.parent_email"
                        type="text"
                        class="form-control"
                      >
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </template>
      </nav-tabs>
    </div>
  </div>
</template>
<script>
import NavTabs from '../../components/NavTabs.vue';
import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

export default {
	components:{
		NavTabs,
		VuePhoneNumberInput
	},
	data(){
		return {
			initialTab:'contact',
			tabs:['contact'],
			student_detail:null,
			isPhoneRequired:'',
			phoneIsValid:true,
			phoneWithCode:'',
			initialPhoneState:true,
            
		};
	},

	mounted(){
		this.axios.get('/api/student/'+this.$route.params.id).then((resp)=>{
			this.student_detail = resp.data.success.student_detail;
		});
	},
	methods:{

		phoneEventPayload($event) {  
			this.phoneIsValid = $event.isValid;
			this.phoneWithCode = $event.e164;
		},
	}
};
</script>