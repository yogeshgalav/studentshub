<template>
  <div>
    <loading 
      :active.sync="showLoader"
      :color="'#10069F'"
      :width="250"
      :is-full-page="true"
    />
    <div class="container pb-100">
      <div class="row justify-content-center register">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center">
              <h3 class="weight-800 text-black font-size-18">{{ trans('Check-In') }}</h3>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
            <div class="col-md-8">
              <p>Please Authenticate yourself for Sharing Knowledge</p>
            </div>
            <div class="col-md-8">
                  <form @submit.prevent="handleSubmit">
                <div class="form-group">
                    <label> {{ trans('Institute Name') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <auto-complete
                    :items="institute_list"
                    :value="'name'"
                    :is-async="true"
                    @input="getInstitutes"
                    @selected="setInstitutes"
                    :is-loading="instituteLoading"
                    />
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                <div class="form-group">
                    <label> {{ trans('Course Name') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <auto-complete
                    :items="course_list"
                    :value="'course_name'"
                    :is-async="true"
                    @input="getCourses"
                    @selected="setCourse"
                    :is-loading="courseLoading"
                    />
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12" v-if="course_name!==''">
              <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Category of selected Course:</label>
                <select class="form-control" name="course_type" 
                  v-bind:value="selected_course['category']"
                  :disabled="selected_course.id!==0">
                    <option >Architecture</option>
                    <option >Arts</option>
                    <option >Commerce</option>
                    <option >Dental</option>
                    <option >Design</option>
                    <option >Engineering</option>
                    <option >Humanities</option>
                    <option >Law</option>
                    <option >Management</option>
                    <option >Medical</option>
                    <option >Optometry</option>
                    <option >Pharmacy</option>
                    <option >Science</option>
                </select>
            </div>
        </div>
  
                <div class="form-group" v-if="selected_course.id==0">
                    <label> {{ trans('Branch Name') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <input
                      id="branch_name"
                      type="text"
                      class="form-control"
                      name="branch_name"
                      placeholder="Enter Branch Name"
                      autofocus
                      v-validate="'required'"
                      v-model="branch_name"
                    />
                    <span class="error">{{errors.first('branch_name')}}</span>
                  </div>
                </div>

              <div class="row">
            <div class="col-md-5">
              <label
                class="text-black"
                for="event_date_input"
              >
                {{ trans('Session') }}
              </label>
              <div class="input-group-prepend ">
                <div
                  class="input-group-prepend date"
                  data-provide="datepicker"
                >
                  <span
                    id="basic-addon1"
                    class="input-group-text"
                  ><i
                    class="fa fa-calendar"
                  /></span>
                </div>
                <date-picker
                  id="event_date"
                  ref="event_date"
                  v-validate="'required'"
                  name="form_data.event_date"
                  value-type="format"
                  v-model="start_year"
                  :typeable="true"
                  :type="'year'"
                  :lang="'en'"
                  :input-attr="{id: 'event_date_input'}"
                  placeholder=""
                />
              </div>
              <span class="error">{{ formErrors('form_data.event_date') }}</span>
            </div>
            <div class="col-md-2">
              To
            </div>
            <div class="col-md-5">
              <div class="input-group-prepend ">
                <div
                  class="input-group-prepend date"
                  data-provide="datepicker"
                >
                  <span
                    id="basic-addon1"
                    class="input-group-text"
                  ><i
                    class="fa fa-calendar"
                  /></span>
                </div>
                <date-picker
                  id="event_date"
                  ref="event_date"
                  v-validate="'required'"
                  name="form_data.event_date"
                  value-type="format"
                  v-model="end_year"
                  :typeable="true"
                  :type="'year'"
                  :lang="'en'"
                  :input-attr="{id: 'event_date_input'}"
                  placeholder="Start Year"
                />
              </div>
              <span class="error">{{ formErrors('form_data.event_date') }}</span>
            </div>
            </div>
            
                <div class="form-group mb-0">
                 <button type="submit" class="btn btn-primary">{{ trans('Register') }}</button>
                </div>
              </form>
                </div>
                </div>
                </div>
                <a href="/" class="btn btn-primary">{{ trans('Skip') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.register .card {
  position: relative;
  top: 15%;
}
.register .btn {
  width: 100%;
  border-radius: 0;
}
/* enable absolute positioning */
.inner-addon {
  position: relative;
}
.register .form-control {
  height: 48px !important;
  color: #000;
  background: #eee;
  border-radius: 0;
}
/* style glyph */
.inner-addon .fa {
  position: absolute;
  padding: 18px;
  pointer-events: none;
}

/* align glyph */
.left-addon .fa {
  left: 0px;
}
.right-addon .fa {
  right: 0px;
}

/* add padding  */
.left-addon input {
  padding-left: 35px;
}

.display-flex{
  display:flex;
}
</style>
<script>
import FormMixin from "../../components/mixins/form-mixin.js";
import AutoComplete from "../../components/AutoComplete.vue";
import swal from '../../components/swal';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
  mixins: [FormMixin],
  components:{
    DatePicker,AutoComplete
  },
  data() {
    return {
      showLoader:false,
      course_list:[],
      course_id:'',
      course_name:'',
      courseLoading:false,
      institute_list:[],
      institute_id:'',
      institute_name:'',
      instituteLoading:false,
      branch_name:'',
      selected_course:'',
      selected_institute:'',
      end_year:'',
      start_year:'',
      course_type_select:false,
      dict: {
        custom: {
          institute_name: {
            required: "You must provide Institue Name to continue."
          },
        }
      }
    };
  },
  methods: {
    trans: function(string, defaultString) {
      return this.$trans("auth", string, defaultString);
    },
    getCourses(search){
      this.courseLoading=true;
				this.axios
					.post(this.baseUrl + '/api/search-course', {searchTerm: search})
					.then(resp => {
						this.course_list = resp.data.success.courses;
						this.course_list.find(node => {
							if (node.course_name.toLowerCase() === this.course_name.toLowerCase()) {
								this.course_id = node.id;
								return true;
							}
            });
            this.courseLoading=false;
					}).catch(()=>{
            this.courseLoading=false;
          });
	
    },
    setCourse(result){
      this.course_id = result.id;
			this.course_name = result.name;
      this.selected_course=this.course_list.find(node=>node.course_name===this.course_name);
    },
    getInstitutes(search){
      this.instituteLoading=true;
				this.axios
					.post(this.baseUrl + '/api/search-institute', {searchTerm: search})
					.then(resp => {
						this.institute_list = resp.data.success.institutes;
						this.institute_list.find(node => {
							if (node.name.toLowerCase() === this.institute_name.toLowerCase()) {
								this.institute_id = node.id;
								return true;
							}
            });
            this.instituteLoading=false;
					}).catch(()=>{
            this.instituteLoading=false;
          });
	
    },
    setInstitutes(result){
      this.institute_id = result.id;
			this.institute_name = result.name;
      this.selected_institute=this.institute_list.find(node=>node.name===this.institute_name);
    },
    	
    handleSubmit(e) {
      this.$validator.localize("en", this.dict);
      this.$validator.validate().then(valid => {
        if (valid) {
          this.form_errors=[];
          this.showLoader=true;
          this.register();
        }
      });
      return true;
    },
    register(){
    axios.post('/api/checkin',{
        branch:this.selected_branch,
        course:this.selected_course,
        institute:this.selected_institute,
        start_year:this.start_year,
        end_year:this.end_year,
      }).then((resp)=>{
        this.showLoader=false;
        if(resp.data.success){
          swal.successDialog('Check-In','Success!','success')
          window.location.href=resp.data.success.redirectUrl;
        }
      }).catch(()=>{
        this.showLoader=false;
      });
    },
  },
};
</script>
