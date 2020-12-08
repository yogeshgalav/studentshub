<template>
  <div class="row">
    <div class="col-md-12">
      <classroom-header />
    </div>
    <div class="col-md-12">
      <div class="card mt-2">
        <div class="card-header">
          <h4 class="mb-1">
            {{ 'Classroom Overview' }}
          </h4>
        </div>
        <div class="card-body">
          <form>
              <div class="form-group  row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Classroom
                Name </label>
              <div class="col-sm-3">
                <div class="text-black">
                  <input
                    id="duration"
                    v-model="form_data.name"
                    type="text"
                    class="form-control"
                    @blur="updateClassroomDetail"
                  >
                </div>
              </div>
            </div>
            <div class="form-group mb-0 row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Subject
              </label>
              <div class="col-sm-10">
                <div class="text-black">
                  {{ classroomDetail.subject_name }}
                </div>
              </div>
            </div>
            <div class="form-group mb-0 row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Course
              </label>
              <div class="col-sm-10">
                <div class="text-black">
                  {{ classroomDetail.course_name }}
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Expected
                Students </label>
              <div class="col-sm-3">
                <div class="text-black">
                  <input
                    id="expected_students"
                    v-model="form_data.expected_students"
                    type="text"
                    class="form-control"
                    @blur="updateClassroomDetail"
                  >
                </div>
              </div>
            </div>
            <div class="form-group  row">
              <label class="col-sm-2 col-form-label text-black font-size-14">Classroom
                duration </label>
              <div class="col-sm-3">
                <div class="text-black">
                  <input
                    id="duration"
                    v-model="form_data.duration"
                    type="text"
                    class="form-control"
                    @blur="updateClassroomDetail"
                  >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label
                    class="text-black"
                    for="event_date_input"
                  >
                    {{ ('Batch Starting Year') }}
                  </label>
                  <div class="input-group-prepend ">
                    <div
                      class="input-group-prepend date"
                      data-provide="datepicker"
                    />
                    <div class="input_icon_frm">
                      <span
                        id="basic-addon1"
                        class="icon_design_input"
                      ><i
                        class="fa fa-calendar"
                      /></span>

                      <date-picker
                        id="start_year"
                        v-model="form_data.start_year"
                        v-validate="'required'"
                        name="start_year"
                        value-type="format"
                        :typeable="true"
                        :type="'year'"
                        :lang="'en'"
                        :input-attr="{id: 'start_year_input', value: form_data.start_year}"
                        placeholder="Start Year"
                        @change="updateClassroomDetail"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <label
                  class="text-black"
                  for="event_date_input"
                >
                  {{ ('Batch Ending Year') }}
                </label>
                <div class="input-group-prepend ">
                  <div
                    class="input-group-prepend date"
                    data-provide="datepicker"
                  />
                  <div class="input_icon_frm">
                    <span
                      id="basic-addon1"
                      class="icon_design_input"
                    ><i
                      class="fa fa-calendar"
                    /></span>
                    <date-picker
                      id="end_year"
                      v-model="form_data.end_year"
                      v-validate="'required'"
                      value-type="format"
                      name="end_year"
                      :typeable="true"
                      :type="'year'"
                      :lang="'en'"
                      :input-attr="{id: 'end_year_input', value: form_data.end_year}"
                      placeholder="End Year"
                      @change="updateClassroomDetail"
                    />
                  </div>
                </div>
              </div>
              <span class="error">{{ yearError }}</span>
            </div>
            <div>{{ register_join_id }}</div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import ClassroomHeader from '../../components/ClassroomHeader';
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
	components: {
		ClassroomHeader,
		DatePicker
	},
	data() {
		return {
			form_data:{
				name: '',
				expected_students: 0,
				duration: 0,
				end_year: '',
				start_year: '',
			},
			register_join_id: '',
		};
	},
	computed:{
		classroomDetail(){
			return this.$store.state.classroom.classroomDetail;
		},
		yearError(){
			var d = new Date();
			var n = d.getFullYear();
			if(this.form_data.start_year>n){
				return 'Please enter currect start year.';
			}else if(this.form_data.end_year && this.form_data.end_year<this.form_data.start_year){
				return 'Please enter currect start and end year.';
			}
			return '';
		}
	},
  watch:{
    classroomDetail(val){
      if(val.id){
        this.form_data={
          name: val.name,
          expected_students: val.expected_students,
          duration: val.classroom_duration,
          end_year: val.batch_end_year,
          start_year: val.batch_start_year,
			  };
      }
    }
  },
	methods:{
		updateClassroomDetail(){
			this.axios.post('/api/classroom/'+this.classroomDetail.id+'/update-detail',this.form_data);
		},      
	},
};

</script>
