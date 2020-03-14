<template>
  <div>
    <div class="container pb-100">
      <div class="row justify-content-center register">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header text-center">
              <h3 class="weight-800 text-black font-size-18">{{ trans('Register') }}</h3>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
            <div class="col-md-8">
                  <form @submit.prevent="handleSubmit">
                <div class="form-group">
                    <label> {{ trans('Institute Name') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <input
                      id="institute_name"
                      type="text"
                      class="form-control"
                      name="institute_name"
                      placeholder="Enter Institue Name"
                      autofocus
                      v-validate="'required'"
                      v-model="institute_name"
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
                    />
                    <!-- <select v-model="course_id" class="form-control">
                        <option v-for="course in courses" :key='course.id' :value="course.id">{{course.course_name}}</option>
                    </select> -->
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                <div class="form-group" v-if="selected_course">
                    <label> {{ trans('Category/Course Type') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <input :value="selected_course.category.name" disabled/>
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-12" v-if="course_type_select">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Discipline</label>
                <select class="form-control" id="drpDiscipline" name="course_type" required="">
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
        
        <div class="col-md-2 col-sm-4 col-xs-12" v-if="course_level_select">
            <div class="form-group institutesDropdown_slider">
                <label for="sel1" class="white_text">Program Level</label>
                <select class="form-control" id="drpProgramLevel" name="course_level" required="">
                    <option >Diploma</option>
                    <option >Dual Bachelors And Masters Degree</option>
                    <option >Dual Bachelors Degree</option>
                    <option >Dual Masters</option>
                    <option >Integrated PhD</option>
                    <option >PhD</option>
                    <option >Post Graduate (PG)</option>
                    <option >Post Graduate Diplomas</option>
                    <option >Under Graduate (UG)</option>
                </select>
            </div>
        </div>
                <div class="form-group">
                    <label> {{ trans('Branch Name') }} </label>
                  <div class="inner-addon left-addon">
                    <i class="fa fa-user"></i>
                    <auto-complete
                    :items="branch_list"
                    :value="'branch_name'"
                    :is-async="true"
                    @input="getBranches"
                    @selected="setBranch"
                    />
                    <!-- <select v-model="branch_id" class="form-control">
                        <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{branch.branch_name}}</option>
                    </select> -->
                    <span class="error">{{errors.first('institute_name')}}</span>
                  </div>
                </div>

              <div class="row">
            <div class="col-md-6 ">
              <label
                class="text-black"
                for="event_date_input"
              >
                {{ trans('Date') }}
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
            <div class="col-md-6 ">
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
      institute_name:'',
      course_list:[],
      course_id:'',
      course_name:'',
      branch_list:[],
      branch_id:'',
      branch_name:'',
      selected_course:'',
      selected_branch:'',
      end_year:'',
      start_year:'',
      course_level_select:false,
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
      // loading(true);
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
					});
	
    },
    setCourse(result){
      this.course_id = result.id;
			this.course_name = result.name;
      this.selected_course=this.course_list.find(node=>node.course_name===this.course_name);
    },
    getBranches(search){
      // loading(true);
				this.axios
					.post(this.baseUrl + '/api/search-branch', {searchTerm: search})
					.then(resp => {
						this.branch_list = resp.data.success.branches;
						this.branch_list.find(node => {
							if (node.branch_name.toLowerCase() === this.branch_name.toLowerCase()) {
								this.branch_id = node.id;
								return true;
							}
						});
					});
	
    },
    setBranch(result){
      this.branch_id = result.id;
      this.branch_name = result.name;
      this.selected_branch=this.branch_list.find(node=>node.branch_name===this.branch_name);
    },
    	
    handleSubmit(e) {
      this.$validator.localize("en", this.dict);
      this.$validator.validate().then(valid => {
        if (valid) {
          this.form_errors=[];
          this.register();
        }
      });
      return true;
    },
    register(){
    axios.post('/api/checkin',{
        branch:this.selected_branch,
        course:this.selected_course,
        institute:this.institute_name,
        start_year:this.start_year,
        end_year:this.end_year,
      }).then((resp)=>{
        if(resp.data.success){
          swal.successDialog('Check-In','Success!','success')
          window.location.href=resp.data.success.redirectUrl;
        }
      });
    },
    selectCourse(selectedCourse){
      if(selected_course.course_level===null){
            this.course_level_select=true;
        }
        if(selected_course.course_type===null){
            this.course_type_select=true;
        }
      this.course_id=selected_course.id;
    },
  },
  props: [,'branches']
};
</script>
