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
                    <select v-model="course_id" class="form-control">
                        <option v-for="course in courses" :key='course.id' :value="course.id">{{course.course_name}}</option>
                    </select>
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
                    <select v-model="branch_id" class="form-control">
                        <option v-for="branch in branches" :key="branch.id" :value="branch.id">{{branch.branch_name}}</option>
                    </select>
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
import FormMixin from "./../components/mixins/form-mixin.js";
import swal from '../components/swal';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
  mixins: [FormMixin],
  components:{
    DatePicker
  },
  data() {
    return {
      institute_name:'',
      selected_course:'',
      course_id:'',
      selected_branch:'',
      branch_id:'',
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
  watch:{
    course_id(val){
      this.selected_course=this.courses.find(node=>node.id===val);
    },
    branch_id(val){
      this.selected_branch=this.branches.find(node=>node.id===val);
    }
  },
  methods: {
    trans: function(string, defaultString) {
      return this.$trans("auth", string, defaultString);
    },
    select_course(){
        if(this.selected_course.course_level===null){
            this.course_level_select=true;
        }
        if(this.selected_course.course_type===null){
            this.course_type_select=true;
        }
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
          window.location.href=resp.data.success.redirectUrl;
        }
      });
    }
  },
  props: ['courses','branches']
};
</script>
