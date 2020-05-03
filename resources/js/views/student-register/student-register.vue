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
              <p>Please Enter your Education details to avail full benifits of our platform.</p>
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
                    @selected="setInstitute"
                    @selectNew="setNewInstitute"
                    :is-loading="instituteLoading"
                    />
                    <span></span>
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                <div class="form-group">
                    <label> {{ trans('Course/Branch Name') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <auto-complete
                    :items="course_list"
                    :value="'course_name'"
                    :is-async="true"
                    @input="getCourses"
                    @selected="setCourse"
                    @selectNew="setNewCourse"
                    :is-loading="courseLoading"
                    />
                    <span v-if="selected_course.id===0">Please enter your full course name followed by branch name(if any).Please make sure that course details you are entering is correct.</span>
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12">
              <div class="form-group">
                <label for="category" >Category of selected Course:</label>
                <select name="category" id="category" 
                  v-model="selected_course.category_id"
                  :disabled="categoryDisabled">
                    <option value="">Select Category</option>
                    <option value="1">Technology</option>
                    <option value="2">Management</option>
                    <option value="3">Healthcare</option>
                    <option value="4">Arts</option>
                    <option value="5">Science</option>
                    <option value="6">Economics</option>
                    <option value="7">Education</option>
                    <option value="8">Pharmacy</option>
                    <option value="9">Journalism</option>
                    <option value="10">Humanity</option>
                    <option value="11">Hospitality</option>
                    <option value="12">Fashion</option>
                    <option value="13">Computer</option>
                </select>
            </div>
        </div>

              <div class="row">
            <div class="col-md-5">
              <label
                class="text-black"
                for="event_date_input"
              >
                {{ trans('Session of this Batch') }}
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
            <!-- <div class="row">
            <div class="col-md-5">
              <input type="checkbox" v-model="is_prefferred">
              <label>Is this your prefferred Batch and category</label>
            </div>
            </div> -->
            <div class="row">
            <div class="col-md-8 form-group">
              <label for="college_id">Unique College Id/Registation no.</label>
              <input type="text" v-model="college_id" id="college_id">
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
      courseLoading:false,
      categoryDisabled:true,
      institute_list:[],
      instituteLoading:false,
      selected_course:{'id':null,'course_name':'','category_id':''},
      selected_institute:{'id':null,'name':name,'place_id':'','address':'','description':''},
      end_year:'',
      start_year:'',
      is_prefferred:true,
      college_id:'',
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
      this.selected_course={'id':null,'course_name':search,'category_id':''};
      this.courseLoading=true;
				this.axios
					.post(this.baseUrl + '/api/search-course', {searchTerm: search})
					.then(resp => {
						this.course_list = resp.data.success.courses;
						this.course_list.find(node => {
							if (node.course_name.toLowerCase() === this.selected_course.course_name.toLowerCase()) {
								this.selected_course = node;
								return true;
							}
            });
            this.courseLoading=false;
					}).catch(()=>{
            this.courseLoading=false;
          });
	
    },
    setCourse(result){
      this.selected_course=result;
    },
    setNewCourse(name){
      this.selected_course={'id':0,'course_name':name,'category_id':0};
      this.categoryDisabled=false;
    },
    getInstitutes(search){
      this.selected_institute={'id':null,'name':search,'place_id':'','address':'','description':''};
      this.instituteLoading=true;
				this.axios
					.post(this.baseUrl + '/api/search-institute', {searchTerm: search})
					.then(resp => {
						this.institute_list = resp.data.success.institutes;
						this.institute_list.find(node => {
							if (node.name.toLowerCase() === this.selected_institute.name.toLowerCase()) {
								this.institute_id = node.id;
								return true;
							}
            });
            this.instituteLoading=false;
					}).catch(()=>{
            this.instituteLoading=false;
          });
	
    },
    setInstitute(result){
      this.selected_institute=result;
    },
    setNewInstitute(name){
      this.selected_institute={'id':0,'name':name};
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
        course_id:this.selected_course.id,
        course_name:this.selected_course.course_name,
        category_id:this.selected_course.category_id,
        institute_name:this.selected_institute.name,
        institute_place_id:this.selected_institute.place_id,
        institute_address:this.selected_institute.address,
        institute_description:this.selected_institute.description,
        is_prefferred:this.is_prefferred,
        college_id:this.college_id,
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
